<?php

namespace App\DataBase;

/**
 * Simple plug interface for injecting to repo
 * I used simple PHP lib named "meekrodb" for test
 * But them not provide interface
 */
interface DatabaseInterface
{
    public static function insert(string $table_name, array $data, ...$parameters): int;

    public static function update(string $table_name, array $data, ...$parameters): int;

    public static function query(string $query, ...$parameters): mixed;
}