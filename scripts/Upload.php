<?php
   namespace Nucleus;

   use Nucleus\DB;

   define(DIR_FILE, $_SERVER['DOCUMENT_ROOT']."/upload/");

   class Upload
   {
        public $id;

        public function __construct() {
            $this->id = $_SESSION['id'];

            if (!$this->id) return;

            $dir = DIR_FILE.$this->id."/";
            if (!is_dir($dir)) {
                @mkdir($dir, 0777);
                @chmod($dir, 0777);
            }
        }

        public function formatsize($file_size) {
           if($file_size >= 1073741824){
                $file_size = round($file_size / 1073741824 * 100 ) / 100 ." √б";
           } elseif($file_size >= 1048576){
                $file_size = round($file_size / 1048576 * 100 ) / 100 ." ћб";
           } elseif($file_size >= 1024){
                $file_size = round($file_size / 1024 * 100 ) / 100 ."  б";
           } else {
                $file_size = $file_size." б";
           }
           return $file_size;
        }

        public function photo($aType = 0) {
           echo "Test: ".$aType."|";
           $db        = DB::getInstance();
           $file_name = $_FILES['photo']['name'];
           $file_tmp  = $_FILES['photo']['tmp_name'];
           $file_size = $_FILES['photo']['size'];
           $file_type = end(explode(".", $file_name));
           $size = 1024*1024*200; // 200mg
           $type = array('jpg', 'jpeg', 'png');
           echo "true |";

           if (in_array(strtolower($file_type), $type)) {
              echo "true |";
              if ($file_size < $size) {
                  echo "true |";
                  //$file_type = strtolower($file_type) == "gif" ? "gif" : "jpg";
                  $res_type = strtolower('.'.$file_type);

                  if ($aType == 0)
                      $dir = "upload/".$this->id."/photo/";
                  else
                      $dir = "upload/".$this->id."/album/";

                  if (!is_dir($dir)) {
                      @mkdir($dir, 0777);
                      @chmod($dir, 0777);
                  }

                  $down_name = md5($file_name.rand(0, 1000).$server_time);
                  if (move_uploaded_file($file_tmp, $dir.$down_name.$res_type)) {
                      $file_size_ = $this->formatsize($file_size);
                      if (!$file_name) $file_name = "Ѕез названи€".$res_type;

                      $strLn = strlen($file_name);
                      if($strLn > 50){
                          $file_name = str_replace('.'.$res_type, '', $file_name);
                          $file_name = substr($file_name, 0, 50).'...'.$res_type;
                      }

                      $file_name_md = $down_name.$res_type;

                      if ($aType == 0) {
                          $query = "UPDATE users SET photo_src = '".$file_name_md."' WHERE id = '$this->id'";
                          $result = $db->query($query);

                          //user_photo
                          $url = $dir.$file_name_md;
                          $content = $this->file_get_contents_curl("http://web-nucleus.com/ImageResize.php?url={$url}&width=160&height=160");
                          $new_photo_user = $_SERVER['DOCUMENT_ROOT']."/upload/{$this->id}/photo/photo-profile.jpg";
                          file_put_contents($new_photo_user, $content);

                          //icon user
                          $url = $dir.$file_name_md;
                          $content = $this->file_get_contents_curl("http://web-nucleus.com/ImageResize.php?url={$url}&width=29&height=29");
                          $new_photo_user = $_SERVER['DOCUMENT_ROOT']."/upload/{$this->id}/photo/icon-profile.jpg";
                          file_put_contents($new_photo_user, $content);
                      } else {
                          //upload image in dir album
                          $uid = $this->id;
                          $src_image = "/upload/".$this->id."/album/".$file_name_md;
                          $time = time();

                          $query = "INSERT INTO `album` (`uid`, `src`, `time_`, `upload`) VALUES ($uid, \"{$src_image}\", $time, 1)";
                          $result = $db->query($query);

                          //select id image. Add id in session.
                          //$query_session = "SELECT id FROM album WHERE src = \"{$src_image}\"";
                          //$result_query_session = $db->query($query_session);
                          //$fetch_id_ = $db->fetch($result_query_session);

                          //add
                          $_SESSION['image_src_preview'] = $src_image;

                          //$db->free($result);
                      }

                  } else echo 1;
              } else echo 2;
           } else echo 3;
        }

        public function file_get_contents_curl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
   }
