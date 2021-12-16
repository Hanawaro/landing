<?php

include_once ROOT . '/components/Database.php';

class PricingModel
{
    function getCarts(): array
    {
        $db = Database::get();
        $carts = array();
        $result = $db->query("SELECT * FROM carts");

        $index = 0;
        while ($row = $result->fetch()) {
            $carts[$index]['id'] = $row['id'];
            $carts[$index]['name'] = $row['name'];
            $carts[$index]['price'] = $row['price'];
            $carts[$index]['period'] = $row['period'];
            $carts[$index]['count'] = $row['count'];
            $carts[$index]['recommended'] = $row['recommended'];
            $index++;
        }
        return $carts;
    }
}