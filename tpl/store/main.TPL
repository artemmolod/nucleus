<div id="ajax_page">
  <div class="page-header">Магазин</div>
  <div class="warn-info">
    Платежи за реальные деньги пока не принимаются, приносим свои извинения.
  </div>
  <div class="store-container">
     <div class="pad5"></div>
     <div class="store-container-list">
     
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">+100</div>
         <div class="store-list-price">Рейтинг I класса за 22.00 руб.</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 22.00 руб." disabled>
           </form>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-s">+500</div>
         <div class="store-list-price">Рейтинг II класса за 110.00 руб.</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +500"> 
             <input type="hidden" name="item_number" value="2">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="110.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 110.00 руб." disabled>
           </form>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-gold">+2500</div>
         <div class="store-list-price">Рейтинг III класса за 550.00 руб.</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +2500"> 
             <input type="hidden" name="item_number" value="3">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="550.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 550.00 руб." disabled>
           </form>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-gold">+...</div>
         <div class="store-list-price">Любое количество рейтинга</div>
         <div class="store-list-btn">
           <input type="text" value="100" id="cnt_rating" onkeyup="store.cntRating(this.value)" class="store-input" placeholder="Введите количество рейтинга">
           <button class="main-button" disabled onclick="" id="store_btn_cnt_rating" style="margin-top: 10px;">купить за 22.00 руб.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">1 день премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 55.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(1)">купить за 250 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">3 дня премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 150.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(2)">купить за 750 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">7 дней премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 350.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(3)">купить за 1 750 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">30 дней премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 1 500.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(4)">купить за 7 500 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">90 дней премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 4 500.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(5)">купить за 22 500 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">180 дней премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 9 000.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(6)">купить за 45 000 рейтинга.</button>
         </div>
       </div>
       
       <div class="store-list fll">
         <div class="store-list-rating store-list-rating-b">премиум</div>
         <div class="store-list-price">360 дней премиум аккаунта</div>
         <div class="store-list-btn">
           <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
             <input type="hidden" name="cmd" value="_s-xclick">
             <input type="hidden" name="business" value="molodcov.artyom@mail.ru"> 
             <input type="hidden" name="item_name" value="Rating +100"> 
             <input type="hidden" name="item_number" value="1">
             <input type="hidden" name="rm" value="2"> 
             <input type="hidden" name="amount" value="22.00"> 
             <input type="hidden" name="hosted_button_id" value="XEKEQ622G3J94">
             <input type="hidden" name="return" value="http://test.com/store/thank">
             <input type="hidden" name="return_cancel" value="http://test.com/store/cancel">
             <input type="submit" class="main-button" value="купить за 18 000.00 руб." disabled>
           </form>
           <button class="main-button btn-c" onclick="store.buyGoods(7)">купить за 90 000 рейтинга.</button>
         </div>
       </div>
       
       <div class="clear"></div>
       <div class="store-promocode_">
         Есть промокод? Введи его на <a href="/store/bonus" onclick="return ajax.page(this.href)">специальной странице</a>.
       </div>
     </div>
  </div>
  <div class="pad10"></div>
</div>