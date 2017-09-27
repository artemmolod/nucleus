<div class="a-block-con a-margin15" id="report_{id}">
  <div class="a-block-con-header">
    Ошибка
   </div>
  <div class="a-block-con-main">
      <div class="fll a-block-label">Автор:</div>
      <div class="fll a-block-num-l"><a href="/id{uid}" target="_blank">web-nucleus.com/id{uid}</a></div>
      <div class="fll a-block-label">Сообщение об ошибке:</div>
      <div class="fll a-block-num-l">{report-comment}</div>
      <div class="fll a-block-label">Дата:</div>
      <div class="fll a-block-num-l">{date}</div>
      <div class="clear"></div>
      <div class="a-block-btn-rep">
        <button class="a-btn-main" onclick="admin.delErrors({id})">удалить</button>
        <button class="a-btn-main" onclick="admin._Errors({id})">принять</button>
      </div>
  </div>
  <div class="pad10"></div>
</div>
{list-errors}