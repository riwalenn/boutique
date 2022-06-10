<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/address', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/compte/address/add', name: 'account_add_address')]
    public function add(Request $request): Response
    {
        $address = new Address();
        if (!$address && $address->getUser() != $this->getUser()) {
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
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/address/edit/{id}', name: 'account_edit_address')]
    public function edit(Request $request, AddressRepository $addressRepository, $id): Response
    {
        $address = $addressRepository->findOneBy(["id" => $id]);
        if (!$address && $address->getUser() != $this->getUser()) {
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
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/address/remove/{id}', name: 'account_address_remove')]
    public function remove(AddressRepository $addressRepository, $id): Response
    {if ($address && $address->getUser() === $this->getUser()) {
        $address = $addressRepository->findOneBy(["id" => $id]);

            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
