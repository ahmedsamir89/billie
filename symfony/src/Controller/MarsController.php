<?php

namespace App\Controller;

use App\Service\MarsTimeConverter;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarsController extends AbstractController
{

    private $timeConverter;

    public function __construct(MarsTimeConverter $timeConverter)
    {
        $this->timeConverter = $timeConverter;
    }

    /**
     * @Route("/mars/time", name="time")
     * @param Request $request
     * @return JsonResponse
     */
    public function time(Request $request): JsonResponse
    {
        try {
            $statusCode = Response::HTTP_OK;
            $earthDateTime = $request->get('earthDate', 'now');
            $dateTime = $this->getUtcTime($earthDateTime);
            $response = $this->timeConverter->getMarsResponse($dateTime);
        } catch (Exception $exception) {
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response = [
              'message' => $exception->getMessage()
            ];
        }
        return $this->json([
            'data' => $response,
        ], $statusCode);
    }

    /**
     * @param string $earthDateTime
     * @return DateTime
     * @throws Exception
     */
    private function getUtcTime(string $earthDateTime): DateTime
    {
        try {
            return new DateTime($earthDateTime, new \DateTimeZone('UTC'));
        } catch (Exception $exception) {
            throw new Exception('Wrong date format, format should be valid date format');
        }
    }
}
