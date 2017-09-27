<div id="ajax_page">
    {block-user}
    <div class="profile">
        <div class="new-profile-block new-profile-bg">
            <div class="profile-cover new-profile-cover">
                {img_cover}
                <div class="profile-image-block new-profile-bg_image" style="background-image: url({photo_src})" id="profile_photo">
                   <div class="profile-image"></div>
                </div>
                <div class="new-profile-mobile-rating">
                   {rating}
                </div>
            </div> 
            <div class="profile-name-block new-profile-name_block">
               <div class="profile-name">
                   {name} 
                   {user-ver}
                   {king_status}
                   {premium_account}
               </div>
            </div>
            <div class="new-profile-user-info_c">
                <div class="user-info_c-m fll" onclick="return ajax.page('/photo/{uid}');">
                    <span class="user-info_c-s">{cnt_photo}</span>
                    <span class="user-info_c-t">фотографий</span>
                </div>
                <div class="user-info_c-m fll" onclick="return ajax.page('/subscription/{uid}');">
                    <span class="user-info_c-s">{friends}</span>
                    <span class="user-info_c-t">подписки</span>
                </div>
                <div class="user-info_c-m fll" onclick="return ajax.page('/friends/{uid}');">
                    <span class="user-info_c-s">{subscription}</span>
                    <span class="user-info_c-t">подписчики</span>
                </div>
                <div class="clear"></div>
           </div>
        </div>
        <div class="profile-info">
            <div class="edit-block-content">
               <div class="edit-block-content-t fll">Пол:</div>
               <div class="edit-block-content-n fll">{sex}</div>
               <div class="clear"></div>
           </div>
           <div class="edit-block-content">
               <div class="edit-block-content-t fll">День рождения:</div>
               <div class="edit-block-content-n fll">{bdate}</div>
               <div class="clear"></div>
           </div>
        </div>
        <div class="profile-data-info">
            <a href="/photo/{uid}" onclick="return ajax.page(this.href)" class="profile-link-panel">
               <div class="profile-data-info-block">
                   <div class="profile-data-info-block-up">{cnt_photo}</div>
                   <div class="profile-data-info-block-d">фото</div>
               </div>
            </a>
            <a href="/subscription/{uid}" onclick="return ajax.page(this.href)" class="profile-link-panel">
               <div class="profile-data-info-block">
                   <div class="profile-data-info-block-up">{friends}</div>
                   <div class="profile-data-info-block-d">подписки</div>
               </div>
            </a>
            <a href="/friends/{uid}" onclick="return ajax.page(this.href)" class="profile-link-panel">
               <div class="profile-data-info-block">
                  <div class="profile-data-info-block-up">{subscription}</div>
                  <div class="profile-data-info-block-d">подписчики</div>
               </div>
            </a>
            <div class="profile-data-info-block" onclick="king.showWindow({uid})">
                <div class="profile-data-info-block-up">{king_cnt}</div>
                <div class="profile-data-info-block-d">король</div>
            </div>
            <div class="profile-data-info-block">
                <div class="profile-data-info-block-up">{rating}</div>
                <div class="profile-data-info-block-d">рейтинг</div>
            </div>
        </div>
        {profile_btn}
        <div class="pad15">
            <div class="profile-block">
                <div class="profile-block-title">Лучшие фото</div>
                <div class="profile-block-content">{profile-photo-content}</div>
            </div>
        </div>
        {profile-promotion}
     </div>
     <div class="pad10"></div>
</div>