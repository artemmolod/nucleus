<?php
//Отправляем заголовок для поисковиков
header('HTTP/1.0 503 Service Unavailable');
//Рекомендуемое время обновления страницы
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Beta test</title>
    <style>
        * {
           font-family: 'Lato', Calibri, Arial, sans-serif;
        }
        body {
           overflow: hidden;
        }
        .main-section-test {
           position: relative;
           margin: 100px auto;
           text-align: center;
        }
        .main-test h2 {
           color: #04a7a3;
           font-size: 5em;
        }
        .test-descr {
           line-height: 150%;
           font-size: 19px;
        }
        a {
           color: #04a7a3;
           text-decoration: none;
        }
        a:hover {
          text-decoration: underline;
        }
        .logo {
           color: #04a7a3;
           font-size: 34px;
           font-weight: bold;
           margin: 120px;
        }
    </style>
  </head>
  <body>
    <section class="main-section-test">
        <div class="main-test">
            <h2>Грядёт что-то новое,<br/>
            не пропусти</h2>
        </div>
        <div class="test-descr">
            На сайте ведутся технические работы.
        </div>
        <div class="logo">Nucleus</div>
    </section>
  </body>
</html>

