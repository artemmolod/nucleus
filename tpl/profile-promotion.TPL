<div class="profile-promotion-list">
  <div class="profile-promotion-c">
    <div class="profile-promotion-list-photo fll" onclick="preview.loadImage({pid})" style="background-image: url({pathImage})"></div>
    <div class="profile-promotion-user-info fll">
        <div class="profile-promotion-ui-name">
            <a href="/id{uid}" onclick="ajax.page(this.href)">{name}</a>
        </div>
        <div class="profile-promotion-ui-date">от {date}</div>
        <div class="profile-promotion-ui-cnt-days">Количество дней: {cntDays}</div>
    </div>
    <div class="clear"></div>
  </div>
</div>
{profile-promotion-list}