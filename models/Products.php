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
 * @property int $stock
 * @property int $subcategory_id
 * @property string $is_for
 */
class Products extends Model
{
    public static $tableName = 'products';

    public static function GetAll($filter = 'all')
    {
        if (in_array($filter, ['cat', 'dog'])) {
            return self::findByCondition(["is_for" => $filter]); // 🐱 або 🐶
        } else {
            return Core::get()->db->select(self::$tableName); // всі
        }
    }
    public static function getTopPopular($limit = 4)
    {
        $query = "SELECT * FROM " . self::$tableName . " ORDER BY stock DESC LIMIT $limit";
        return \core\Core::get()->db->performQuery($query);
    }
}
