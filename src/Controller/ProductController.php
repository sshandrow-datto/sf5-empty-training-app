<?php

namespace App\Controller;

use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /** @var ProductRepository */
    public $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * @Route("/api/products", methods={"GET"})
     */
    public function getCollection(): array
    {
        $products = $this->productRepo->findAll();

        return $this->$products;
    }
}

// you should never see the word 'new' be a service. your service
// should be in a service container