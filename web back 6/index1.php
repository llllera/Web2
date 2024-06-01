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
            <select name="date">  <?php if ($errors['date']) {print 'class="error"';} ?> 
              <?php 
                for ($i = 2022; $i >= 1922; $i--) {
                  $selected = ($i == $values['date']) ? 'selected' : '';
                  printf('<option value="%d" %s>%d год</option>', $i,$selected, $i);
                }
              ?>
            </select>
          </div>
        </li>
        <li>
            Пол<br>
            <label><input type="radio" 
              name="gender" value="male" <?php if ($errors['gender']) {print 'class="error"';} ?> <?php if ($values['gender']=='male') {print 'checked';}?>>
              Муж</label>
            <label><input type="radio"
              name="gender" value="female" <?php if ($errors['gender']) {print 'class="error"';} ?> <?php if ($values['gender']=='female'){ print 'checked';}?>>
              Жен</label><br>
        </li>
        <li>
          <label>Ваш любимый язык программирования:</label><br>
          <select multiple="multiple" name="favourite_lan[]"   <?php if ($errors['language']) {print 'class="error"';} ?> id="program_language">
              <option value="1" <?php if(strpos($values['languages'],'1' )!== false && strpos($values['languages'],'10' )== false && strpos($values['languages'],'11' )=== false){print 'selected';} ?> >Pascal</option>
              <option value="2" <?php if(strpos($values['languages'],'2' )!== false){print 'selected';} ?>>C</option>
              <option value="3" <?php if(strpos($values['languages'],'3' )!== false){print 'selected';} ?>>C++</option>
              <option value="4" <?php if(strpos($values['languages'],'4' )!== false){print 'selected';} ?>>Java</option>
              <option value="5" <?php if(strpos($values['languages'],'5' )!== false){print 'selected';} ?>>JavaScript</option>
              <option value="6" <?php if(strpos($values['languages'],'6' )!== false){print 'selected';} ?>>PHP</option>
              <option value="7" <?php if(strpos($values['languages'],'7' )!== false){print 'selected';} ?>>Python</option>
              <option value="8" <?php if(strpos($values['languages'],'8' )!== false){print 'selected';} ?>>Haskell</option>
              <option value="9" <?php if(strpos($values['languages'],'9' )!== false){print 'selected';} ?>>Clojure</option>
              <option value="10" <?php if(strpos($values['languages'],'10' )!== false){print 'selected';} ?>>Prolog</option>
              <option value="11" <?php if(strpos($values['languages'],'11' )!== false){print 'selected';} ?>>Scala</option>
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
        <li>
            <div><a href="admin.php">Войти</a> как администратор.</div>
        </li>
    </ol>

  </form>
  </body>
</html>