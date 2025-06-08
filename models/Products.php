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
        if (in_array($filter, ['cat', 'dog', 'both'])) {
            $result = self::findByCondition(["is_for" => $filter]);
            return $result ?? [];
        } else {
            return static::findAll(); // ← Використовуємо базову реалізацію Model
        }
    }

    public static function getTopPopular($limit = 4)
    {
        $query = "SELECT * FROM " . self::$tableName . " ORDER BY stock DESC LIMIT $limit";
        return Core::get()->db->performQuery($query);
    }
    public static function add($data)
    {
        return Core::get()->db->insert(self::$tableName, $data);
    }
    public static function update($data, $where)
    {
        return \core\Core::get()->db->update(self::$tableName, $data, $where);
    }

}
