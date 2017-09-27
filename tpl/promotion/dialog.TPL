<div class="promotion-content">
    <div class="promotion-dialog">
        <div class="promotion-dialog-h">Продвижение публикации(beta)</div>
        <div class="promotion-dialog-c">
            <span id="status_p" style="display: none;margin-bottom: 10px;">Обработка..</span>
            <div id="warn_info_p" style="display:none">
               <b>Произошла ошибка</b><br/>
               <span id="warn_info_p_text"></span>
            </div>
            <div class="promotion-dialog-i">
               <b>Внимание!</b><br/>
               Продвижение чужой публикации стоит 100 баллов* своей репутации, вашей - 150 баллов*. Данная публикация появится у Вас в профиле и в разделе рекомендаций Ваших подписчиков.<br/><br/>
               Минимальное время продвижения публикации - <b>1 день</b><br/>
               Максимальное время продвижения публикации - <b>3 дня</b>.<br/><br/>
               <b>*</b> - стоимоть указана за 1 день.
            </div>
            <div class="promotion-dialog-s">
               <div>
                   Выбирите количество дней продвижения публикации:
                   <div class="promotion-d-s-days">
                      <button id="days1" onclick="promotion.selectCntDays(this.id)" class="promotion-btn-active promotion-d-btn">1 день</button>
                      <button id="days2" onclick="promotion.selectCntDays(this.id)" class="promotion-d-btn">2 дня</button>
                      <button id="days3" onclick="promotion.selectCntDays(this.id)" class="promotion-d-btn">3 дня</button>
                   </div>
               </div>
            </div>
        </div>
        <div class="promotion-dialog-f">
            <button class="main-button btn-f" onclick="preview.loadImage({pid})">назад</button>
            <button class="main-button" onclick="promotion.promotionPublic({pid})">Продвигать</button>
        </div>
    </div>
</div>