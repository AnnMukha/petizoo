<?php

namespace models;

use core\Model;
use core\Core;

class Subcategory extends Model
{
    public static $tableName = 'subcategories';

    public static function getAll()
    {
        return self::findAll();
    }

    public static function getById($id)
    {
        return self::findById($id);
    }

    public static function getAllWithCategory()
    {
        $db = Core::get()->db;
        return $db->select('subcategories s JOIN categories c ON s.category_id = c.id', 's.*, c.name AS category_name');
    }

    public static function add($name, $category_id)
    {
        self::insert([
            'name' => $name,
            'category_id' => $category_id
        ]);
    }

    public static function delete($id)
    {
        self::deleteByCondition(['id' => $id]);
    }

    public static function findByAnimal($animal) {
        return self::findByCondition(['is_for' => $animal]);
    }
    public static function findLinkedToAnimal($animal)
    {
        $sql = "
        SELECT DISTINCT s.*
        FROM subcategories s
        JOIN products p ON s.id = p.subcategory_id
        WHERE p.is_for = :animal
    ";
        return \core\Core::get()->db->selectByQuery($sql, ['animal' => $animal]);
    }
}
