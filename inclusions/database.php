<?php 
    try {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'social-network-app';

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        http_response_code(50);
        echo "Erreur lors de la connexion à la base de données :" . $e->getMessage();
        exit;
    }

?>