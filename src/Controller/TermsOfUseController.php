<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsOfUseController extends AbstractController
{
    #[Route('/terms-of-use', name: 'terms_of_use')]
    public function index(): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        return $this->render('terms_of_use/index.html.twig', [
            'has_address' => $has_address
        ]);
    }
}
