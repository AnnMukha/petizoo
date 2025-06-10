<?php
namespace controllers;

use core\Controller;

class AdminOrdersController extends Controller
{
    public function actionIndex()
    {
        $orders = \core\Core::get()->db->select('orders');
        $this->template->setParam('orders', $orders);
        return $this->render('admin/orders');
    }

    public function actionVieworder($params)
    {
        $id = $params[0] ?? null;
        if (!$id) {
            return $this->redirect('/admin/orders');
        }

        $order = \core\Core::get()->db->select('orders', '*', ['id' => $id])[0] ?? null;
        if (!$order) {
            return $this->redirect('/admin/orders');
        }

        $items = \core\Core::get()->db->performQuery(
            "SELECT oi.*, p.name, p.image FROM order_items oi
         JOIN products p ON oi.product_id = p.id
         WHERE oi.order_id = :order_id", ['order_id' => $id]
        );

        $this->template->setParams([
            'order' => $order,
            'items' => $items
        ]);
        return $this->render('admin/vieworder');
    }

    public function actionUpdatestatus()
    {
        if ($this->isPost) {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($orderId && $status) {
                \core\Core::get()->db->update('orders', [
                    'status' => $status
                ], ['id' => $orderId]);

                // Якщо це AJAX-запит, завершити тут
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    exit('OK');
                }

                return $this->redirect('/admin/orders');
            }

            $_SESSION['error'] = 'Некоректні дані для оновлення.';
            return $this->redirect('/admin/orders');
        }

        return $this->redirect('/admin/orders');
    }
    public function actionOrder($params)
    {
        $id = $params[0] ?? null;
        if (!$id) return $this->redirect('/admin/orders');

        $order = \core\Core::get()->db->select('orders', '*', ['id' => $id])[0] ?? null;
        if (!$order) return $this->redirect('/admin/orders');

        $items = \core\Core::get()->db->performQuery(
            "SELECT oi.*, p.name, p.image 
         FROM order_items oi 
         JOIN products p ON oi.product_id = p.id 
         WHERE oi.order_id = :order_id", ['order_id' => $id]
        );

        $this->template->setParams([
            'order' => $order,
            'items' => $items
        ]);
        return $this->render('/profile/order');
    }
}
