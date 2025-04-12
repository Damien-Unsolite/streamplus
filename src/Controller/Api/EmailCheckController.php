<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EmailCheckController extends AbstractController
{
    #[Route('/api/check-email', name: 'check_email_unique', methods: ['POST'])]
    public function checkEmailUnique(Request $request, UserRepository $userRepo): JsonResponse
    {
        $email = $request->request->get('email');
        $exists = $userRepo->findOneBy(['email' => $email]) !== null;

        return new JsonResponse(['exists' => $exists]);
    }
}
