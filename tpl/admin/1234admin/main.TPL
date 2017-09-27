<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="utf-8" />
      <title id="title">Админ панель</title>
      <link rel="shortcut icon" href="/tpl/img/favicon/favicon_main.png?1" />
      <meta name="theme-color" content="#04a7a3">
      <meta name="yandex-verification" content="725c38342aff94e1" />
      <link rel="stylesheet" href="/tpl/css/main.css?15.75" media="screen" />
      <link rel="stylesheet" href="/tpl/css/a.css?0.1" media="screen" />
      <script src="/tpl/js/userInfo.js?1"></script>
      <script src="/tpl/js/main.js?5.99"></script>
      
      <script src="/admin/js/main.js?0.0.1"></script>
   </head>
   <body onload="onloadPage();">
      <section class="a-main">
        <div class="a-main-contaiiner">
          <div class="a-main-container-header">
            Админ панель
          </div>
          <div class="a-main-container-block">
            <div class="a-main-contaiiner-menu fll">
              <div class="">
                <a href="/admin/stats" onclick="return ajax.page(this.href)" class="a-link-menu">Статистика</a>
                <a href="/admin/users" onclick="return ajax.page(this.href)" class="a-link-menu">Пользователи</a>
                <a href="/admin/competition" onclick="return ajax.page(this.href)" class="a-link-menu">Конкурс</a>
                <a href="/admin/photo" onclick="return ajax.page(this.href)" class="a-link-menu">Фотографии</a>
                <a href="/admin/promocode" onclick="return ajax.page(this.href)" class="a-link-menu">Промокоды</a>
                <a href="/admin/report" onclick="return ajax.page(this.href)" class="a-link-menu">Жалобы</a>
                <a href="/admin/errors" onclick="return ajax.page(this.href)" class="a-link-menu">Сообщения об ошибках</a>
              </div>
            </div>
            <div class="a-main-contaiiner-a fll" id="main">{content}</div>
            <div class="clear"></div>
          </div>
        </div>
      </section>
      <section id="ajax_load_block"></section>
      <section id="loading_block"></section>
      <script>function updateTitle() {}</script>
   </body>
</html>