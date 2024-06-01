
<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.

include('data.php');

  $sth = $db->prepare('SELECT login, password FROM admin');
  $sth->execute();

  $adminLogin;
  $adminPass;
  while ($row = $sth->fetch()) {
    $adminLogin = $row["login"];
    $adminPass = $row["password"];
  }
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $adminLogin ||
    md5($_SERVER['PHP_AUTH_PW']) != md5($adminPass)) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');

    $sth = $db->prepare("SELECT * FROM users");
    $sth->execute();
    $users = $sth->fetchAll();
?>
<h2>Таблица пользователей</h2>
<table class="users">
  <tr>
    <th>ID</th>
    <th>ФИО</th>
    <th>Телефон</th>
    <th>Email</th>
    <th>Дата рождения</th>
    <th>Пол</th>
    <th>Биография</th>
    <th class="nullCell"></th>
    <th class="nullCell"></th>
  </tr>
  <?php
    foreach($users as $user) {
      printf('
      <form action="edit.php" method="POST"><tr>
      <td>%d</td>
      <td><input name="name" value="%s"></td>
      <td><input name="phone" value="%s"></td>
      <td><input name="email" value="%s"></td>
      <td><input name="date" value="%s"></td>
      <td><input name="gender" value="%s"></td>
      <td><input name="biography" value="%s"></td>
      <td class="nullCell">
        
       
          <input type="hidden" name="id" value="%d">
          <input type="submit"name="action" class="tableButtonCh" value="изменить"/>
        
      </td>
      <td class="nullCell">
        <form action="edit.php" method="POST">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="%d">
          <input type="submit" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>
      </form>',
      $user['id'], $user['name'], $user['phone'], $user['email'],
      $user['date'], $user['gender'], $user['biography'],
      $user['id'], $user['id']);
    }
  ?>
</table>


// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
