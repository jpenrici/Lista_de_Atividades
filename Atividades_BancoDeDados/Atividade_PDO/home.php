<!--
        Atividade - Banco de Dados

        Etapas:
                1) Abra o phpMyAdmin
                2) Crie um usuário 'admin'
                3) Crie um Banco de Dados com o nome "ecommerce_db"
                4) Crie uma Tabela com o SQL:
                
                    CREATE TABLE `product` (
                        `id` int NOT NULL,
                        `name` varchar(100) NOT NULL,
                        `description` text,
                        `price` decimal(6,0) NOT NULL,
                        `discount` int(5) DEFAULT '0',
                        `quantity` int NOT NULL,
                        `image` varchar(100) NOT NULL,
                        `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `category_id` int NOT NULL
                    )

                Obs:
                    Para testes iniciais:
                        product : sem primary key.
                        id      : sem auto incremento.

                5) Utilizar o arquivo db_tools.php

        Para está atividade é necessário um ambiente de Localhost.

        Fontes úteis:
            https://www.php.net/docs.php
            https://www.w3schools.com/php/default.asp

            https://www.php.net/manual/pt_BR/book.pdo.php
            https://www.php.net/manual/pt_BR/pdo.exec.php
            https://www.php.net/manual/pt_BR/pdo.query.php
            https://www.php.net/manual/pt_BR/pdostatement.fetch.php
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP :: Banco de Dados</title>
</head>

<body>

    <h1>Atividade de Banco de Dados</h1>
    <hr>

    <?php

        /*
            Nova Solução
        */
        require "./scripts/db_tools.php";
        require "./config/config.php";

        // Conectar com o BD usando PDO (PHP Data Objects).
        $pdo = connect($hostname, $dbname, $user, $password);
        if ($pdo) {
            echo "Conexão bem sucedida!<br>";
        } 

        // Inserir dados na Tabela "products".
        $names = ["id", "name", "description", "price", "discount", "quantity", "image", "createdAt", "updatedAt", "category_id"];
        
        // Campos
        $name        = "Produto ";
        $description = "Descrição do produto ";
        $price       = 19.90;
        $discount    = 5;
        $quantity    = 10;
        $image       = "https://www.php.net/images/logos/new-php-logo.svg";
        $category_id = "1";

        for ($i = 1; $i < 5; $i++) {
            date_default_timezone_set("America/Sao_Paulo");
            $currentDate = date('Y-m-d H:i:s', time()); // CURRENT_TIMESTAMP
            $data = [
                $names,
                [$i, $name . $i, $description . $i, $price, $discount, $quantity, $image, $currentDate, $currentDate, $category_id]
            ];
            if (insert($pdo, 'product', $data)) {
                echo "Novo dado inserido!<br>";
            }
        }

        // Listar todos os dados inseridos.
        $result = list_all_itens($pdo, 'product');
        if ($result) {
            $total = $result->rowCount();   // rowCount(): método retorna quantidade de linhas.
            $htmlTable = table($names, $result);
            // Exibir
            echo "<p>Encontrados $total itens na Tabela 'product'.</p>";
            echo $htmlTable;
        }

        // Atualizar dado.
        if (update($pdo, "product", "price", 1000, "id", 2)) {
            echo "Novo dado atualizado!<br>";
        }

        // Pesquisar dados.
        $result = find_by_key($pdo, 'product', "id", 2);
        if ($result) {
            $htmlTable = table($names, $result);
            echo $htmlTable;
        }

        // Deletar dados.
        for ($i = 1; $i < 5; $i++) {
            if (delete_by_id($pdo, "product", "id", $i)) {
                echo "Dado deletado!<br>";
            }
        }

        // Desconectar o Banco de Dados.
        $pdo = null;
        
        // Mensagem final de teste.
        echo "<p>PHP Finalizado!</p>";
    ?>

</body>

</html>