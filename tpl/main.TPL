<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <title id="title">Nucleus</title>
      <link rel="shortcut icon" href="/tpl/img/favicon/favicon_main.png?1" />
      <meta name="theme-color" content="#04a7a3">
      <meta name="yandex-verification" content="7c6b5394085425a6" />
      <meta name="description" content="Nucleus - с нами каждый момент Вашей жизни станет куда счастливее. Не веришь, так попробуй! Присоединись!">
      <meta property="og:title" content="Nucleus - делись по-новому."/>
      <meta property="og:image" content="http://web-nucleus.com/tpl/img/image_url.jpg"/>
      <meta property="og:site_name" content="web-nucleus.com"/>
      <meta property="og:description" content="Nucleus - с нами каждый момент Вашей жизни станет куда счастливее. Не веришь, так попробуй! Присоединись!"/>
      <link rel="stylesheet" href="/tpl/css/main.css?16.83.2" media="screen" />
      <script src="/tpl/js/advert.js"></script>
      <script src="/tpl/js/userInfo.js?1"></script>
      <script src="/tpl/js/main.js?5.7.8.5"></script>
      <script>
      var user = {
          name: "{user.name.js}",
          id: {id},
      }
      </script>
   </head>
   <body onload="onloadPage();">
       [no-reg]
       <section class="no-reg_section trans">
            <div class="nucleus-logo-descr-login-reg">
                <div class="nucleus-logo fll">
                    <div class="logo-main">Nucleus</div>
                    <div class="descr-main">%logo_title%</div>
                    <div class="step-descr">
                       <span>%logo_question%</span>
                       <div>
                         <span>%logo_answer%<br/>%logo_answer_c%</span>
                       </div>
                    </div>
                </div>
                <div class="fll left-form-login">
                  <div class="login-reg-bl">
                    <div class="error-reg-or-auth" id="error_reg_or_auth"></div>
                    <input type="text" id="login" class="inp bl mrgB" placeholder="%email%">
                    <input type="password" id="pass" class="inp bl mrgB" placeholder="%password%">
                    <span class="bl wh">%login_info%</span>
                    <div class="auth-reg">
                        <div class="login-reg-status" id="status_login_reg"></div>
                        <div class="login-bl-btn">
                            <button class="btn" id="btn_login" onclick="join.login()">%log_in%</button>
                            <button class="btn btnReg" id="btn_reg" onclick="join.reg()">%sign_up%</button>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
            </div>
       </section>
       <section class="link-f-m">
            <div class="footer-link">
                <div class="fll" style="width: calc(100% / 3)">
                    <span>Nucleus {version}</span>
                    <span class="lang-sp" onclick="lang_.openBox()">ru</span>
                </div>
                <div class="fll" style="width: calc(100% / 3);text-align: center;">
                    <span><a href="/about" class="footer-link-a none">%about%</a></span>
                    <span><a href="/terms" class="footer-link-a">%terms%</a></span>
                    <span><a href="/developers/" class="footer-link-a">%developers%</a></span>
                </div>
                <div class="flr" style="width: calc(100% / 3); text-align: right;">
                    <span>2016</span>
                </div>
                <div class="clear"></div>
            </div>
       </section>
       <section id="ajax_load_block_" style=""></section>
       [/no-reg]
       [reg]
       <header class="header"><div class="header-content" id="header_content">
                <div class="header-icon-menu">
                   <i class="header-icon icon" id="icon" onclick="menu.show()"></i>
                </div>
                <div class="header-logo-content">
                    <div class="header-logo">
                        <a href="/" onclick="return ajax.page(this.href)" class="header-logo-a">Nucleus</a>
                    </div>
                </div>
                <div class="header-right-panel">
                    <span class="header-right-panel-span" id="header_panel_title">Лента</span>
                </div>
                <div class="header-user-right-panel mobile-display-none">
                    <div class="header-user-right">
                        <a href="/id{id}" onclick="newProfileHeader();return ajax.page(this.href);"><div class="user-rds-b" id="profile_icon" style="background-image: url({icon-profile})"></div></a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
       </header>
       <section class="main-content-page">
            <div class="left-panel-fx" id="left_panel_fx">
                <div class="left-panel-content">
                    <div class="left-panel-cnt-block-search">
                       <input type="text" class="inp-search" id="inp_search" placeholder="Search" onkeyup="search.req_(event, this.value)">
                    </div>
                    <div class="left-panel-link-menu">
                        <div class="link-menu-div">
                            <a href="/lenta" id="link" class="mobile-display-none link-menu-a link-menu-a-bef link-lenta" onclick="return ajax.page(this.href);">Обновления</a>
                        </div>
                        <div class="link-menu-div">
                            <a href="/competition" id="link" class="mobile-display-none link-menu-a link-menu-a-bef link-lenta" onclick="return ajax.page(this.href);">Конкурс</a>
                        </div>
                        <div class="link-menu-div">
                            <a href="/subscription" id="link" class="mobile-display-none link-menu-a link-menu-a-bef link-sub" onclick="return ajax.page(this.href);">Подписки</a>
                        </div>
                        <div class="link-menu-div">
                            <a href="/photo" class="mobile-display-none link-menu-a link-menu-a-bef link-photo" onclick="return ajax.page(this.href);">Категории</a>
                        </div>
                        <div class="link-menu-div">
                            <a href="/reply" class="mobile-display-none link-menu-a link-menu-a-bef link-reply" onclick="return ajax.page(this.href);">Ответы</a>
                            <span id="new_notify" class="none"></span>
                        </div>
                        <div class="br"></div>
                        <div class="link-menu-div">
                            <a href="/settings" class="link-menu-a link-menu-a-bef link-set" onclick="return ajax.page(this.href);">Настройки</a>
                        </div>
                        <div class="link-menu-div">
                            <a href="/index.php?act=log_out" class="link-menu-a link-menu-a-bef" onclick="">Выход</a>
                        </div>
                        <div class="br"></div>
                        <div class="mobile-display-none link-menu-div">
                            <a href="#" class="link-menu-a link-menu-a-bef" onclick="feedback.showBox('block')">Сообщить об ошибке</a>
                        </div>
                        <div class="br mob-br"></div>
                    </div>
                </div>
            </div>
            <div class="main-content-page-l" id="main">
            <div class="big-info none" id="big_info">
        	<div class="big-image-block fll">
        		<div class="big-img"></div>
        	</div>
        	<div class="big-info-content fll">
        		<b>Сайт еще в разработке</b><br/>
        		Данный сайт находится на стадии разработки, поэтому некоторые разделы еще не функционируют
        		или функционируют, но с ошибками, правда не все. Но! Если Вы обнаружите недочет, баг, пожалуйста,
        		сообщите об этом через специальную форму "Сообщить об ошибке" и детально расскажите о ней.
        		Спасибо!
        		<div class="big-info-btn">
                    <a href="#" onclick="bigInfo.close()">свернуть</a>
        		</div>
        	</div>
        	<div class="clear"></div>
        </div>
                {content}
            </div>
       </section>
       <section class="mobile-fixed-menu">
            <div class="fll mobile-menu-s mobile-menu-p-s">
                <div class="mobile-menu-p" id="fx_home" onclick="fxMobileMenu.e(this.id);return ajax.page('/lenta');">
                    <div class="mobile-menu-icon icon-home"></div>
                </div>
            </div>
            <div class="fll mobile-menu-s mobile-menu-p-s">
                <div class="mobile-menu-p" id="fx_competition" onclick="fxMobileMenu.e(this.id);return ajax.page('/competition');">
                    <div class="mobile-menu-icon icon-sh"></div>
                </div>
            </div>
            <div class="fll mobile-menu-s mobile-menu-p-s">
                <div class="mobile-menu-p" id="fx_photo" onclick="fxMobileMenu.e(this.id);return ajax.page('/photo');">
                    <div class="mobile-menu-icon icon-camera"></div>
                </div>
            </div>
            <div class="fll mobile-menu-s mobile-menu-p-s">
                <div class="mobile-menu-p" id="fx_notify" onclick="fxMobileMenu.e(this.id);return ajax.page('/reply');">
                    <div class="mobile-menu-icon icon-notify"></div>
                    <span id="new_notify_mobile" class="none"></span>
                </div>
            </div>
            <div class="fll mobile-menu-s">
                <div class="mobile-menu-p" id="fx_profile" onclick="fxMobileMenu.e(this.id);return ajax.page('/id{id}');">
                    <div class="user-rds-b mobile-menu-image-profile" id="profile_icon" style="background-image: url({icon-profile})"></div>
                </div>
            </div>
            <div class="clear"></div>
       </section>
       <div class="plad">
               Кажется, Вы заблокировали рекламу с помощью AdBlock или другого расширения. Мы предлагаем Вам внести наш 
               сайт в список исключений, за что Вы получите вознаграждение в виде дополнительных баллов к своей репутации (+50).
       </div>
       <section id="ajax_load_block" style=""></section>
       <section id="loading_block">
           <div class="loading-content">
               <div class="loading-spl-content">
                   <div class="loading-spl loading-spl-o"></div>
                   <div class="loading-spl loading-spl-t"></div>
                   <div class="loading-spl loading-spl-th"></div>
               </div>
           </div>
       </section>
       <script>//ge("link").click();</script>
       <script defer>
       function newProfileHeader() {
            var header_content_ = document.querySelectorAll(".header-content")[0];
            header_content_.classList.add("new-profile-header");
       }
       function updateTitle(pathName = "") {
           pathName = pathName == "" ? document.location.pathname.split("/")[1] : pathName;
           var len_path = document.location.pathname.split("/").length;
           var title_ = ge("title");
           var header_panel_title = ge("header_panel_title");
           
           var header_content_ = document.querySelectorAll(".header-content")[0];
           var main_content = document.querySelectorAll(".main-content-page")[0];
           var header_logo = document.querySelector(".header-logo");
           var profile_cover = document.querySelector(".profile-cover-img");
           
           if (/ID[0-9]{1,}/i.test(pathName)) {
                if (screen.width <= 640) {
                  header_content_.classList.add("new-profile-header");
                  header_logo.style.display = "none"; 
                }
                title_.innerHTML = "Профиль пользователя Nucleus";               
                header_panel_title.innerHTML = "";
                ge("fx_profile").style.opacity = "1";
                fxMobileMenu.fx_default = "fx_profile";
                return false;
           }
           
           header_content_.style.opacity = 1;
           header_logo.style.display = "block";
           header_content_.classList.remove("new-profile-header");
           
           switch (pathName) {
             case "lenta":
               title_.innerHTML = "Лента";               
               header_panel_title.innerHTML = "Лента";
               ge("fx_home").style.opacity = "1";
               fxMobileMenu.fx_default = "fx_home";
               break;
                    
             case "subscription":
               title_.innerHTML = "Подписки";               
               header_panel_title.innerHTML = "Подписки"; 
               break;
                    
             case "friends":
               title_.innerHTML = "Подписчики";               
               header_panel_title.innerHTML = "Подписчики"; 
               break;
                    
             case "photo":
               if (len_path == 3) {
                 title_.innerHTML = "Фотографии"; 
                 header_panel_title.innerHTML = "Фотографии"; 
                 break;     
               }
               ge("fx_photo").style.opacity = "1"; 
               fxMobileMenu.fx_default = "fx_photo";
               title_.innerHTML = "Категории";               
               header_panel_title.innerHTML = "<span onclick=\"photo.pageUploadPhotoShow()\">Загрузить фотографию</span>"; 
               break;
               
             case "room":
               title_.innerHTML = "Комната общения";
               header_panel_title.innerHTML = "Комната общения";
               break;
             
             case "competition":
               title_.innerHTML = "Конкурс"; 
               header_panel_title.innerHTML = "Конкурс";  
               ge("fx_competition").style.opacity = "1";
               fxMobileMenu.fx_default = "fx_competition";
               break;
                    
             case "reply":
               title_.innerHTML = "Ответы";               
               header_panel_title.innerHTML = "Ответы"; 
               ge("fx_notify").style.opacity = "1";
               fxMobileMenu.fx_default = "fx_notify";
               break;
      
             case "store":
               title_.innerHTML = "Магазин";               
               header_panel_title.innerHTML = "Магазин"; 
               break;

             case "store/cancel":
               title_.innerHTML = "Магазин";               
               header_panel_title.innerHTML = "Магазин"; 
               break;
 
             case "store/thank":
               title_.innerHTML = "Магазин";               
               header_panel_title.innerHTML = "Магазин"; 
               break;
                    
             case "settings":
               title_.innerHTML = "Настроки";               
               header_panel_title.innerHTML = "Настройки"; 
               break;

             case "search":
               title_.innerHTML = "Поиск";               
               header_panel_title.innerHTML = "Поиск"; 
               break;
                    
             default:
               title_.innerHTML = "Лента";               
               header_panel_title.innerHTML = "Лента";
               break;
           }
       }
       
       updateTitle();
       </script>
       <script>
       function upload_click(bool = false) {
            if (bool)
                 upload(true);
            else 
                 upload(true, true);
       }
       function upload(bool = false, bool1 = false) {
            var input = document.forms.upload.elements.photo;
            var file = input.files[0];
            var type = file.type.toLowerCase().split("/")[1];
            var arr_type = ['jpeg', 'png'];
            var size_max = 1024*1024*15; 
            var size = file.size;
            var name = file.name;
            
            var name_block_mobile = ge("photo_name_res");
            if (name_block_mobile != null) name_block_mobile.innerHTML = name;
            
            if (size_max < size) {
                confirmBox.info("Пожалуйста, выбирите фотографию меньшего размера. Максимальный размер фотографии 15МБ.");
                return;
            }
            
            if (find(arr_type, type) == -1) {
        	   confirmBox.info("Неверный тип файла. Мы поддерживаем такие форматы, как JPEG и PNG .");
        	   return;
            }
            
            if (file) {
                upload_file(file, bool, bool1);
            }
       }
       </script>
       [/reg]
   </body>
</html>
