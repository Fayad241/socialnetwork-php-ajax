<?php 
    session_start();
    require '../inclusions/database.php';
    error_reporting(0); // Désactive l'affichage des erreurs
    ini_set('display_errors', 0);
    header('Content-Type: application/json');

    $data = $_POST;
    if (empty($data) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
        $data = json_decode(file_get_contents('php://input'), true);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        if(isset($_POST['mode']) && $_POST['mode'] === 'check-email') {
            // $email = trim($_POST['email']);

            $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                echo json_encode(['error' => 'Format email invalide']);
                exit;
            }

            try {
                $sql = "SELECT id FROM users WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $exists = $stmt->rowCount() > 0;
                echo json_encode(['exists' => $exists]);
                exit;
            } catch(PDOException $e) {
                echo json_encode(['error' => 'Erreur base de données']);
            }
            exit;
        }
    }

    // if(!isset($_POST['last-name'], $_POST['first-name'], $_POST['email'], $_POST['password'], $_POST['confirm-password'], $_POST['gender'], $_POST['birthday'], $_FILES['profile-pic'])) {

    //     http_response_code(400);
    //     echo "Champs obligatoires manquants";
    //     exit();
    // }

    // $lastName = trim($_POST['last-name']);
    // $firstName = trim($_POST['first-name']);
    // $email = trim($_POST['email']);
    // $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
    // $gender= trim($_POST['gender']);
    // $birthday = trim($_POST['birthday']);
    // $password = trim($_POST['password']);
    // $confirmPassword = trim($_POST['confirm-password']);

    // Traitement des données
    $userData = [
        'last-name' => trim($data['last-name']),
        'first-name' => trim($data['first-name']),
        'email' => trim($data['email']),
        'bio' => $data['bio'] ?? null,
        'gender' => trim($data['gender']),
        'birthday' => trim($data['birthday']),
        'password' => trim($data['password']),
        'confirm-password' => trim($data['confirm-password'])
    ];

    if($userData['password'] !== $userData['confirm-password']) {
        http_response_code(400);
        echo "Les mots de passes ne correspondent pas";
        exit();
    }

    if(isset($_FILES['profile-pic'])) {
        $img_name = $_FILES['profile-pic']['name'];
        $tmp_name = $_FILES['profile-pic']['tmp_name'];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);
        
        // Vérification de l'extension de l'image 
        $extensions = ['png', 'jpeg', 'jpg', 'webp'];
        if(in_array($img_ext, $extensions) === true) {
            $new_img_name = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $img_ext;;
            
            if(move_uploaded_file($tmp_name, "../profile-pic/".$new_img_name)) {
                $randomId = rand(time(), 10000000);            
            }
        }
    }

    // Vérifie si l'email existe déjà
    $sqlCheck = "SELECT id FROM users WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $userData['email']);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        http_response_code(409);
        echo "Cet email est déjà utilisé";
        exit();
    }

    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    try {
        $sql = "INSERT INTO users (`unique-id`, `last-name`, `first-name`, `email`, `bio`, `password`, `gender`, `birthday`, `profile-pic`) VALUES (:unique_id, :last_name, :first_name, :email, :bio, :password, :gender, :birthday, :profile_pic)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('unique_id', $randomId);
        $stmt->bindParam('last_name', $lastName);
        $stmt->bindParam('first_name', $firstName);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('bio', $bio);
        $stmt->bindParam('password', $hashedPassword);
        $stmt->bindParam('gender', $gender);
        $stmt->bindParam('birthday', $birthday);
        $stmt->bindParam('profile_pic', $new_img_name);
    
        $stmt->execute([
            ':unique_id' => $randomId,
            ':last_name' => $userData['last-name'],
            ':first_name' => $userData['first-name'],
            ':email' => $userData['email'],
            ':bio' => $userData['bio'],
            ':password' => $hashedPassword,
            ':gender' => $userData['gender'],
            ':birthday' => $userData['birthday'],
            ':profile_pic' => $new_img_name
        ]);

        // Configuration des sessions
        $_SESSION['user-id'] = $randomId;
        $_SESSION['user-email'] = $userData['email'];

        // Réponse avec données pour sessionStorage
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $randomId,
                'first_name' => $userData['first-name'],
                'last_name' => $userData['last-name'],
                'email' => $userData['email'],
                'profile_pic' => $new_img_name,
                'gender' => $userData['gender']
            ],
            'redirect' => '../../home.php'
        ]);
        echo "Inscription reussie";
    } catch(PDOException $e) {
        http_response_code(500);
        echo "Echec lors de l'enregistrement des données : " . $e->getMessage();
    }

echo json_encode(['error' => 'Requête invalide']);
?>