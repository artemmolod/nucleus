<div class="reply-list {new-notify}">
   <div class="fll reply-list-img" style="background-image: url({url})" onclick="return ajax.page('/id' + {uid});"></div>
   <div class="fll reply-list-info">
      <span class="reply-list-info-name span-block"><a href="/id{uid}">{name}</a> {reply}</span>
      <span class="reply-list-info-date span-block">
        {date} в {time}
        <div class="reply-list-msg" onclick="">
          {msg}
        </div>
      </span>
   </div>
   <div class="clear"></div>
</div>
{reply-content}