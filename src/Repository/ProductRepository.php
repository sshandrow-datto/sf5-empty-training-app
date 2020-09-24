<?php

namespace App\Repository;

use App\Model\Product;
use PDO;

class ProductRepository
{
    public function findAll(): array
    {
        $pdo = new PDO('sqlite:///var/www/var/data.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $products = [];
        $result = $pdo->query('SELECT * FROM product')->fetchAll();
        foreach ($result as $row) {
            $product = new Product();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setDescription($row['description']);

            $products[] = $product;
        }

        return $products;
    }
}