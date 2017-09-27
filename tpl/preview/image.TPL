<div class="preview-image preview-image-see">
   <div class="preview-image-block" onclick="album.vote({id})">
      <img src="{src}" style="{css}" class="preview-image-i" alt="Image" />
   </div>
   <div class="preview-image-vote">
      <div class="preview-image-author-block">
          <div class="fll preview-image-author-i user-rds-b" style="background-image: url({icon-user})"></div>
          <div class="fll preview-image-author-s">
              <div class=""><a href="/id{uid}">{name}</a></div>
              <div class="preview-image-date">{date} в категорию: "{category}"</div>
              <div class="preview-image-descr {none}">
                  <div><b>{title}</b></div>
                  <div>{text}</div>
              </div>
          </div>
          <div class="flr preview-image-promotion">
              <i class="promotion-icon" title="Продвижение публикации" onclick="promotion.showDialogPromotion({id})"></i>
          </div>
          <div class="clear"></div>
      </div>
      <div class="preview-image-footer">
          <div class="fll preview-image-rating">Рейтинг: <b>{rating}</b></div>
          <div class="fll preview-image-comment" onclick="comment.s({id})">Комментарии</div>
          <div class="flr preview-image-r" onclick="{clickReport}">{txt-btn}</div>          
          <div class="clear"></div>
      </div>
   </div>
</div>
<div class="preview-close close" onclick="preview.close()"></div>