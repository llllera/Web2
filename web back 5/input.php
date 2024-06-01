<!DOCTYPE html>
<html>
<head>
  <title>Страница входа</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      
    }
    .container {
      width: 500px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .form-group {
      margin: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .form-group input[type="submit"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      background-color: #4CAF50;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.

header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    // Делаем перенаправление на форму.
    ?>
      <section>
        <form action="" method="post">
          <div>Пользователь уже авторизован</div><br>
          <input class="finalBut" type="submit" name="logout" value="Выход"/>
        </form>
      </section>
      <?php
    if (isset($_POST['logout'])) {
      session_destroy();
      setcookie('PHPSESSID', '', 100000, '/');
      header('Location: ./');
      exit();
  }
}
}
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

  <div class="container">
    <form action="" method="post">
      <div class="form-group">
        <label for="username">Логин:</label>
        <input type="text" id="username" name="login" required>
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="pass" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Войти">
      </div>
    </form>
  </div>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.
  include('data.php');
  $db = new PDO('mysql:host=localhost;dbname=u67325', $db_user, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  $passDB = null;
  $login = $_POST['login'];
  $pass = md5($_POST['pass']);
  try{
    $sth = $db->prepare('SELECT password FROM Users WHERE login = :login');
    $sth->execute(['login' => $login]);
    
    while ($row = $sth->fetch()) {
      $passDB = $row['password'];
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
  

  if($passDB == "" || $passDB != $pass)
  {
    // Выдать сообщение об ошибках.
    print("No such login or incorrect password");
  }

  if (!$session_started) {
    session_start();
  }
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $_POST['login'];

  // Делаем перенаправление.
  header('Location: ./');
}
?>
</body>
</html>