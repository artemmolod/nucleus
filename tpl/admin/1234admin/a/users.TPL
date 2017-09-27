<div id="ajax_page">
  <div class="a-block-con">
    <div class="a-block-con-header">
       Пользователи
    </div>
    <div class="a-block-con-main">
      <div class="a-input-w">
        <input type="text" id="user_id" class="a-input" placeholder="ID пользователя">
      </div>
      <div class="a-btn-block">
        <button onclick="admin.blockUser()" class="a-btn-main">Заблокировать пользователя</button>
        <button onclick="admin.delBlockUser()" class="a-btn-main">Разблокировать пользователя</button>
        <button onclick="admin.delUser()" class="a-btn-main">Удалить пользователя</button>
        <button onclick="admin.livUser()" class="a-btn-main">Восстановить пользователя</button>
        <button onclick="admin.verUser()" class="a-btn-main">Верифицировать пользователя</button>
        <button onclick="admin.zeroRatingUser()" class="a-btn-main">Обнулить рейтинг</button>
        <div id="status"></div>
      </div>
    </div>
    <div class="pad10"></div>
    
    <div class="a-block-con-header">
       Рассылка уведомлений
    </div>
    <div class="a-block-con-main">
      <div class="a-input-w">
        <input type="text" id="user_id_notify" class="a-input" placeholder="ID пользователя">
      </div>
      <div class="a-btn-block">
        <textarea id="text_notify" placeholder="Сообщение"></textarea>
        <button onclick="admin.sendNotify()" class="a-btn-main">Отправить</button>
        <div id="status_notify"></div>
      </div>
    </div>
    <div class="pad10"></div>
  </div>
</div> 