<div class="subscription-main" id="subscription_main_{uid}">
     <div class="subscription-content">
         <div class="subscription-panel-user" id="panel_user_{uid}">
             <div class="subscription-header">
                 <img src="{src}" alt="" class="subscription-img">
             </div>
             <div class="subscription-footer">
                 <a href="/id{uid}" target="_blank">{name}</a>
             </div>
          </div>
          <div class="subscription-panel" id="panel_{uid}">
              <span class="bl">Действия</span>
              <div class="subscription-panel-container">
                  <div class="subscription-panel-btn">
                      <button class="subscription-panel-btn-m" onclick="subscription.del({uid})" id="btn_del_{uid}">Отписаться</button>
                  </div>
                  <div class="subscription-panel-btn">
                      <button class="subscription-panel-btn-m" onclick="report.show({uid}, 'user')">Пожаловаться</button>
                  </div>
                  <div class="subscription-panel-btn">
                      <button class="subscription-panel-btn-m clr-w" onclick="subscription.block({uid})" id="btn_block_{uid}">Заблокировать</button>
                  </div>
              </div>
          </div>
          <div class="spn-container subscription-container-spn" onclick="subscription.openPanel({uid})" id="spl_{uid}">
              <span class="spn"></span>
              <span class="spn"></span>
              <span class="spn"></span>
          </div>
     </div>
</div>
{list}