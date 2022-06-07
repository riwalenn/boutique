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
        return $this->render('la_boutique/index.html.twig');
    }
}
