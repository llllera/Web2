<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('data.php');
   
    if ($_POST['action'] == 'delete') {
        try {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM users where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM users_and_languages where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM login_and_password where id = ?");
            $stmt->execute([$id]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: admin.php');
    }
}