
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
            <select name="year">
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
          <p>Выбери любимые<br>языки программирования:</p>
          <ul>
            <li>
              <input type="checkbox" id="Pascal" name="languages[]" value=1>
              <label for="Pascal">Pascal</label>
            </li>
            <li>
              <input type="checkbox" id="C" name="languages[]" value=2>
              <label for="C">C</label>
            </li>
            <li>
              <input type="checkbox" id="Cpp" name="languages[]" value=3>
              <label for="Cpp">C++</label>
            </li>
            <li>
              <input type="checkbox" id="JavaScript" name="languages[]" value=4>
              <label for="JavaScript">JavaScript</label>
            </li>
            <li>
              <input type="checkbox" id="PHP" name="languages[]" value=5>
              <label for="PHP">PHP</label>
            </li>
            <li>
              <input type="checkbox" id="Python" name="languages[]" value=6>
              <label for="Python">Python</label>
            </li>
            <li>
              <input type="checkbox" id="Java" name="languages[]" value=7>
              <label for="Java">Java</label>
            </li>
            <li>
              <input type="checkbox" id="Haskel" name="languages[]" value=8>
              <label for="Haskel">Haskel</label>
            </li>
            <li>
              <input type="checkbox" id="Clojure" name="languages[]" value=9>
              <label for="Clojure">Clojure</label>
            </li>
            <li>
              <input type="checkbox" id="Prolog" name="languages[]" value=10>
              <label for="Prolog">Prolog</label>
            </li>
            <li>
              <input type="checkbox" id="Scala" name="languages[]" value=11>
              <label for="Scala">Scala</label>
            </li>
          </ul> 
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
