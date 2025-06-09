<?php

namespace controllers;

use core\Controller;
use models\Products;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin@petizoo.ua') {
            $this->redirect('/');
        }
    }

    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin@petizoo.ua') {
            $this->redirect('/');
        }
    }
    public function actionDashboard()
    {
        return $this->render();
    }

    public function actionProducts()
    {
        $products = Products::GetAll('all');
        $this->template->setParams([
            'products' => $products
        ]);
        return $this->render('admin/products');
    }

    public function actionOrders()
    {
        return $this->render();
    }
    public function actionAddproduct()
    {
        $this->checkAdmin();

        $product = [
            'name' => '',
            'description' => '',
            'price' => 0.0,
            'stock' => 0,
            'subcategory_id' => '',
            'is_for' => 'cat',
            'image' => ''
        ];

        if ($this->isPost) {
            $product['name'] = $this->post->name;
            $product['description'] = $this->post->description;
            $product['price'] = (float)$this->post->price;
            $product['stock'] = (int)$this->post->stock;
            $product['subcategory_id'] = $this->post->subcategory_id;
            $product['is_for'] = $this->post->is_for;

            if (!empty($_FILES['image']['tmp_name'])) {
                $uploadDir = 'uploads/products/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
                $product['image'] = $uploadDir . $filename;
            }

            \models\Products::add($product);
            return $this->redirect('/admin/products');
        }

        // ✅ Завантаження підкатегорій
        $subcategories = \models\Subcategory::getAll();

        // ✅ Передача і $product, і $subcategories
        $this->template->setParams([
            'product' => $product,
            'subcategories' => $subcategories
        ]);

        return $this->render('admin/addproduct');
    }

    public function actionEditproduct($params)
    {
        $this->checkAdmin();

        $id = $params[0] ?? null;
        if (!$id || !is_numeric($id)) {
            return $this->redirect('/admin/products');
        }

        $product = \models\Products::findByID($id);
        if (!$product) {
            return $this->render('admin/editproduct', ['error' => 'Товар не знайдено']);
        }

        if ($this->isPost) {
            $product['name'] = $this->post->name;
            $product['description'] = $this->post->description;
            $product['price'] = $this->post->price;
            $product['stock'] = $this->post->stock;
            $product['subcategory_id'] = $this->post->subcategory_id;
            $product['is_for'] = $this->post->is_for;

            if (!empty($_FILES['image']['tmp_name'])) {
                $uploadDir = 'uploads/products/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
                $product['image'] = $uploadDir . $filename;
            }

            \models\Products::update($product, ['id' => $id]);
            return $this->redirect('/admin/products');
        }

        $subcategories = \models\Subcategory::getAll();

        // ✅ Ось це важливо — передаємо параметри у шаблон
        $this->template->setParams([
            'product' => $product,
            'subcategories' => $subcategories
        ]);

        return $this->render('admin/editproduct');
    }
    public function actionDeleteproduct($params)
    {
        $this->checkAdmin();
        $id = $params[0];
        \models\Products::deleteByID($id);
        return $this->redirect('/admin/products');
    }
    public function actionUpdatemarks()
    {
        $this->checkAdmin();

        $popular = $_POST['popular'] ?? [];
        $discounted = $_POST['discounted'] ?? [];
        $newPrices = $_POST['new_price'] ?? [];

        $products = \models\Products::GetAll('all');

        foreach ($products as $product) {
            $id = $product['id'];
            $isPopular = isset($popular[$id]) ? 1 : 0;
            $isDiscounted = isset($discounted[$id]) ? 1 : 0;
            $basePrice = $product['price'];
            $newPrice = isset($newPrices[$id]) && $newPrices[$id] !== '' ? (float)$newPrices[$id] : null;

            if ($isDiscounted && $newPrice !== null && $newPrice < $basePrice) {
                \models\Products::update([
                    'is_popular' => $isPopular,
                    'is_discounted' => 1,
                    'new_price' => $newPrice
                ], ['id' => $id]);
            } elseif (!$isDiscounted) {
                \models\Products::update([
                    'is_popular' => $isPopular,
                    'is_discounted' => 0,
                    'new_price' => null
                ], ['id' => $id]);
            } else {
                // Якщо is_discounted залишився 1, але ціна не змінилась/невалідна — лише популярне
                \models\Products::update([
                    'is_popular' => $isPopular
                ], ['id' => $id]);
            }
        }

        // Після збереження — лишаємося на цій самій сторінці
        $updatedProducts = \models\Products::GetAll('all');
        $this->template->setParam('products', $updatedProducts);
        return $this->render('admin/markproducts');
    }
    public function actionMarkproducts()
    {
        $this->checkAdmin();

        $products = \models\Products::GetAll('all');
        $this->template->setParam('products', $products);
        return $this->render('admin/markproducts');
    }
}