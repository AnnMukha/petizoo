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
            $newStatus = $_POST['status'] ?? null;

            if ($orderId && $newStatus) {
                $db = \core\Core::get()->db;

                // Отримати поточний статус
                $current = $db->select('orders', ['status'], ['id' => $orderId])[0] ?? null;
                if (!$current)
                    return $this->redirect('/admin/orders');

                // Якщо замовлення змінюється на "Скасовано"
                if ($newStatus === 'Скасовано' && $current['status'] !== 'Скасовано') {
                    $items = $db->select('order_items', '*', ['order_id' => $orderId]);
                    foreach ($items as $item) {
                        // Повернути товар на склад
                        $db->performQuery(
                            "UPDATE products SET stock = stock + :qty WHERE id = :pid",
                            ['qty' => $item['quantity'], 'pid' => $item['product_id']]
                        );
                    }
                }

                // Оновити статус замовлення
                $db->update('orders', [
                    'status' => $newStatus
                ], ['id' => $orderId]);

                // Якщо це AJAX-запит
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
}
