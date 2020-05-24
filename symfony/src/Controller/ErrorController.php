<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="_error")
     */
    public function show()
    {
        return $this->json([
            'message' => 'Wrong Endpoint',
        ] , Response::HTTP_NOT_FOUND);
    }
}
