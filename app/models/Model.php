<?php

namespace app\models;

use system\DataBase;

abstract class Model
{
    protected static string $tableName;
    protected static array $columns;

    public function getTableName(): string
    {
        return static::$tableName;
    }

    public function getColumns(): array
    {
        return static::$columns;
    }

    public function all()
    {
        return DataBase::all($this);
    }

    public  function find($id)
    {
        return DataBase::find($this, $id);
    }

    public  function insert($data)
    {
        return DataBase::insert($this, $data);
    }

    public  function update($data)
    {
        return DataBase::update($this, $data);
    }

    public  function delete($id)
    {
        return DataBase::delete($this, $id);
    }
}



