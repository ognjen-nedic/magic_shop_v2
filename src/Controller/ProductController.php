<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\RarityRepository;
use App\Repository\TypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list_products')]
    public function list_product(Request $request, ProductRepository $productRepository, TypeRepository $typeRepository, RarityRepository $rarityRepository) {
        $products = $productRepository->findAll();
        
        if($request->request->get('sorting')):
            $products = $productRepository->sort_by_price($request->request->get('select'));
        endif;

        if($request->request->get('filter_by_type')):
            $products = $productRepository->filter_by_type($request->request->get('type_filter_select'));
        endif;

        if($request->request->get('filter_by_rarity')):
            $products = $productRepository->filter_by_rarity($request->request->get('rarity_filter_select'));
        endif;

        /* if($request->request->get('price-range') && $request->request->get('min-price') && $request->request->get('max-price')): */
        if($request->request->get('price-range')):
            $products = $productRepository->filter_by_price_range($request->request->get('min-price'), $request->request->get('max-price'));
        endif; 

        if($request->request->get('reset_filtering')):
            //return new Response(dd($productRepository->max_price_from_each_type()));
            //$products = $productRepository->findAll();
            //dd($productRepository->max_price_from_each_type());
            $products = $productRepository->max_price_from_each_type();
        endif;


        return $this->render('product/index.html.twig', [
            'products' => $products,
            'types' =>  $typeRepository->findAll(),
            'rarities' => $rarityRepository->findAll()
        ]);
    }

    #[Route('/add', name: 'new_product')]
    public function new_product(Request $request, ProductRepository $productRepository, TypeRepository $typeRepository, RarityRepository $rarityRepository) {
        $product = new Product();
        if($request->request->get('form_submit')):
            $product->setProductName($request->request->get('product_name'));
            $type = $typeRepository->find($request->request->get('type'));
            $product->setType($type);
            $rarity = $rarityRepository->find($request->request->get('rarity'));
            $product->setRarity($rarity);
            $product->setProductPrice($request->request->get('product_price'));
            $productRepository->add($product);
            return $this->redirectToRoute('list_products');
        endif;
        return $this->render('product/new.html.twig', [
            'types' =>  $typeRepository->findAll(),
            'rarities' => $rarityRepository->findAll()
        ]);

    }

    #[Route('/edit/{product_id}', name:'edit_product', requirements:["product_id"=>"\d+"])]
    public function edit_product(Product $product, Request $request, ProductRepository $productRepository, TypeRepository $typeRepository, RarityRepository $rarityRepository) {

        if($request->request->get('form_submit')):
            $product->setProductName($request->request->get('product_name'));
            $type = $typeRepository->findOneBy(['type_id'=>$request->request->get('type')]);
            $product->setType($type);
            $rarity = $rarityRepository->findOneBy(['rarity_id'=>$request->request->get('rarity')]);
            $product->setRarity($rarity);
            $product->setProductPrice($request->request->get('product_price'));
            $productRepository->add($product);
            return $this->redirectToRoute('list_products');
        endif;

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'types' =>  $typeRepository->findAll(),
            'rarities' => $rarityRepository->findAll()
        ]);
    }

    #[Route('/{product_id}', name:'delete_product')]
    public function delete_product(Product $product, ManagerRegistry $doctrine) {
        $entityManager = $doctrine->getManager();
        $single_product = $doctrine->getRepository(Product::class)->findOneBy(['product_id' => $product->getId()]);

        $entityManager->remove($single_product);

        $entityManager->flush();
        return $this->redirectToRoute('list_products');
    }
}
