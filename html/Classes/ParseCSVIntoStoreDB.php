<?php

namespace Classes;

use PDO;

class ParseCSVIntoStoreDB
{
    public static function parseCSV($csv_file_name, $db)
    {
        $sql_insert_category = "INSERT INTO categories (`id`, `category`)
            VALUES (?, ?)";

        $sql_insert_product = "INSERT INTO products
            (`id`, `category_id`, `price`,
            `stock`, `last_purchase_date`)
            VALUES (?, ?, ?, ?, ?)";

        $sql_insert_productLocale = "INSERT INTO productLocale
            (`product_id`, `locale_id`, `name`, `description`)
            VALUES (?, ?, ?, ?)";

        $sql_delete_categories = "DELETE FROM categories";
        $sql_delete_products = "DELETE FROM products";
        $sql_delete_productLocale = "DELETE FROM productLocale";

        /* Map Rows and Loop Through Them */
        $rows = array_map('str_getcsv', file($csv_file_name));
        array_shift($rows);

        $db->run($sql_delete_productLocale);
        $db->run($sql_delete_products);
        $db->run($sql_delete_categories);

        $category_id = 1;
        $product_id = 1;

        foreach ($rows as $row) {
            if ($row[0] == '') {
                $db->run($sql_insert_category, [$category_id, $row[1]]);
                $last_category_id = $db->pdo->lastInsertId('categories');
                $category_id++;
            } else {
                $stmt = $db->pdo->prepare($sql_insert_product);
                $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $last_category_id, PDO::PARAM_INT);
                $stmt->bindParam(3, $row[7]);
                $stmt->bindParam(4, $row[8], PDO::PARAM_INT);
                $stmt->bindParam(5, $row[9]);

                $stmt->execute();
                $last_product_id = $db->pdo->lastInsertId('products');
                $product_id++;

                //Insert productLocale for spanish(1), english(2) and french(3).
                $db->run($sql_insert_productLocale, [$last_product_id, '1', $row[1], $row[4]]);
                $db->run($sql_insert_productLocale, [$last_product_id, '2', $row[2], $row[5]]);
                $db->run($sql_insert_productLocale, [$last_product_id, '3', $row[3], $row[6]]);
            }
        }
    }
}