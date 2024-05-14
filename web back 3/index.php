
<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('<p>Спасибо, результаты сохранены.</p>');
  }
  include('index1.php');
  exit();
}

$user = 'u67325'; 
$pass = '2356748'; 
$db = new PDO('mysql:host=localhost;dbname=u67325', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$year = $_POST['date'];
$gender = $_POST['gender'];
if(isset($_POST["languages"])) {
  $languages = $_POST["languages"];
  $filtred_languages = array_filter($languages, 
  function($value) {
    return($value == 1 || $value == 2 || $value == 3
    || $value == 3 || $value == 4 || $value == 5
    || $value == 6|| $value == 7|| $value == 8
    || $value == 9 || $value == 10 || $value == 11);
    }
  );
}
$biography = $_POST['biography'];
$checkboxContract = isset($_POST['checkboxContract']);

$errors = FALSE;

if (empty($name)) {
  print('<h1>Заполните поле "Имя".</h1><br/>');
  $errors = TRUE;
} else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name)) {
  print('<h1>Введены недопустимые символы в поле "Имя".</h1><br/>');
  $errors = TRUE;
}

if (empty($phone)) {
  print('<h1>Заполните поле "Телефон".</h1><br/>');
  $errors = TRUE;
} else if (!preg_match('/^(\+\d+|\d+)$/', $phone)) {
  print('<h1>Введены недопустимые символы в поле "Телефон".</h1><br/>');
  $errors = TRUE;
}

if (empty($email)) {
  print('<h1>Заполните поле "Email".</h1><br/>');
  $errors = TRUE;
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  print('<h1>Корректно* заполните поле "Email".</h1><br/>');
  $errors = TRUE;
}

if (!is_numeric($year)) {
  print('<h1>Неправильный формат ввода года.</h1><br/>');
  $errors = TRUE;
} else if ($year < 1920 || $year > 2010) {
  print('<h1>Введите действительный год рождения.</h1><br/>');
  $errors = TRUE;
}

if ($gender != 'male' && $gender != 'female') {
  print('<h1>Выбран неизвестный пол.</h1><br/>');
  $errors = TRUE;
}

if (empty($_POST['favourite_lan'])) {
  print('Выберите любимый язык программирования!');
  $errors = TRUE;
} else { 
  $sth = $db->prepare("SELECT id FROM languages");
  $sth->execute();
  $langs = $sth->fetchAll();

  foreach ($_POST['favourite_lan'] as $id_lang) {
      $error_lang = TRUE;
      foreach ($langs as $lang) {
          if ($id_lang == $lang[0]) {
              $error_lang = FALSE;
              break;
          }
      }
      if ($error_lang == TRUE) {
          print('Выбранный язык программирования не найден в базе данных!');
          $errors = TRUE;
          break;
      }
  }
}

if (empty($biography)) {
  print('<h1>Заполните поле "Биография".</h1><br/>');
  $errors = TRUE;
} else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biography)) {
  print('<h1>Введены недопустимые символы в поле "Биография".</h1><br/>');
  $errors = TRUE;
} else if (strlen($biography) > 128) { 
  print('<h1>Превышено количество символов в поле "Биография".</h1><br/>');
  $errors = TRUE;
}

if ($checkboxContract == '') {
  print('<h1>Ознакомьтесь с контрактом.</h1><br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}


try {
  $stmt = $db->prepare("INSERT INTO users (name, phone, email, date, gender, biography, checkboxContract) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$name, $phone, $email, $year, $gender, $biography, $checkboxContract]);
  
  $id = $db->lastInsertId();

  $stmt = $db->prepare("INSERT INTO users_and_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
  foreach ($_POST['favourite_lan'] as $id_lang) {
      $stmt->bindParam(':id_user', $id_user);
      $stmt->bindParam(':id_lang', $id_lang);
      $id_user = $id;
      $stmt->execute();
  }
} catch (PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}
header('Location: index1.php');
