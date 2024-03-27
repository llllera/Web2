
<link rel="stylesheet" href="form.css">
    <form action="/"
    method="POST">

    <ol>
        <li>
            <label>
                ФИО<br>
                <input name="field-name-1"
                  placeholder="Введите ваше ФИО">
              </label><br>
        </li>
        <li>
            <label>
                Номер телефона<br>
                <input name="field-email"
                  type="tel"
                  placeholder="Введите номер телефона">
            </label><br>
        </li>
        <li>
          <label>
            email<br>
            <input name="field-email"
              type="email"
              placeholder="Введите вашу почту">
          </label><br>
        </li>
        <li>
            <label>
                Дата рождения<br>
                <input name="field-date"
                  type="date">
              </label><br>
        </li>
        <li>
            Пол<br>
            <label><input type="radio" checked="checked"
              name="radio-group-1" value="Значение1">
              Муж</label>
            <label><input type="radio"
              name="radio-group-1" value="Значение2">
              Жен</label><br>
        </li>
        <li>
            <label id="str">
                Любимый язык программирования:
                <br>
                <select name="field-name-4[]"
                  multiple="multiple">
                  <option value="Значение1">Pascal</option>
                  <option value="Значение2">C</option>
                  <option value="Значение4">C++</option>
                  <option value="Значение5">JavaScript</option>
                  <option value="Значение6">PHP</option>
                  <option value="Значение7">Python</option>
                  <option value="Значение8">Clojure</option>
                  <option value="Значение9"> Prolog</option>
                  <option value="Значение10">Scala</option>
                </select>
            </label><br>
        </li>
        <li>
            <label>
                Биография<br>
                <textarea name="field-name-2"
                  placeholder="Расскажите о себе"></textarea>
            </label><br>
        </li>
        <li>
            <br>
          <label><input type="checkbox" checked="checked"
            name="check-1">
            С контрактом ознакомлен (а)</label><br>
        </li>
        <li>
            <input type="submit" value="Сохранить">
        </li>
    </ol>
  </form>
