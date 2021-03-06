<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/address', name: 'account_address')]
    public function index(): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());
        return $this->render('account/address.html.twig', [
            'has_address' => $has_address
        ]);
    }

    #[Route('/compte/address/add', name: 'account_add_address')]
    public function add(Cart $cart,Request $request): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        $address = new Address();
        if (!$address && ($address->getUser() != $this->getUser() || $address->getUser()->isVerified() != true)) {
            $this->redirectToRoute('home');
        }
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());


            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if ($cart->get()) {
                $this->redirectToRoute('order');
            } else {
                $this->redirectToRoute('account_address');
            }

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView(),
            'has_address' => $has_address
        ]);
    }

    #[Route('/compte/address/edit/{id}', name: 'account_edit_address')]
    public function edit(Request $request, AddressRepository $addressRepository, $id): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        $address = $addressRepository->findOneBy(["id" => $id]);
        if (!$address && ($address->getUser() != $this->getUser() || $address->getUser()->isVerified() != true)) {
            $this->redirectToRoute('home');
        }
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());


            $this->entityManager->persist($address);
            $this->entityManager->flush();

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView(),
            'has_address' => $has_address
        ]);
    }

    #[Route('/compte/address/remove/{id}', name: 'account_address_remove')]
    public function remove(AddressRepository $addressRepository, $id): Response
    {
        $address = $addressRepository->findOneBy(["id" => $id]);
        if ($address && $address->getUser() === $this->getUser()) {
        $address = $addressRepository->findOneBy(["id" => $id]);

            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
