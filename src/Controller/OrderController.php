<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'order')]
    public function index(): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        if (!$this->getUser()->getAddresses()->getValues()) {
            $this->redirectToRoute('account_add_address');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'has_address' => $has_address
        ]);
    }
}
