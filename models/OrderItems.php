<?php
namespace models;

use core\Model;

class OrderItems extends Model
{
    public static function getTableName(): string
    {
        return 'order_items';
    }

    public static function getByOrderId($orderId)
    {
        return self::findByCondition(['order_id' => $orderId]);
    }
}