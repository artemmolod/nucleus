﻿<div class="album-photo-block" id="album_photo_{id}">
    <div class="album-photo" id="album_photo__{id}">
       <img src="{src}" alt="{descr}" class="album-photo-i" id="photo_{id}" onclick="album.vote({id})">
       <div class="menu-list-photo album-menu-list-photo" id="menu_list_{id}">
           <div class="menu-list-block">
               <div class="menu-list-container">
                   <button class="main-button wid100 mrg5-top {none_delete}" onclick="{onclick}">Удалить</button>
                   <button class="main-button wid100 mrg5-top {none_report}" onclick="{onclick1}">Пожаловаться</button>
                   <button class="main-button wid100 mrg10-top" onclick="comment.s({id})">Комментарии</button>
               </div>
           </div>
       </div>
    </div>
    <div class="album-photo-info lenta-photo-info" id="album_photo_info_{id}">
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
           <div class="rating-photo-block">
              <span class="photo-rating">{photo-rating}</span>
           </div>
       </div>
    </div>
</div>
<div class="pad5"></div>
{album-photo-OR-not-photo-in-album}