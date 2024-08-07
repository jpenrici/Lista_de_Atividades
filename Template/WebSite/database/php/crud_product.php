<?php
/*
    CRUD (Create Read Update Delete).

    Referências:
        https://www.php.net/docs.php
        https://www.w3schools.com/php/default.asp

        https://www.php.net/manual/pt_BR/book.pdo.php
        https://www.php.net/manual/pt_BR/pdo.exec.php
        https://www.php.net/manual/pt_BR/pdo.query.php
        https://www.php.net/manual/pt_BR/pdostatement.fetch.php
*/  

require_once 'db_functions.php';

function product_attributes_name()
{
    return ["id", "name", "description", "price", "discount", "quantity",
            "image", "createdAt", "updatedAt", "category_id"];
}

function create_product($database, $name, $description, $price, $discount, $quantity, $image, $category_id)
{
    $result = null;

    // Checar entradas.
    if (is_null_or_empty($database)) {
        return false;
    }

    if (is_null_or_empty($name)) {
        return false;
    }

    $description = is_null($description) ? "No description" : $description;
    $price = (is_null($price) || !is_numeric($price)) ? "0" : ((int)$price < 0 ? "0" : $price);
    $discount = (is_null($discount) || !is_numeric($discount)) ? "0" : ((int)$discount < 0 ? "0" : $discount);
    $quantity = (is_null($quantity) || !is_numeric($quantity)) ? "0" : ((int)$quantity < 0 ? "0" : $quantity);
    $image = is_null($image) ? "No image" : $image;
    $category_id = (is_null($category_id) || !is_numeric($category_id)) ? "0" : ((int)$category_id < 0 ? "0" : $category_id);

    // Conectar.
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Procurar.
    $sql = "SELECT * FROM `product` WHERE BINARY `name` = '" . $name . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count > 0) {
            // echo "Encontrado " . $count . " registros para " . $name . "! Novo registro não será criado!" . PHP_EOL;
            return false;
        }
    }

    // Criar.
    $sql = "INSERT INTO `product` (`id`, `name`, `description`, `price`, `discount`, `quantity`, `image`, `createdAt`, `updatedAt`, `category_id`) ";
    $sql .= "VALUES (NULL, '" . $name . "', '" . $description . "', '" . $price . "', '" . $discount . "', '" . $quantity . "', '" . $image;
    $sql .= "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '" . $category_id . "');";
    $result = command($pdo, $sql);

    // Desconectar.
    $pdo = null;

    return !is_null($result);
}

function read_product_by_name($database, $name)
{
    $result = null;

    // Checar entradas.
    if (is_null_or_empty($database)) {
        return null;
    }

    if (is_null_or_empty($name)) {
        return null;
    }

    // Conectar.
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Procurar.
    $sql = "SELECT * FROM `product` WHERE `name` = '" . $name . "';";
    $result = command($pdo, $sql);

    // Desconectar.
    $pdo = null;

    return $result;
}

function read_product_by_id($database, $id)
{
    $result = null;

    // Checar entradas.
    if (is_null_or_empty($database)) {
        return null;
    }

    if (is_null_or_empty($id)) {
        return null;
    }

    // Conectar.
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Procurar.
    $sql = "SELECT * FROM `product` WHERE `id` = '" . $id . "';";
    $result = command($pdo, $sql);

    // Desconectar.
    $pdo = null;

    return $result;
}

function update_product_by_id($database, $id, $name, $description, $price, $discount, $quantity, $image, $category_id)
{
    $result = null;

    // Checar entradas.
    if (is_null_or_empty($database)) {
        return false;
    }

    if (is_null_or_empty($id)) {
        return false;
    }

    $price = (is_null($price) || !is_numeric($price)) ? "" : ((int)$price < 0 ? "" : $price);
    $discount = (is_null($discount) || !is_numeric($discount)) ? "" : ((int)$discount < 0 ? "" : $discount);
    $quantity = (is_null($quantity) || !is_numeric($quantity)) ? "" : ((int)$quantity < 0 ? "" : $quantity);
    $image;
    $category_id = (is_null($category_id) || !is_numeric($category_id)) ? "" : ((int)$category_id < 0 ? "" : $category_id);

    // Conectar.
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Procurar.
    $result = find_by_id($pdo, 'product', $id);
    if ($result) {
        // Atualizar.
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $new_name = (empty($name) || is_null($name)) ? $data['name'] : $name;
        $new_description = (empty($description) || is_null($description)) ? $data['description'] : $description;
        $new_price = (empty($price) || is_null($price)) ? $data['price'] : $price;
        $new_discount = (empty($discount) || is_null($discount)) ? $data['discount'] : $discount;
        $new_quantity = (empty($quantity) || is_null($quantity)) ? $data['quantity'] : $quantity;
        $new_image = (empty($image) || is_null($image)) ? $data['image'] : $image;
        $new_category_id = (empty($category_id) || is_null($category_id)) ? $data['category_id'] : $category_id;
        $updateAt = date("Y-m-d H:i:s");
        // echo "Valores: " . $id . ", " . $new_name . ", " . $new_description . ", " . $new_price . ", " . $new_discount . ", " . $new_quantity;
        // echo ", " . $new_image . ", " . $new_category_id . ", " . $updateAt . PHP_EOL;

        $sql = "UPDATE `product` SET `name` = '" . $new_name . "', `description` = '" . $new_description . "', `price` = '" . $new_price;
        $sql .= "', `discount` = '" . $new_discount . "', `quantity` = '" . $new_quantity . "', `image` = '" . $new_image;
        $sql .= "', `updatedAt`  = '" . $updateAt . "', `category_id` = '" . $new_category_id . "' WHERE `product`.`id` = '" . $id . "';";
        $result = command($pdo, $sql);
    }

    // Desconectar.
    $pdo = null;

    return !is_null($result);
}

function update_product_quantity_by_id($database, $id, $quantity)
{
    return update_product_by_id($database, $id, "", "", "", "", $quantity, "", "");
}

function delete_product_by_id($database, $id)
{
    // Conectar.
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);
    
    // Procurar.
    $result = delete_by_id($pdo, 'product', 'id', $id);

    // Desconectar.
    $pdo = null;

    return !$result;
}

function list_all_products($database)
{
   // Conectar.
   $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

   // Procurar.
   $result = list_all_itens($pdo, 'product');
   
   // Desconectar.
   $pdo = null;
   
   return $result;
}

function current_quantity($pdo, $id, $quantity)
{
    // Checar entradas.
    if (is_null($pdo)) {
        return 0;
    }

    if (is_null_or_empty([$id, $quantity])) {
        return 0;
    }

    if (!is_numeric($quantity)) {
        return 0;
    }

    if ((int)$quantity < 1) {
        return 0;
    }

    $result = find_by_id($pdo, 'product', $id);
    if ($result) {
        $count = $result->rowCount();
        if ($count != 1) {
            echo "Found " . $count . " entries for " . $id . "!" . PHP_EOL;
            return 0;
        }
    }

    $data = $result->fetch(PDO::FETCH_ASSOC);
    $free = (int)$data['quantity'] - (int)$quantity;
    if ($free < 1) {
        echo "Quantidade requerida : " . $quantity . PHP_EOL;
        echo "Quantidade em estoque: " . $data['quantity'] . PHP_EOL;
        echo "Quantidade de produto com id " . $id . " insuficiente para reservar compra." . PHP_EOL;
        return 0;
    }

    return $free;
}

// crud_product.php