
<link rel="stylesheet" href="form.css">
    <form action="index.php"
    method="POST">

    <ol>
        <li>
            <label>
                ФИО<br>
                <input name="name"
                  placeholder="Введите ваше ФИО">
              </label><br>
        </li>
        <li>
            <label>
                Номер телефона<br>
                <input name="phone"
                  type="tel"
                  placeholder="Введите номер телефона">
            </label><br>
        </li>
        <li>
          <label>
            email<br>
            <input name="email"
              type="email"
              placeholder="Введите вашу почту">
          </label><br>
        </li>
        <li>
          <div class="date">
            <span>Год рождения:</span>
            <select name="date">
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
            <label><input type="radio" checked="checked"
              name="gender" value="male">
              Муж</label>
            <label><input type="radio"
              name="gender" value="female">
              Жен</label><br>
        </li>
        <li>
          <label>Ваш любимый язык программирования:</label><br>
          <select multiple="multiple" name="favourite_lan[]" id="program_language">
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
                <textarea name="biography"
                  placeholder="Расскажите о себе"></textarea>
            </label><br>
        </li>
        <li>
            <br>
          <label><input type="checkbox" checked="checked"
            name="checkboxContract">
            С контрактом ознакомлен (а)</label><br>
        </li>
        <li>
            <input type="submit" value="Сохранить">
        </li>
    </ol>
  </form>
