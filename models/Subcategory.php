<?php

namespace models;

use core\Model;

class Subcategory extends Model
{
    public static $tableName = 'subcategories';

    public static function getAll()
    {
        return self::findAll();
    }

    public static function getById($id)
    {
        return self::findByID($id);
    }
}