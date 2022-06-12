<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaBoutiqueController extends AbstractController
{
    #[Route('/la-boutique', name: 'la_boutique')]
    public function index(): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        return $this->render('la_boutique/index.html.twig', [
            'has_address' => $has_address
        ]);
    }
}
