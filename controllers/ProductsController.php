<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Products;

class ProductsController extends Controller
{
    public function actionIndex()
    {
        $animal = $_GET['animal'] ?? 'all';
        $category = $_GET['category'] ?? 'all';

        $conditions = [];

        if ($animal !== 'all') {
            $conditions['is_for'] = $animal;
        }

        if ($category !== 'all') {
            $conditions['subcategory_id'] = $category;
        }

        $products = \core\Core::get()->db->select('products', '*', $conditions);
        $subcategories = \core\Core::get()->db->select('subcategories');

        $this->template->setParams([
            'products' => $products,
            'animal' => $animal,
            'category' => $category,
            'categories' => $subcategories
        ]);

        return $this->render('products/index');
    }

}

