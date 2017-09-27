<div class="profile-button-block">
    <div class="profile-button">
        <button class="profile-btn" onclick="photo.openBox()">Изменить фото</button>
    </div>
    <div class="profile-button">
        <button class="profile-btn btn_p new-profile-bg" onclick="store.h()">Как продвигать профиль</button>
    </div>
</div>
<form name="upload" action='/index.php?act=upload&a=photo' method='post' enctype='multipart/form-data' target="rframe">
     <div style='display:none'>
         <input type='file' id='photo' name='photo' onchange='upload_click(true);' multiple="true" style='visibility: hidden; position: absolute;'>
         <input type='submit' name='load' id='load'>
      </div>
</form>
<iframe name='rframe' id='rframe' width="300" height="50" class='iframe_music' hidden></iframe>
<script>/*
   function upload_click() {
       upload();
   }
   function upload() {
       var input = document.forms.upload.elements.photo;
       var file = input.files[0];
       if (file) {
           upload_file(file, true);
       }
   }*/
</script>