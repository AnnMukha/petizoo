<?php
namespace models;

use core\Model;
use core\Core;

class Orders extends Model
{
    public static function getAllWithDetails(): array
    {
        $db = \core\Core::get()->db;
        $sql = "
        SELECT o.*,
            IFNULL(u.login, o.full_name) AS login,
            (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) AS items_count
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
    ";

        return $db->performQuery($sql); // результат повертається як масив
    }
}