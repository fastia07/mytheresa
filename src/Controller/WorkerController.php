<?php

namespace App\Controller;

use App\Entity\HolidayRequest;
use App\Service\HolidayRequestService;
use App\Service\WorkerService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/workers")
 */
final class WorkerController extends AbstractController
{
    /**
     * @var WorkerService
     */
    private $workerService;
    /**
     * @var HolidayRequestService
     */
    private $holidayRequestService;

    /**
     * @param WorkerService $workerService
     * @param HolidayRequestService $holidayRequestService
     */
    public function __construct(
        WorkerService         $workerService,
        HolidayRequestService $holidayRequestService
    )
    {
        $this->workerService = $workerService;
        $this->holidayRequestService = $holidayRequestService;
    }

    /**
     * @Route("/{id}/remaning_leaves", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    public function getBalance(int $id): JsonResponse
    {
        return $this->json(['result' => $this->workerService->findLeaveBalance($id)]);
    }

    /**
     * @Route("/holiday_requests", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    public function addRequest(Request $request): JsonResponse
    {
        $workerHolidayRequest = json_decode($request->getContent());

        $holidayRequest = new HolidayRequest();
        $holidayRequest->setAuthor($workerHolidayRequest->author);
        $holidayRequest->setVacationStartDate(new DateTime($workerHolidayRequest->vacationStartDate));
        $holidayRequest->setVacationEndDate(new DateTime($workerHolidayRequest->vacationEndDate));

        if ($holidayRequest->validateVacationDate()) {
            throw new \Exception('Vacation dates are incorrect');
        }

        $result = $this->holidayRequestService->add($holidayRequest);

        return $this->json(['result' => 'Your holiday request created with ID: ' . $result->getId()]);
    }

    /**
     * @Route("/{id}/holiday_requests", methods={"GET"})
     * @param int $id
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function search(int $id, Request $request, SerializerInterface $serializer): JsonResponse
    {
        if (empty($id)) {
            throw new \Exception('Worker Id is missing');
        }

        $status = $request->query->get('status');

        $response = $this->holidayRequestService->getHolidayRequests($status, $id);

        return $this->json($serializer->normalize($response, 'json'));
    }
}