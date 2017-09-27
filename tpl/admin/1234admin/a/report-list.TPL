<div class="a-block-con a-margin15" id="report_{id}">
  <div class="a-block-con-header">
    Жалоба на {type}
   </div>
  <div class="a-block-con-main">
      <div class="fll a-block-label">Автор:</div>
      <div class="fll a-block-num-l"><a href="{author}" target="_blank">web-nucleus.com{author}</a></div>
      <div class="fll a-block-label">Комментарий:</div>
      <div class="fll a-block-num-l">{report-comment}</div>
      <div class="fll a-block-label">Причина:</div>
      <div class="fll a-block-num-l">{report-theme}</div>
      <div class="fll a-block-label">Ссылка:</div>
      <div class="fll a-block-num-l"><a href="{src}" {onclick}>{src_}</a></div>
      <div class="clear"></div>
      <div class="a-block-btn-rep">
        <button class="a-btn-main" onclick="admin.delReport({id})">удалить</button>
        <button class="a-btn-main" onclick="admin._Report({id}, '{type}')">принять</button>
      </div>
  </div>
  <div style="display:none" id="report_user_{id}">
      <div class="a-block-con-header">Действие</div>
      <div class="a-block-con-main">
          <div class="a-input-w">
              <input type="text" id="user_id" class="a-input" value="{uid}" disabled>
          </div>
          <div class="a-btn-block">
              <button onclick="admin.blockUser()" class="a-btn-main">Заблокировать пользователя</button>
              <button onclick="admin.delUser()" class="a-btn-main">Удалить пользователя</button>
              <button onclick="admin.zeroRatingUser()" class="a-btn-main">Обнулить рейтинг</button>
          </div>
     </div>
  </div>
  <div style="display:none" id="report_photo_{id}">
      <div class="a-block-con-header">Действие</div>
      <div class="a-block-con-main">
          <div class="a-input-w">
              <input type="text" id="photo_id" class="a-input" value="{uid}" disabled>
          </div>
          <div class="a-btn-block">
              <button onclick="admin.delPhoto()" class="a-btn-main">Удалить фотографию</button>
              <button onclick="admin.zeroRatingPhoto()" class="a-btn-main">Обнулить рейтинг</button>
          </div>
      </div>
  </div>
  <div id="status" style="padding: 20px 20px 0;"></div>
  <div class="pad10"></div>
</div>
{list-report}