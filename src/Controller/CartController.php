<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart, ProductRepository $productRepository): Response
    {
       return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->increase($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    #[Route('/cart/delete/{id}', name: 'delete_my_product')]
    public function deleteProduct(Cart $cart, $id): Response
    {
        $cart->deleteProduct($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_my_product')]
    public function decreaseProduct(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }
}
