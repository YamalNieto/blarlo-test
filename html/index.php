<?php

    use Classes\DB;
    use Classes\HttpAcceptLanguageHeaderLocaleDetector;
    use Classes\ParseCSVIntoStoreDB;

    require 'Classes/HttpAcceptLanguageHeaderLocaleDetector.php';
    require 'Classes/DB.php';
    require 'Classes/ParseCSVIntoStoreDB.php';

    $db = new DB('store', 'root', 'admin');
    ParseCSVIntoStoreDB::parseCSV('test.csv', $db);

    $sql = "SELECT products.price, products.stock, 
            products.last_purchase_date, productLocale.name, 
            productLocale.description, categories.category 
            FROM products, productLocale, locale, categories
            WHERE products.id = productLocale.product_id 
            AND productLocale.locale_id = locale.id
            AND products.category_id = categories.id  
            AND locale.iso = ?";

    $locales = HttpAcceptLanguageHeaderLocaleDetector::detect();
    switch (substr($locales[0], 0, 2)) {
        case 'es':
            $locale = 'esp';
            $header = 'Tabla de productos';
            break;
        case 'en':
            $locale = 'eng';
            $header = 'Products table';
            break;
        case 'fr':
            $locale = 'fra';
            $header = 'Tableau des produits';
            break;
    }

    $stmt = $db->run($sql, [$locale]);
    $products = $stmt->fetchAll();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba Blarlo</title>
</head>
<body>
    <h1><?php echo $header; ?></h1>
    <table>
        <thead>
            <tr>
                <td>Categoría</td>
                <td>Nombre</td>
                <td>Descripción</td>
                <td>Precio</td>
                <td>Stock</td>
                <td>Última compra</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($products as $product) {
                    echo "<tr>
                            <td>" . $product['category'] . "</td>
                            <td>" . $product['name'] . "</td>
                            <td>" . $product['description'] . "</td>
                            <td>" . $product['price'] . "</td>
                            <td>" . $product['stock'] . "</td>
                            <td>" . $product['last_purchase_date'] . "</td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>