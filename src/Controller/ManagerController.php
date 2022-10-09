<?php

namespace App\Controller;

use App\Service\HolidayRequestService;
use App\Service\WorkerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/managers")
 */
final class ManagerController extends AbstractController
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
     * @Route("/search_workers", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    public function getWorker(Request $request): JsonResponse
    {
        $workerId = $request->query->get('id');
        return $this->json(['result' => $this->workerService->findWorker($workerId)]);
    }

    /**
     * @Route("/update_holiday_requests", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function processRequest(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $holidayPostRequest = json_decode($request->getContent());

        $response = $this->holidayRequestService->update(
            $holidayPostRequest->holidayRequestId,
            $holidayPostRequest->managerId,
            $holidayPostRequest->status
        );

        return $this->json($serializer->normalize($response, 'json'));
    }

    /**
     * @Route("/worker_holiday_requests", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function search(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $status = $request->query->get('status');

        $response = $this->holidayRequestService->getHolidayRequests($status);

        return $this->json($serializer->normalize($response, 'json'));
    }

    /**
     * @Route("/worker_overlap_requests", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getOverlapRequests(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');

        $response = $this->holidayRequestService->getOverlappingRequests($startDate, $endDate);

        return $this->json($serializer->normalize($response, 'json'));
    }
}