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
     * @Route("/remaning_leaves", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    public function getBalance(Request $request): JsonResponse
    {
        return $this->json(['result' => $this->workerService->findLeaveBalance($request->query->get('id'))]);
    }

    /**
     * @Route("/request_leaves", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    public function requestLeaves(Request $request): JsonResponse
    {
        $workerHolidayRequest = json_decode($request->getContent());

        $leaveRequest = new HolidayRequest();
        $leaveRequest->setAuthor($workerHolidayRequest->author);
        $leaveRequest->setVacationStartDate(new DateTime($workerHolidayRequest->vacationStartDate));
        $leaveRequest->setVacationEndDate(new DateTime($workerHolidayRequest->vacationEndDate));

        if ($leaveRequest->validateVacationDate()) {
            throw new \Exception('Vacation dates are incorrect');
        }

        $result = $this->holidayRequestService->add($leaveRequest);

        return $this->json(['result' => 'Your leave request created with ID: ' . $result->getId()]);
    }

    /**
     * @Route("/requests", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function search(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $workerId = $request->query->get('id');
        $status = $request->query->get('status');

        if (empty($workerId)) {
            throw new \Exception('Worker Id is missing');
        }

        $response = $this->holidayRequestService->getLeavesRequests($status, $workerId);

        return $this->json($serializer->normalize($response, 'json'));
    }
}