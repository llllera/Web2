
<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();

    if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      setcookie('login', '', 100000);
      setcookie('pass', '', 100000);
     
      $messages[] = 'Спасибо, результаты сохранены.';
       // Если в куках есть пароль, то выводим сообщение.
      if (!empty($_COOKIE['pass'])) {
        $messages[] = sprintf('Вы можете <a href="input.php">войти</a> с логином <strong>%s</strong>
          и паролем <strong>%s</strong> для изменения данных.',
          strip_tags($_COOKIE['login']),
          strip_tags($_COOKIE['pass']));
      }
    }
     // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']); // если не пусто присваивается TRUE
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['language'] = !empty($_COOKIE['language_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['checkboxContract'] = !empty($_COOKIE['checkboxContract_error']);


  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    if($_COOKIE['name_error']=='1'){
      $messages[] = '<div class="error">Заполните имя!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле должно содержать только буквы и пробелы!</div>';
    }
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    setcookie('name_value', '', 100000);

    // Выводим сообщение.
  }
  
  if ($errors['phone']) {
    
    if($_COOKIE['phone_error']=='1'){

      $messages[] = '<div class="error">Заполните номер телефона!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле должно содержать только знак + и цифры!</div>';
    }
   
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    
  }
  if ($errors['email']) {
   
    if($_COOKIE['email_error']=='1'){

      $messages[] = '<div class="error">Заполните почту!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле обязатольно должно содержать @ и .!</div>';
    }
   
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    
  }
  if ($errors['date']) {
    setcookie('date_error', '', 100000);
    setcookie('date_value', '', 100000);
    $messages[] = '<div class="error">Выберите год рождения!</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    setcookie('gender_value', '', 100000);
    $messages[] = '<div class="error">Выберите пол!</div>';
  }
  if ($errors['language']) {
    setcookie('language_error', '', 100000);
    setcookie('language_value', '', 100000);
    $messages[] = '<div class="error">Отметьте языки!</div>';
  }
  if ($errors['biography']) {
    if($_COOKIE['biography_error']=='1'){

      $messages[] = '<div class="error">Напишите о себе!</div>';
    }
    else{
      if($_COOKIE['biography_error']=='2'){
      $messages[] = '<div class="error">Поле может содержать только буквы, цифры, знаки ".,;!? \-"!</div>';}
      else{
        $messages[] = '<div class="error">Поле не может превышать 128 символов!</div>';}
      }
      setcookie('biography_error', '', 100000);
      setcookie('biography_value', '', 100000);
    }
   
  
  if ($errors['checkboxContract']) {
    setcookie('checkboxContract_error', '', 100000);
    setcookie('checkboxContract_value', '', 100000);
    $messages[] = '<div class="error">Дайте согласие!</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['languages'] = empty($_COOKIE['languages_value']) ? '' : $_COOKIE['languages_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['checkboxContract'] = empty($_COOKIE['checkboxContract_value']) ? '' : $_COOKIE['checkboxContract_value'];


  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
      include('data.php');
    // TODO: загрузить данные пользователя из БД
    // и заполнить переменную $values,
    // предварительно санитизовав.

      $userLogin = $_SESSION['login'];

      $db = new PDO('mysql:host=localhost;dbname=u67325', $db_user, $db_pass,
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

      try {
        $formId;
        $sth = $db->prepare('SELECT id FROM login_and_password WHERE login = :login');
        $sth->execute(['login' => $userLogin]);
      
        while ($row = $sth->fetch()) {
          $formId = $row['id'];
        }
        $sth = $db->prepare('SELECT name, phone, email,date, gender, biography, checkboxContract FROM users WHERE id = :id');
          $sth->execute(['id' => $formId]);
          while ($row = $sth->fetch()) {
            $values['name'] = $row['name'];
            $values['phone'] = $row['phone'];
            $values['date'] = $row['date'];
            $values['email'] = $row['email'];
            $values['gender'] = $row['gender'];
            $values['biography'] = $row['biography'];
            $values['checkboxContract'] = $row['checkboxContract'];
          }
      
          $sth = $db->prepare('SELECT id_lang FROM users_and_languages WHERE id_user = :id');
          $sth->execute(['id' => $formId]);
         
          $row = $sth->fetchAll();
          
          $langsCV = '';

          for($i = 0; $i < count($row); $i++){
            $langsCV .= $rowl[$i] . ",";
          }
          $values['languages'] = $langsCV;
          
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
      
      setcookie('name_value', $values['name'], time() + 30 * 24 * 60 * 60);
      setcookie('email_value', $values['email'], time() + 30 * 24 * 60 * 60);
      setcookie('phone_value', $values['phone'], time() + 30 * 24 * 60 * 60);
      setcookie('date_value', $values['date'], time() + 30 * 24 * 60 * 60);
      setcookie('gender_value', $values['gender'], time() + 30 * 24 * 60 * 60);
      setcookie('languages_value', $values['languages'], time() + 30 * 24 * 60 * 60);
      setcookie('biography_value', $values['biography'], time() + 30 * 24 * 60 * 60);
      setcookie('checkboxContract_value', $values['checkboxContract'], time() + 30 * 24 * 60 * 60);
      
      printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);

  }
 
  include('index1.php');

}
else {
 
  // Проверяем ошибки.
  $errors = FALSE;

  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $date = $_POST['date'];
  $gender = $_POST['gender'];
  if(isset($_POST['favourite_lan'])) {
    $languages = $_POST['favourite_lan'];
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
  $lang = '';
  if(!empty($_POST['favourite_lan']))
  {
    for($i = 0; $i < count($_POST['favourite_lan']); $i++)
    {
      $lang .= $lang[$i] . ",";
    }
  }

    if (empty($name)) {
      // Выдаем куку на день с флажком об ошибке в поле fio.
      setcookie('name_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name)){
      setcookie('name_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    // Сохраняем ранее введенное в форму значение на месяц.
    else{setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);}

    if (empty($phone) ) {
      setcookie('phone_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^(\+\d+|\d+)$/', $phone)){
      setcookie('phone_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);}

    if (empty($email) ) {
      setcookie('email_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      setcookie('email_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);}

    if (empty($date) ) {
      setcookie('date_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);}

    if (empty($gender) ) {
      setcookie('gender_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);}

    if (empty($_POST['favourite_lan']) ) {
      setcookie('languages_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('languages_value', $lang, time() + 30 * 24 * 60 * 60);}

    if (empty($biography)  ) {
      setcookie('biography_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biography) ||strlen($biography) > 128){ 
      if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biography)){
      setcookie('biography_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;}
      else if(strlen($biography) > 128){
        setcookie('biography_error', '3', time() + 24 * 60 * 60);
        $errors = TRUE;}
    }
    else{setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);}

    if ($checkboxContract == '') {
      setcookie('checkboxContract_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('checkboxContract_value', $_POST['checkboxContract'], time() + 30 * 24 * 60 * 60);}

    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: index.php');
      exit();
    }
    else {
      // Удаляем Cookies с признаками ошибок.
      setcookie('name_error', '', 100000);
      setcookie('phone_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('date_error', '', 100000);
      setcookie('gender_error', '', 100000);
      setcookie('languages_error', '', 100000);
      setcookie('biography_error', '', 100000);
      setcookie('checkboxContract_error', '', 100000);
      // TODO: тут необходимо удалить остальные Cookies.
    }


    include('data.php');
    $db = new PDO('mysql:host=localhost;dbname=u67325', $db_user, $db_pass,
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['login'])) {
  // TODO: перезаписать данные в БД новыми данными,
  // кроме логина и пароля.
  $userLogin = $_SESSION['login'];
  $formId;
      $sth = $db->prepare('SELECT id FROM login_and_password WHERE login = :login');
      $sth->execute(['login' => $userLogin]);
    
      while ($row = $sth->fetch()) {
        $formId = $row['id'];
      }

  $stmt = $db->prepare("UPDATE users SET name = :name, phone = :phone, email = :email, date=:date,  gender = :gender, biography = :biography, checkboxContract = :checkboxContract WHERE id = :id");
  $stmt -> execute(['name'=>$name,'phone'=>$phone, 'email'=>$email,'date'=>$date,'gender'=>$gender,'biography'=>$biography, 'checkboxContract'=>$checkboxContract, 'id' => $formId]);

  $stmt = $db->prepare("DELETE FROM users_and_languages WHERE id_user = :formId");
  $stmt -> execute(['formId'=>$formId]);
  $stmt = $db->prepare("INSERT INTO users_and_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
      foreach ($_POST['favourite_lan'] as $id_lang) {
          $stmt->bindParam(':id_user', $id_user);
          $stmt->bindParam(':id_lang', $id_lang);
          $id_user = $formId;
          $stmt->execute();
      }
  
  }

  else {
  // Генерируем уникальный логин и пароль.
  // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
  $login = uniquid();
  $pass = uniquid();
  // Сохраняем в Cookies.
  setcookie('login', $login);
  setcookie('pass', $pass);  
  

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
      $stmt = $db->prepare("INSERT INTO  login_and_password (id, login, password) VALUES (?, ?, ?)");
      $stmt->execute([$id, $login, md5($password)]);
      print('Данные успешно сохранены!');
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
  

  // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
  // ...
  }

    setcookie('save', '1');
    header('Location: index.php');
}


