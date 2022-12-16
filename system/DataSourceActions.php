<?php

namespace system;

interface DataSourceActions
{
    public static function all(array $data): array;
    public static function find(array $data): array;
    public static function insert(array $data): array;
    public static function update(array $data): array;
    public static function delete(array $data): array;
}