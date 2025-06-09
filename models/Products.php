<?php

namespace models;

use core\Model;
use core\Core;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $image
 * @property int $quantity
 * @property int $subcategory_id
 * @property string $is_for
 */
class Products extends Model
{
    public static $tableName = 'products';

    public static function GetAll($filter = 'all')
    {
        if (in_array($filter, ['cat', 'dog', 'both'])) {
            return self::findByCondition(["is_for" => $filter]) ?? [];
        } else {
            return static::findAll();
        }
    }

    public static function getTopPopular($limit = 10)
    {
        return \core\Core::get()->db->select('products', '*', [
            'is_popular' => 1
        ], ['LIMIT' => $limit]);
    }

    public static function add($data)
    {
        return Core::get()->db->insert(self::$tableName, $data);
    }

    public static function update($data, $where)
    {
        return Core::get()->db->update(self::$tableName, $data, $where);
    }

    public static function increaseStock($productId, $qty)
    {
        $product = self::findByID($productId);
        if ($product) {
            $newQty = $product['quantity'] + $qty;
            self::updateByCondition(['id' => $productId], ['quantity' => $newQty]);
        }
    }

    public static function addQuantity($product_id, $amount): void
    {
        $product = self::findById($product_id);
        if ($product) {
            $newQuantity = $product['quantity'] + $amount;
            self::updateByCondition(['id' => $product_id], ['quantity' => $newQuantity]);
        }
    }
}
