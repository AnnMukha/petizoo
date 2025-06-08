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

}