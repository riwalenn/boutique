<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/nos-produits/', name: 'products')]
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->findWithSearch($search);
        } else {
            $products = $productRepository->findAll();
        }
        return $this->render('product/index.html.twig', [
            'title' => 'Nos produits',
            'products' => $products,
            'form' => $form->createView(),
            'has_address' => $has_address
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug, ProductRepository $productRepository): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        $product = $productRepository->findOneBy(["slug" => $slug]);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'has_address' => $has_address
        ]);
    }

    #[Route('/categorie/{id_category}', name: 'product_category')]
    public function productsByCategory($id_category, ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $has_address = $this->getUser() && !empty($this->getUser()->getAddresses()->getValues());

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $categorie = $categoryRepository->findOneBy(["id" => $id_category]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->findWithSearch($search);
        } else {
            $products = $productRepository->findBy(["category" => $id_category]);
        }
        return $this->render('product/index.html.twig', [
            'title' => $categorie->getName(),
            'products' => $products,
            'form' => $form->createView(),
            'has_address' => $has_address
        ]);
    }
}
