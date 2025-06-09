<?php

namespace models;

use core\Model;
use core\DB;

class Categories extends Model
{
    public static function getTableName()
    {
        return 'categories';
    }

    public static function add($name)
    {
        self::insert(['name' => $name]);
    }

    public static function delete($id)
    {
        self::deleteByCondition(['id' => $id]);
    }

    public static function getAll(): array
    {
        return self::findAll();
    }

    public static function findAll(): array
    {
        $db = new DB('localhost', 'petizoo', 'root', 'root'); // 👈 або отримай через Core
        return $db->select(static::getTableName());
    }
}

