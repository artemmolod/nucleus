<div id="ajax_page" style="margin-top: -25px;">
    <div class="photo">
        <div class="photo-container">
            <div class="page-header" id="header_title">
                Основные категории
            </div>
            <div class="load-photo-container-mobile" id="container_mobile">
               <div class="page-header">
                  Загрузка фотографии
               </div>
               <div class="container-mobile-form">
                  <div class="container-mobile-div">
                    <span class="container-mobile-span">Фотография: <span id="photo_name_res">не выбрана</span></span>
                    <button class="main-button btn-mobile-w" onclick="fb.selectPhoto()">Выбрать фотографию</button>
                    <div class="pad5"></div>
                    <select id="preview_category_mobile" class="preview-category-image btn-mobile-w">
                       <option value="0" selected>Выбирите категорию</option>
                       <option value="1">Животные</option>
                       <option value="2">Еда и напитки</option>
                       <option value="3">Люди о общество</option>
                       <option value="4">Технологии</option>
                       <option value="5">Природа</option>
                       <option value="6">Селфи</option>                                
                    </select>
                    <div class="pad5"></div>
                    <input type="text" style="width: 96.4%;" id="preview_title_mobile" class="preview-input" placeholder="Добавте название (необязательно)">
                    <div class="pad5"></div>
                    <textarea class="preview-text" style="width: 93.4%;" placeholder="Добавте описание  (необязательно)" id="preview_text_mobile"></textarea>
                    <span id="upload_result"></div>
                    <div class="pad5"></div>
                    <button class="btn-g btn-mobile-w" onclick="fb.uploadPhoto()">Загрузить фотографию в альбом</button>
                    <div class="pad5"></div>
                    <button class="btn-b btn-mobile-w" onclick="fb.clear()">нет, я передумал</button>
                  </div>
               </div>
            </div>
            <div class="photo-container-main" onclick="card.view(event)" id="card_category">
                <div class="photo-card-category" id="card_animal">
                    <div class="photo-card-category-b category-animal"></div>
                    <div class="title-category" id="card1"><span>Животные</span></div>
                </div>
                <div class="photo-card-category" id="card_eats">
                    <div class="photo-card-category-b category-eats"></div>
                    <div class="title-category" id="card2"><span>Еда и напитки</span></div>
                </div>
                <div class="photo-card-category" id="card_people">
                    <div class="photo-card-category-b  category-people"></div>
                    <div class="title-category" id="card3"><span>Люди о общество</span></div>
                </div>
                <div class="photo-card-category" id="card_tech">
                    <div class="photo-card-category-b  category-technology"></div>
                    <div class="title-category" id="card4"><span>Технологии</span></div>
                </div>
                <div class="photo-card-category" id="card_nature">
                    <div class="photo-card-category-b  category-nature"></div>
                    <div class="title-category" id="card5"><span>Природа</span></div>
                </div>
                <div class="photo-card-category" id="card_selfie">
                    <div class="photo-card-category-b  category-selfie"></div>
                    <div class="title-category" id="card6"><span>Селфи</span></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="upload-page-photo" id="upload_photo_page" style="display: none">
                <div class="upload-progress" id="upload_progress">
                    <div class="progress" id="progress" style="width: 620px;height: 30px; ">
                        <div class="progress-percent" style="height: 100%;padding: 2.2px;">Выполнено <span id="percent">0%</span></div>
                        <div class="progress-line" id="progress_line" style="height: 30px;">
                            <div class="done-progress-persent" style="width: 620px;height: 100%;padding: 2.2px;">Выполнено <span id="percent_">0%</span></div>
                        </div>
                    </div>
                </div>
                <div class="processing-start" id="processing_start" style="display: none;">
                    <div class="processing-text" id="processing_text">
                        <span>Пожалуйста, подождите ...</span>
                    </div>
                </div>
                <div class="preview-image-load" id="preview" style="display: none;">
                    <div class="preview-image">
                        <img alt="preview image" id="preview_image">
                    </div>
                    <div class="preview-info-image">
                        <div class="preview-desrc-image">
                            <textarea class="preview-text" placeholder="Добавте описание" id="preview_text"></textarea>
                        </div>
                        <div class="preview-title-image">
                            <input type="text" id="preview_title" class="preview-input" placeholder="Добавте название">
                            <select id="preview_category" class="preview-category-image">
                                <option value="0" selected>Выбирите категорию</option>
                                <option value="1">Животные</option>
                                <option value="2">Еда и напитки</option>
                                <option value="3">Люди о общество</option>
                                <option value="4">Технологии</option>
                                <option value="5">Природа</option>
                                <option value="6">Селфи</option>                                
                            </select>
                        </div>
                        <div class="upload-info-preview-image">
                            <button class="preview-bnt" onclick="album.upload()">Загрузить</button>
                        </div> 
                        <div class="clear"></div>
                        <div class="pad10"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fb-btn-fixed" id="fb_btn_fixed" onclick="fb.loadPhotoNew()">
            <span></span>
        </div>
	<form name="upload" action='/index.php?act=upload&a=newPhoto' method='post' enctype='multipart/form-data' target='rframe'>
            <div style='display:none'>
               <input type='file' id='photo' name='photo' onchange='upload_click();' multiple="true" style='visibility: hidden; position: absolute;'>
               <input type='submit' name='load' id='load'>
            </div>
         </form>
         <iframe name='rframe' id='rframe' width="300" height="50" class='iframe_music' hidden></iframe>
    </div>
    <script>/*
    function upload_click() {
        upload();
    }
    function upload() {
        var input = document.forms.upload.elements.photo;
        var file = input.files[0];
        if (file) {
            upload_file(file, true, true);
        }
    }*/
</script>
</div>