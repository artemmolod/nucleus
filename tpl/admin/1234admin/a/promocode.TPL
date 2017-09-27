<div id="ajax_page">
  <div class="a-block-con">
    <div class="a-block-con-header">
      Управление промокодами
    </div>
    <div class="a-block-con-main">
      <div class="a-input-w">
        <input type="text" id="promocode" class="a-input" placeholder="Введите промокод">
      </div>
      <div class="a-btn-block">
        <button onclick="admin.promocode.gen()" class="a-btn-main">Сгенерировать промокод</button>
        <div id="status_generate"></div>
      </div>
    </div>
    <div class="a-block-con-header">
      Бонусы
    </div>
    <div class="a-block-con-main">
      <div class="fll a-block-label">Премиум аккаунт:</div>
      <div class="fll a-block-num-l"><input type="text" placeholder="Количество дней" id="count_days_premium"></div>
      <div class="fll a-block-label">Баллы репутации:</div>
      <div class="fll a-block-num-l"><input type="text" placeholder="Количество баллов"  id="count_points"></div>
      <div class="fll a-block-label">Лимит активации:</div>
      <div class="fll a-block-num-l"><input type="text" placeholder="Количество пользователей"  id="count_users_limit"></div>
      <div class="clear"></div>
      <div class="a-btn-block">
        <button onclick="admin.promocode.create()" class="a-btn-main">Создать промокод</button>
        <div id="status_create"></div>
      </div>
    </div>
    <div class="pad10"></div>
  </div>
  <div class="pad10"></div>
  <div class="a-block-con none" id="promocode_create_status">
    <div class="a-block-con-header" id="promocode_title">
      Промокод создан
    </div>
    <div class="a-block-con-main" id="promocode_content">
      
    </div>
    <div class="pad10"></div>
  </div>
</div> 