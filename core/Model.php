<?php

namespace core;

class Model
{
    protected $fieldsArray;
    protected static $primaryKey = 'id';
    protected static $tableName = '';

    public function __construct() {
        $this->fieldsArray = [];
    }
    public function __set($name, $value){
        $this->fieldsArray[$name] = $value;
    }
    public function __get($name){
        return $this->fieldsArray[$name];
    }
    public static function deleteByID($id) {
        Core::get()->db->delete(static::$tableName, [static::$primaryKey => $id]);
}
    public static function deleteByCondition($conditionAssocArray) {
        Core::get()->db->delete(static::$tableName, $conditionAssocArray);
}
    public static function findByID($id) {
        $arr = Core::get()->db->select(static::$tableName, '*',[static::$primaryKey => $id]);
        if (count($arr)>0)
            return $arr[0];
        else
            return null;
    }
    public static function findByCondition($conditionAssocArray) {
        $arr = Core::get()->db->select(static::$tableName, '*', $conditionAssocArray);
        return is_array($arr) ? $arr : []; // гарантує масив
    }
    public function save() {
        $isInsert = false;
        if (!isset($this->{static::$primaryKey}))
            $isInsert = true;
        else{
            $value = $this->{static::$primaryKey};
            if (empty($value))
                $isInsert = true;
        }
        if ($isInsert) //insert
        {
            Core::get()->db->insert(static::$tableName, $this->fieldsArray);
        } else //update
        {
            Core::get()->db->update(static::$tableName, $this->fieldsArray,
                [
                    static::$primaryKey => $this->{static::$primaryKey}
                ]);
        }
    }
    public static function findAll(): array
    {
        $result = \core\Core::get()->db->select(static::$tableName);
        return is_array($result) ? $result : [];
    }
}