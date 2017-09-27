<div class="competition-lenta-list">
   <div class="competition-line-l-n">
      <div class="competition-lenta-line"></div>
      <div class="competition-lenta-place">
         <div class="competition-lenta-place-n">
            <span class="competition-place-n">{place-num}</span>
         </div>
      </div>
   </div>
   <div class="competition-lenta-photo">
      <div class="album-photo-block" id="album_photo_{id}">
          <div class="album-photo" id="album_photo__{id}">
             <img src="{src}" style="{style}" alt="{descr}" class="album-photo-i competition-p-a" id="photo_{id}" onclick="album.vote({id})">
             <div class="menu-list-photo" id="menu_list_{id}" style="bottom: 4px;">
                <div class="menu-list-block">
                   <div class="menu-list-container">
                      <button class="main-button wid100 mrg5-top {none_delete}" onclick="{onclick}">Удалить</button>
                      <button class="main-button wid100 mrg5-top {none_report}" onclick="{onclick1}">Пожаловаться</button>
                      <button class="main-button wid100 mrg10-top" onclick="comment.s({id})">Комментарии</button>
                   </div>
                </div>
             </div>
          </div>
          <div class="album-photo-info lenta-photo-info lenta-info competition-lenta-info" id="album_photo_info_{id}">
             <div class="album-photo-info-user">
                <div class="album-photo-info-user-i" style="background-image: url({url})"></div>
                <div class="album-photo-info-user-n">
                   <div class="album-name-u lenta-name-u">
                      <a href="/id{uid}">{name}</a> 
                      <span> загрузил {date} в {time}</span>
                   </div>
                   <div class="album-photo-menu">
                      <div class="spn-container" onclick="edit.showPanel({id})" id="spl_{id}">
                         <span class="spn"></span>
                         <span class="spn"></span>
                         <span class="spn"></span>
                      </div>
                   </div>
                   <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="album-photo-info-td">
                   <div class="album-photo-title">{title}</div>
                   <div class="album-photo-descr">{descr}</div>
                </div>
             </div>
         </div>
      </div>
      <div class="pad5" style="padding: 1px;"></div>
   </div>
</div>
{competition-lenta}