<html>
  <head>
<link rel="stylesheet" href="form.css">
<style>
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
    <form action="index.php"
    method="POST">

    <ol>
        <li>
            <label>
                ФИО<br>
                <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>"
                type="text"
                  placeholder="Введите ваше ФИО">
              </label><br>
        </li>
        <li>
            <label>
                Номер телефона<br>
                <input name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>"
                  type="tel"
                  placeholder="Введите номер телефона">
            </label><br>
        </li>
        <li>
          <label>
            email<br>
            <input name="email"  <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"
              type="email"
              placeholder="Введите вашу почту">
          </label><br>
        </li>
        <li>
          <div class="date">
            <span>Год рождения:</span>
            <select name="date">  <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date']; ?>"
              <?php 
                for ($i = 2022; $i >= 1922; $i--) {
                  printf('<option value="%d">%d год</option>', $i, $i);
                }
              ?>
            </select>
          </div>
        </li>
        <li>
            Пол<br>
            <label><input type="radio" 
              name="gender" value="male">
              Муж</label>
            <label><input type="radio"
              name="gender" value="female">
              Жен</label><br>
        </li>
        <li>
          <label>Ваш любимый язык программирования:</label><br>
          <select multiple="multiple" name="favourite_lan[]"   <?php if ($errors['language']) {print 'class="error"';} ?> value="<?php print $values['language']; ?>"id="program_language">
              <option value="1">Pascal</option>
              <option value="2">C</option>
              <option value="3">C++</option>
              <option value="4">Java</option>
              <option value="5">JavaScript</option>
              <option value="6">PHP</option>
              <option value="7">Python</option>
              <option value="8">Haskell</option>
              <option value="9">Clojure</option>
              <option value="10">Prolog</option>
              <option value="11">Scala</option>
          </select>
        </li>
        <li>
            <label>
                Биография<br>
                <textarea name="biography"  <?php if ($errors['biography']) {print 'class="error"';} ?> 
                  placeholder="Расскажите о себе"><?php print  $values['biography']; ?></textarea>
            </label><br>
        </li>
        <li>
            <br>
          <label><input type="checkbox"  <?php if ($errors['checkboxContract']) {print 'class="error"';} ?> <?php if($values['checkboxContract'])print 'checked'; ?>
            name="checkboxContract">
            С контрактом ознакомлен (а)</label><br>
        </li>
        <li>
            <input type="submit" value="Сохранить">
        </li>
    </ol>
  </form>
  </body>
</html>