<!DOCTYPE html>
<html lang="ru">
    <head>
      <meta charset="utf-8" />
      <title id="title">Разработчикам</title>
      <link rel="shortcut icon" href="/tpl/img/favicon/favicon_main.png?1" />
      <meta name="theme-color" content="#04a7a3">
      <meta name="yandex-verification" content="7c6b5394085425a6" />
      <meta name="description" content="Nucleus - с нами каждый момент Вашей жизни станет куда счастливее. Не веришь, так попробуй! Присоединись!">
      <meta property="og:title" content="Nucleus - делись по-новому."/>
      <meta property="og:image" content="http://web-nucleus.com/tpl/img/image_url.jpg"/>
      <meta property="og:site_name" content="web-nucleus.com"/>
      <meta property="og:description" content="Nucleus - с нами каждый момент Вашей жизни станет куда счастливее. Не веришь, так попробуй! Присоединись!"/>
      <link rel="stylesheet" href="/tpl/css/competition.css?1.09" media="screen">
      <link rel="stylesheet" href="/tpl/css/main.css?13.0" media="screen">
      <link rel="stylesheet" href="/tpl/css/dev.css?1.0" media="screen" />
      <script src="/tpl/js/main.js?1"></script>
      <script src="/tpl/js/dev.js?1"></script>
    </head>
    <body>
      <header class="header">
        <div class="header-content competition-header-w" id="header_content">
          <div class="fix-w">
            <div class="header-logo-content">
                <div class="header-logo">
                  <a href="/developers/" class="header-logo-a">Nucleus Developers</a>
                </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </header>
      <div class="pad-fix"></div>
      <section class="dev-main">
        <div class="dev-pad"></div>
        <div class="dev-status">
          <div class="dev-status-title">Статус платформы</div>
          <div class="dev-status-method">
            <div class="dev-status-method-l">
              <div class="dev-status-method-name dev-l dev-header-l"><div>Название метода</div></div>
              <div class="dev-status-method-s dev-l dev-header-l"><div>Статус</div></div>
              <div class="dev-status-method-t dev-l dev-header-l"><div>Время</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>users</div></div>
              <div class="dev-status-method-s dev-l"><div>работает</div></div>
              <div class="dev-status-method-t dev-l"><div>40 мс</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>photo</div></div>
              <div class="dev-status-method-s dev-l"><div>работает</div></div>
              <div class="dev-status-method-t dev-l"><div>67 мс</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>subscription</div></div>
              <div class="dev-status-method-s dev-l"><div>работает</div></div>
              <div class="dev-status-method-t dev-l"><div>36 мс</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>account</div></div>
              <div class="dev-status-method-s dev-l"><div>в разработке</div></div>
              <div class="dev-status-method-t dev-l"><div>0 мс</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>competition</div></div>
              <div class="dev-status-method-s dev-l"><div>работает</div></div>
              <div class="dev-status-method-t dev-l"><div>38 мс</div></div>
            </div>
          </div>
        </div>

        <div class="dev-m"></div>
        <div class="dev-left-menu dev-left-in" id="dev_menu">
          <div class="dev-left-menu-bl">
            <a href="#doc" class="dev-menu-a">Работа с API</a>
            <a href="#example" class="dev-menu-a">Примеры кода</a>
            <a href="#list" class="dev-menu-a">Список методов</a>
            <a href="#errors" class="dev-menu-a">Ошибки работы API</a>
            <a href="#support" class="dev-menu-a">Поддержка</a>
          </div>
        </div>

        <div class="dev-right-block dev-left-in">
          <div class="dev-right-bl" id="doc">
            <div class="dev-right-bl-title">Документация</div>
            <div class="dev-right-bl-content">
              Чтобы обратиться к методу API Nucleus, Вам необходимо выполнить <b>GET</b> запрос такого вида:
              <div class="dev-example">
                http://dev.web-nucleus.com/method/?<b>METHOD</b>&<b>PARAMETER</b>&<b>SECRET_KEY</b>
              </div>
              Обозначения: <br/>
              <b>METHOD</b> <span class="ex-span">(обязательно)</span> - название метода API, к которому Вы хотите обратиться.<br/>
              <b>PARAMETER</b> <span class="ex-span">(обязательно)</span> -  входные параметры соответствующего метода API.<br/>
              <b>SECRET_KEY</b> <span class="ex-span">(опционально)</span> - секретный ключ доступа, расширяющий возможности API Nucleus. Получить который можно, написав на <a href="mailto:support@web-nucleus.com">support@web-nucleus.com</a>.<br/><br/>

              Например, реализация метода <b>users.get</b> будет выглядеть так:
              <div class="dev-example">
                http://dev.web-nucleus.com/method/?users.get&user_ids=1
              </div>
              В ответ на такой запрос Вы получите ответ в формате <b>JSON</b>:
              <div class="dev-example">
                <code class="dev-code-json">
                  <span>{<span><br/>
                    <span class="dev-code-json-response">"response":[{<span><br/>
                      <span class="dev-code-json-response-j">"id":1,<span><br/>
                      <span class="dev-code-json-response-j">"first_name":"Артем",<span><br/>
                      <span class="dev-code-json-response-j">"last_name":"Молодцов",<span><br/>
                      <span class="dev-code-json-response-j">"sex":"1",<span><br/>
                      <span class="dev-code-json-response-j">"bdate":"1997-11-17"<span><br/>
                    <span class="dev-code-json-response">}]<span><br/>
                  <span>}<span>
                </code>
              </div>
            </div>
          </div>
          
          <div class="dev-m" id="example"></div>
          <div class="dev-right-bl">
            <div class="dev-right-bl-title">Примеры кода</div>
            <div class="dev-right-bl-content">
              Реализация запроса API на <b>PHP</b>:
              
              <div class="dev-example">
                <code class="dev-code-json">
                  <span>&lt?php<span><br/>
                    <span class="dev-code-json-response">$user_ids = 1;<span><br/>
                    <span class="dev-code-json-response">$params = [<span><br/>
                      <span class="dev-code-json-response-j">"user_ids" => $user_ids,<span><br/>
                      <span class="dev-code-json-response-j">"fields" => "rating",<span><br/>
                    <span class="dev-code-json-response">];<span><br/>
                    <span class="dev-code-json-response">$query = http_build_query($params);<span><br/>
                    <span class="dev-code-json-response">$api_url = "http://dev.web-nucleus.com/method/?users.get&" . $query;<span><br/>
                    <span class="dev-code-json-response">$result = file_get_contents($api_url);<span><br/>
                    <span class="dev-code-json-response">$request = json_decode($result, true);<span><br/>
                    <span class="dev-code-json-response">print $request['response'][0]['rating'];<span><br/>
                </code>
              </div>
              В этом примере скрипт выводит рейтинг(<b>rating</b>) пользователя с id = 1, с помощью метода <b>users.get</b>.
            </div>
          </div>

          <div class="dev-m" id="list"></div>
          <div class="dev-right-bl">
            <div class="dev-right-bl-title">Список методов</div>
            <div class="dev-right-bl-content">
              <div class="dev-status-method-l">
              <div class="dev-status-method-name dev-l dev-header-l"><div>Название метода</div></div>
              <div class="dev-status-method-s dev-l dev-header-l dev-method-l"><div>Описание метода</div></div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>users.get</div></div>
              <div class="dev-status-method-s dev-l dev-method-l">
                <div>Возвращает расширенную информацию о пользователях.</div>
              </div>
              <div class="dev-method-param" id="dev_method_users_get">
                Параметры<br/>
                <b>user_ids</b> (строка, обязательно) - принимает на вход ID польвателя(-лей).<br/>
                <b>fields</b> (строка, необязательно) - принимает на вход список полей, необходимых вернуть при запросе. 
                <br/>По умолчанию возвращает поля <b>first_name</b>, <b>last_name</b>, <b>sex</b>, <b>bdate</b>.
                <br/>Допустимые поля: <b>first_name</b>, <b>last_name</b>, <b>sex</b>, <b>bdate</b>, <b>email_ver</b>, <b>user_ver</b>, <b>rating</b>, <b>king</b>, <b>king_cnt</b>, <b>block</b>, <b>del</b>. <br/><br/>
                Результат<br/>
                Вернет массив объекта user.
              </div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>users.search</div></div>
              <div class="dev-status-method-s dev-l dev-method-l">
                <div>Возвращает список пользователей по ID.</div>
              </div>
              <div class="dev-method-param" id="dev_method_users_search">
                Параметры<br/>
                <b>user_ids</b> (строка, обязательно) - принимает на вход ID польвателя(-лей).<br/><br/>
                Результат<br/>
                Вернет массив с результатом выполнения, который содержит поля:<br/>
                <b>count</b>: количесво искомых пользователей  (число)<br/>
                <b>result</b>: который содержит поле <b>status</b>
                        (0 - если пользователь существует, 1 - пользователь не найден.)
              </div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>photo.get</div></div>
              <div class="dev-status-method-s dev-l dev-method-l">
                <div>Возвращает список фотографий пользователя.</div>
              </div>
              <div class="dev-method-param" id="dev_method_photo_get">
                Параметры<br/>
                <b>user_ids</b> (строка, обязательно) - принимает на вход ID польвателя(-лей).<br/><br/>
                Результат<br/>
                Вернет массив с результатом выполнения, который содержит поля:<br/>
                <b>count</b>: количесво пользователей (число)<br/>
                <b>result</b>: который содержит поле <b>user_id</b>(ID пользователя), <b>count</b>(количество фотографий пользователя), <b>list</b>, который содержит поля:<br/>
                <b>photo_id</b> - ID изображения (строка)<br/>
                <b>photo_src</b> - Ссылка на изображение (строка)<br/> 
                <b>photo_title</b> - Название изображения (строка)<br/>
                <b>photo_descr</b> - Описание изображения (строка)<br/>  
                <b>photo_category</b> - Категория изображения (строка)<br/> 
                <b>photo_time</b> - Время загрузки изображения на сервер (строка)<br/>
                <b>photo_rating</b> - Рейтинг изображения  (строка)
              </div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>photo.voteFor</div></div>
              <div class="dev-status-method-s dev-l dev-method-l">
                <div>Добавляет количество баллов к рейтингу фотографии.</div>
              </div>
              <div class="dev-method-param" id="dev_method_users_get">
                Параметры<br/>
                <b>photo_id</b> (число, обязятельно) - принимает на вход ID изображения.<br/>
                <b>vote</b> (число, обязятально) - принимает количество баллов<br/>
                <b>secret_key</b> (строка, обязательно) - ключ доступа к API.<br/><br/>
                Результат<br/>
                Вернет массив объекта user с полем:<br/>
                <b>status</b> - 0 - успешно, 1 - ошибка. (число)
              </div>
              <div></div>
              <div class="dev-status-method-name dev-l"><div>photo.voteNegative</div></div>
              <div class="dev-status-method-s dev-l dev-method-l">
                <div>Отнимает количество баллов у рейтинга фотографии.</div>
              </div>
              <div class="dev-method-param" id="dev_method_users_get">
                Параметры<br/>
                <b>photo_id</b> (число, обязятельно) - принимает на вход ID изображения.<br/>
                <b>vote</b> (число, обязятально) - принимает количество баллов<br/>
                <b>secret_key</b> (строка, обязательно) - ключ доступа к API.<br/><br/>
                Результат<br/>
                Вернет массив объекта user с полем:<br/>
                <b>status</b> - 0 - успешно, 1 - ошибка. (число)
              </div>
              <div></div>
            </div>
            </div>
          </div>

          <div class="dev-m" id="errors"></div>
          <div class="dev-right-bl">
            <div class="dev-right-bl-title">Ошибки при работе с API</div>
            <div class="dev-right-bl-content">
              <div class="dev-status-method-l">
                <div class="dev-status-method-name dev-l dev-header-l"><div>Код ошибки</div></div>
                <div class="dev-status-method-s dev-l dev-header-l dev-method-l"><div>Описание ошибки</div></div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>18</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Пользователь не найден.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>14</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>API выключено.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>12</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Неизвестный метод API.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>11</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Неверный тип параметра.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>8</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Ошибка авторизации.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>6</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Неверный секретный ключ.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>5</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Параметр не найден.</div>
                </div>
                <div></div>
                <div class="dev-status-method-name dev-l"><div>4</div></div>
                <div class="dev-status-method-s dev-l dev-method-l">
                  <div>Данный метод работает с ключём доступа.</div>
                </div>
                <div></div>
              </div>
            </div>
          </div>

          <div class="dev-m" id="support"></div>
          <div class="dev-right-bl">
            <div class="dev-right-bl-title">Поддержка</div>
            <div class="dev-right-bl-content">
              Если у Вас возникли трудности при работе с API, то Вы можете обратиться в поддержку за помощью по 
              адресу <a href="mailto:support@web-nucleus.com">support@web-nucleus.com</a>. Также у поддержки Вы можете попросить секретный ключ доступа.
            </div>
          </div>

        </div>
        <div class="clear"></div>
        <div class="dev-m"></div>
      </section>
   </body>
</html>