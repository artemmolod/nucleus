<style>
   @import url(/tpl/css/intro.css?v=48);
</style>
<div class="intro-main">
    <div class="intro-container">
        <div class="intro-step-container">
        
            <div class="intro-step">
                <div class="step-image" onclick="view.Next(1)">
                    <img src="{src}" class="step-img-p">
                </div>
                <div class="step-title">
                    <div class="st-header">{name}, добро пожаловать!</div>
                    <div class="st-title">
                        Мы рады видеть Вас на нашем сайте и хотим сразу научить Вас
                        им пользоваться. Это не займет так много времени, мы обещаем!
                        <div class="st-btn">
                            <button class="st-button" onclick="view.Next(1)">Начать обучение</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-lenta" onclick="view.Next(2)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Лента</div>
                    <div class="st-title">
                        В данном разделе собраны самые популярные фотографии и пользователи. В него очень трудно попасть,
                        но мы то знаем, что у Вас получится. Также под каждой фотографией есть специальная кнопка, <br/>которая покажет комментарии.
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-reply"  onclick="view.Next(3)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Страница ответов</div>
                    <div class="st-title">
                        Данный раздел моментально уведомит Вас о новых подписчиках, комментариях и приобритенном рейтинге.
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-photo" onclick="view.Next(4)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Основные категории</div>
                    <div class="st-title">
                        Здесь собраны основные категории сайта. В будущем, появится возможность<br/>
                        создавать свои категории и изменять уже существующие. 
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-rating" onclick="view.Next(5)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Рейтинг</div>
                    <div class="st-title">
                        Чем выше рейтинг, тем выше Ваши фотографии в ленте и больше шансов<br/>
                        выйграть главный конкурс. Голосовать за фотографии можно, <br/>
                        нажав на нее, но помните, голосовать ЗА или ПРОТИВ<br/>
                        можно только один раз.
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-profile" onclick="view.Next(6)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Личный профиль</div>
                    <div class="st-title">
                        Эта Ваша личная страничка, в которой можете увидеть краткую информацию о Вас.
                        Здесь Вы также можете узнать Ваш рейтинг и другую Вашу статистику.<br/>Именно эта страничка будет доступна другим пользователям.
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-con" onclick="view.Next(7)"></div>
                <div class="step-title pad10">
                    <div class="st-header">Еженедельный конкурс</div>
                    <div class="st-title">
                        Все любят получать подарки или призы. Вот мы и решили устраивать еженедельный конкурс
                        "Король недели". Всего 3 выйгрышных места. 1 получает все! Более подробно о конкурсе можно
                        почитать на этой <a href="/about_the_competition" target="_blank">странице</a>. Мы будем держать за Вас кулачки!
                    </div>
                </div>
            </div>
            
            <div class="intro-step">
                <div class="step-image step-image-finish"></div>
                <div class="step-title pad10">
                    <div class="st-header">Мы рады Вам</div>
                    <div class="st-title">
                        Вам у нас понравится! А теперь Вы смело можете начать работу с нашим сервисом.
                        Желаем удачи.
                        <div class="st-btn">
                            <a href="/lenta" onclick="view.delLocalKey();return ajax.page(this.href);">
                               <button class="st-button">Перейти к ленте</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="intro-control-container">
        <div class="intro-control" onclick="view.Next(0)" id="control0"></div>
        <div class="intro-control" onclick="view.Next(1)" id="control1"></div>
        <div class="intro-control" onclick="view.Next(2)" id="control2"></div>
        <div class="intro-control" onclick="view.Next(3)" id="control3"></div>
        <div class="intro-control" onclick="view.Next(4)" id="control4"></div>
        <div class="intro-control" onclick="view.Next(5)" id="control5"></div>
        <div class="intro-control" onclick="view.Next(6)" id="control6"></div>
        <div class="intro-control" onclick="view.Next(7)" id="control7"></div>
    </div>
</div>