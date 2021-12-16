<?php

class Database {

    public static function get(): PDO {
        $params = include(ROOT.'/config/db_params.php');
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $params['user'], $params['password'], $opt);
    }

}