
<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();

    if (!empty($_COOKIE['save'])) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('save', '', 100000);
      // Если есть параметр save, то выводим сообщение пользователю.
      $messages[] = 'Спасибо, результаты сохранены.';
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
    
    if($errors['phone']=='1'){

      $messages[] = '<div class="error">Заполните номер телефона!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле должно содержать только знак + и цифры!</div>';
    }
   
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    
  }
  if ($errors['email']) {
   
    if($errors['email']=='1'){

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
    if($errors['biography']=='1'){

      $messages[] = '<div class="error">Напишите о себе!</div>';
    }
    else{
      if($errors['biography']=='2'){
      $messages[] = '<div class="error">Поле может содержать только буквы, цифры, знаки ".,;!? \-"!</div>';}
      else{
        $messages[] = '<div class="error">Поле не может превышать 128 символов!</div>';}
      }
    }
    setcookie('biography_error', '', 100000);
    setcookie('biography_value', '', 100000);
  
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
  if(isset($_POST["favourite_lan"])) {
    $languages = $_POST["favourite_lan"];
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
      setcookie('name_error', '', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name)){
      setcookie('name_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);

    if (empty($phone) ) {
      setcookie('phone_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^(\+\d+|\d+)$/', $phone)){
      setcookie('phone_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);

    if (empty($email) ) {
      setcookie('email_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      setcookie('email_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);

    if (empty($date) ) {
      setcookie('date_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);

    if (empty($gender) ) {
      setcookie('gender_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['favourite_lan']) ) {
      setcookie('languages_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('languages_value', $lang, time() + 30 * 24 * 60 * 60);

    if (empty($biography)  ) {
      setcookie('biography_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{ if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biography)){
      setcookie('biography_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;}
      else if(strlen($biography) > 128){
        setcookie('biography_error', '3', time() + 24 * 60 * 60);
        $errors = TRUE;}
    }
    
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
    if ($checkboxContract == '') {
      setcookie('checkboxContract', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('checkboxContract', $_POST['checkboxContract'], time() + 30 * 24 * 60 * 60);

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
      setcookie('biography', '', 100000);
      setcookie('checkboxContract', '', 100000);
      // TODO: тут необходимо удалить остальные Cookies.
    }

    $user = 'u67325'; 
    $pass = '2356748'; 
    $db = new PDO('mysql:host=localhost;dbname=u67325', $user, $pass,
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

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

    setcookie('save', '1');
    header('Location: index.php');
}

