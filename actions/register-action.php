<?php 
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
    echo json_encode(['error' => 'Requête invalide']);

    // if(!isset($_POST['last-name'], $_POST['first-name'], $_POST['email'], $_POST['password'], $_POST['confirm-password'], $_POST['gender'], $_POST['birthday'], $_FILES['profile-pic'])) {

    //     http_response_code(400);
    //     echo "Champs obligatoires manquants";
    //     exit();
    // }

    $lastName = trim($_POST['last-name']);
    $firstName = trim($_POST['first-name']);
    $email = trim($_POST['email']);
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
    $gender= trim($_POST['gender']);
    $birthday = trim($_POST['birthday']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);


    if($password !== $confirmPassword) {
        http_response_code(400);
        echo "Les mots de passes ne correspondent pas";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(isset($_FILES['profile-pic'])) {
        $img_name = $_FILES['profile-pic']['name'];
        $tmp_name = $_FILES['profile-pic']['tmp_name'];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);
        
        // Vérification de l'extension de l'image 
        $extensions = ['png', 'jpeg', 'jpg', 'webp'];
        if(in_array($img_ext, $extensions) === true) {
            $time = time();
            $new_img_name = $time.$img_name;
            
            if(move_uploaded_file($tmp_name, "../profile-pic/".$new_img_name)) {
                $randomId = rand(time(), 10000000);            
            }
        }
    }

    // Vérifie si l'email existe déjà
    $sqlCheck = "SELECT id FROM users WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        http_response_code(409);
        echo "Cet email est déjà utilisé";
        exit();
    }


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

    try {
        $stmt->execute();
        echo "Inscription reussie";
    } catch(PDOException $e) {
        http_response_code(500);
        echo "Echec lors de l'enregistrement des données : " . $e->getMessage();
    }


?>