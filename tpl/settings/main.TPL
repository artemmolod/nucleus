<div id="ajax_page">
    <div class="settings-main">
        <div class="page-header">
            Настройки системы
        </div>
        <div class="settings-container">
            <div class="settings-category">Общие настройки</div>
            <div class="settings-block">
                <div class="settings-block-descr fll">
                    Имя и фамилия
                </div>
                <div class="settings-block-b fll">
                    <span onclick="settings.gi(1)">{name}</span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="settings-block">
                <div class="settings-block-descr fll">
                    Знакомство с нами
                </div>
                <div class="settings-block-b fll">
                    <span onclick="settings.gi(5)">Пройти</span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="settings-category settinsg-category-pad">Настройки доступа</div>
            <div class="settings-block">
                <div class="settings-block-descr fll">
                    Email
                </div>
                <div class="settings-block-b fll">
                    <span onclick="settings.gi(2)">{email}</span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="settings-block">
                <div class="settings-block-descr fll">
                    Пароль
                </div>
                <div class="settings-block-b fll">
                    <span onclick="settings.gi(3)">********</span>
                </div>
                <div class="clear"></div>
            </div>
            
            {premium-content}
            
            <div class="settings-category settinsg-category-pad color-red">Опасная зона</div>
            <div class="settings-block">
                <div class="settings-block-descr fll">
                    Отключить аккаунт
                </div>
                <div class="settings-block-b fll">
                    <span onclick="settings.gi(0)" class="color-red">Отключить</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>