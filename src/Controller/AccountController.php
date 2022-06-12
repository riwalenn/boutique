<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'account')]
    public function index(): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        return $this->render('account/index.html.twig', [
            'has_address' => $has_address
        ]);
    }
}
