<?php
session_start();
require '../inclusions/database.php';
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($data['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Format email invalide']);
        exit;
    }

    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'Email ou mot de passe incorrect']);
            exit;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!password_verify($password, $user['password'])) {
            echo json_encode(['error' => 'Email ou mot de passe incorrect']);
            exit;
        }

        $_SESSION['user-id'] = $user['unique-id'];
        // Retourne les données utilisateur pour sessionStorage
        echo json_encode([
            'success' => true,
            'user' => [
                'unique-id' => $user['unique-id'],
                'first_name' => $user['first-name'],
                'last_name' => $user['last-name'],
                'email' => $user['email'],
                'bio' => $user['bio'],
                'gender' => $user['gender'],
                'birthday' => $user['birthday'],
                'profile_pic' => $user['profile-pic']
            ],
            'redirect' => '../../home.php'
        ]);
        
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Erreur de base de données']);
    }
    exit;
}

echo json_encode(['error' => 'Requête invalide']);
?>