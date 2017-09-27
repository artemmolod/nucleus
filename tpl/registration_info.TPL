<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="utf-8" />
      <title id="title">Начало работы</title>
      <link rel="stylesheet" href="/tpl/css/main.css" media="screen" />
      <link rel="stylesheet" href="/tpl/css/reg_info.css" media="screen">
      <script src="/tpl/js/main.js"></script>
      <script src="/tpl/js/reg_info.js"></script>
   </head>
   <body>
      <div class="reg-main">
          <div class="reg-container">
              <div class="reg-header-tab" id="reg_title">   
                  <div class="reg-title-tab">
                     <span id="tab_">Начало работы</span> <span id="reg_name"></span>
                  </div>
              </div>
              <div style="margin-top: -14px;">
                  <div class="reg-line-progress reg-line-progress-step-1">
                      <div class="reg-line-progress-st-1 reg-line-p-s"></div>
                  </div>
                  <div class="reg-line-progress reg-line-progress-step-2">
                      <div class="reg-line-progress-st-2 reg-line-p-s"></div>
                  </div>
                  <div class="reg-line-progress reg-line-progress-step-3">
                      <div class="reg-line-progress-st-3 reg-line-p-s"></div>
                  </div>
              </div>
              <div class="reg-container-form">
                  <div class="reg-container-form-info-st-1" id="step1">
                     <div class="reg-container-form-info-st-1-t-i">
                        <div class="fll reg-form-info-s">
                           <div class="reg-info-t-f">Имя:</div>
                        </div>
                        <div class="fll reg-form-info-f">
                           <div class="reg-info-t-f-o">
                              <input type="text" class="reg-input" id="first_name">
                           </div>
                        </div>
                        <div class="clear"></div>
                     </div>
                     <div class="reg-container-form-info-st-1-t-i">
                        <div class="fll reg-form-info-s">
                           <div class="reg-info-t-f">Фамилия:</div>
                        </div>
                        <div class="fll reg-form-info-f">
                           <div class="reg-info-t-f-o">
                              <input type="text" class="reg-input" id="last_name">
                           </div>
                        </div>
                        <div class="clear"></div>
                     </div>
                     <div class="reg-container-form-info-st-1-t-i">
                        <div class="fll reg-form-info-s">
                           <div class="reg-info-t-f">День рождения:</div>
                        </div>
                        <div class="fll reg-form-info-f">
                           <div class="reg-info-t-f-o">
                              <input type="date" class="reg-input" id="bdate" style="padding: 5px 0;width: 171px;">
                           </div>
                        </div>
                        <div class="clear"></div>
                     </div>
                     <div class="reg-container-form-info-st-1-t-i">
                        <div class="fll reg-form-info-s">
                           <div class="reg-info-t-f">Пол:</div>
                        </div>
                        <div class="fll reg-form-info-f">
                           <div class="reg-info-t-f-o">
                              <select id="sex" class="reg-select" style="width: 175px;">
                                 <option value="-1">Выбирите пол</option>
                                 <option value="2">Женский</option>
                                 <option value="1">Мужской</option>
                              </select>
                           </div>
                        </div>
                        <div class="clear"></div>
                     </div>
                     <div class="flr reg-form-bnt-s">
                         <button class="btn" onclick="return reg_info.stepOne()" id="btn_reg_info">Перейти ко 2 шагу</button> 
                     </div>
                     <div class="clear"></div>
                  </div>
                  <div class="reg-container-form-info-st-1" id="step2" style="display: none">
                     <div class="reg-form-phoro-f">
                        Загрузите фотографию своего профиля. Поддерживаемые форматы: JPG, JPEG, PNG.
                        Размер фотографии не должен превышать 200мб. 
                     </div>
                     <div class="upload-btn-photo">
                       <button class="btn" id="btn_upload" onclick="reg_info.stepTwo();">Загрузить фотографию</button>
                       <div class="progress" id="progress">
                           <div class="progress-line" id="progress_line"></div>
                       </div>
                     </div>
                     <div class="flr reg-form-bnt-s">
                         <button class="btn" onclick="return reg_info.stepNext(3)" id="btn_reg_info">Перейти к 3 шагу</button> 
                     </div>
                     <div class="clear"></div>
                  </div>
                  <div class="reg-container-form-info-st-1" id="step3" style="display: none">
                      <div class="reg-form-phoro-f">
                        Спасибо за регистрацию. Теперь Вы можете начать работу с сайтом.
                     </div>
                     <div class="upload-btn-photo">
                       <a href="/" class="link">перейти в ленту</a>
                     </div>
                  </div>
              </div>
          </div>
      </div>
      <div style='display:none'>
          <input type='file' id='photo' name='photo' onchange="return loadFileForm(this.id)" multiple="true" style='visibility: hidden; position: absolute;'>
      </div>
      <script>
        function loadFileForm(id) {
             var input = ge(id);
             var file = input.files[0];
             if (file) {
                var xhr = xml.http();
                var form = new FormData();
                var btn = ge('btn_upload');
                var url = '/index.php?act=upload&a=photo';
                
                if (btn != null) btn.style.display = 'none';
    
                var pr = ge('progress');
                var percent = ge("percent");
                var percent_ = ge("percent_");
                if (pr != null) pr.style.display = "block";
    
                xhr.upload.onprogress = function(event) {
                    var total = event.total;
                    var load  = event.loaded;
                    var progress = ge('progress_line');
                    var prof  = load / total * 100;
        
                     if (progress != null && percent != null && percent_ != null) {
                        progress.style.width = Math.floor(prof) + '%';
                        percent.innerHTML = Math.floor(prof) + '%';
                        percent_.innerHTML = Math.floor(prof) + '%';
                     } else {
                        progress.style.width = Math.floor(prof) + '%';
                     }
        
                     if (Math.floor(prof) == 100) {
                         setTimeout(function() {
                           reg_info.stepNext(3);
                         }, 1000);
                     }
                }
    
                xhr.onload = xhr.onerror = function() {
                  if (this.status == 200) {
                         console.log('success');
                  } else {
                         console.log('error ' + this.status);
                  }
                }
                
                form.append('photo', file);
                xhr.open('POST', url, true);
                xhr.send(form);
             }
          }
       </script>
   </body>
</html>