<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('data.php');
    if (isset($_POST['change'] )) {
        try {
            $id = $_POST['id'];
            $stmt = $db->prepare("update users SET name = :name, phone = :phone, email = :email, date=:date,  gender = :gender, biography = :biography where id = :id");
            $stmt -> execute(['name'=>$_POST['name'],'phone'=>$_POST['phone'], 'email'=>$_POST['email'],'date'=>$_POST['date'],'gender'=>$_POST['gender'],'biography'=>$_POST['biography'], 'id' => $id]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    else if (isset($_POST['delete'] )) {
        try {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM users where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM users_and_languages where id_user = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM login_and_password where id = ?");
            $stmt->execute([$id]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
       
    }
    
    setcookie('save', '1');
    header('Location: admin.php');
}