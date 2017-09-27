<?php
    namespace Nucleus;

    class Album
    {
          var $id;
          var $session_src_image;
          var $error;
          private $db_;
          private $tpl;

          public function __construct() {
               $this->id = $_SESSION['id'];
               $this->tpl = new TPL();
               $this->db_ = DB::getInstance();
          }

          public function getImagePreviewID() {
               return $this->getImagePreviewSrc($_SESSION['image_src_preview']);
          }

          private function getImagePreviewSrc($src) {
              $src   = $_SERVER['DOCUMENT_ROOT'].$src;
              $arr[] = explode("/", $src);
              $cnt_arr = count($arr[0]);
              $cnt = $cnt_arr - 1;
              list($name_image_, ) = explode(".", $arr[0][$cnt]);
              $new_name_image_album = $name_image_ . "-album";

	      $size = getimagesize($src);
              $imageWidth = $size[0];
              $imageHeight = $size[1];
              if ($imageWidth > $imageHeight) {
                $newImageWidth = 645;
                $newIMageHeight = 400;
              } else if ($imageWidth < $imageHeight) {
                $newImageWidth = 645;
                $newIMageHeight = 862;
              } else {
                $newImageWidth = 645;
                $newIMageHeight = 645;
              }

              $content = file_get_contents("http://web-nucleus.com/ImageResize.php?url={$src}&width={$newImageWidth}&height={$newIMageHeight}");
              $new_photo_album = $_SERVER['DOCUMENT_ROOT']."/upload/{$this->id}/album/".$new_name_image_album.".jpg";
              file_put_contents($new_photo_album, $content);

              $new_src = "/upload/{$this->id}/album/".$new_name_image_album.".jpg";

              return $new_src;
          }

          public function updateInfo(array $arr) {
              $this->session_src_image = $_SESSION['image_src_preview'];

              list($title, $text, $category) = $arr;

              $title = $this->db_->escapeString($title);
              $text  = $this->db_->escapeString($text);
              $category = (int) $category;

              $query_update_info = "UPDATE album SET title = \"{$title}\", descr = \"{$text}\", category = {$category}, upload = 0 WHERE src = \"{$this->session_src_image}\"";
              $result_update = $this->db_->query($query_update_info);

              if ($result_update)
                  die("1");
              else
                  $this->setError($result_update);

              exit();
          }

          public function loadAlbum($category) {
              $category = (int) $category;

              //load main template
              $this->tpl->file("album.TPL");

              $select_photo_query = "SELECT * FROM album WHERE category = $category AND del != 1 ORDER BY id DESC";
              $result_select_photo = $this->db_->query($select_photo_query);
              $numRows = $this->db_->numRows($result_select_photo);

              if ($numRows == 0) {
                  $this->tpl->template("not_album_photo.TPL");
                  $this->tpl->complete("album-photo-OR-not-photo-in-album");
              } else {
                  while ($row = $this->db_->fetch($result_select_photo)) {
                      //parse src image
                      $src_image_album = $row['src'];
                      $len = strlen($src_image_album) - 4;
                      $new_src_ = substr($src_image_album, 0, $len);
                      $src = $new_src_ . "-album.jpg";

                      //date and time
                      $date  = date("d.m.Y", $row['time_']);
                      $time  = date("H:m", $row['time_']);

                      //info user photo
                      $query_info_user = "SELECT first_name, last_name FROM users WHERE id = {$row['uid']}";
                      $result_query_info = $this->db_->query($query_info_user);
                      $fetch_result_info = $this->db_->fetch($result_query_info);
                      $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                      $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";

                      //button edit photo
                      if ($this->id == $row['uid']) {
                         $none_report = "none";
                         $none_delete = "";
                         $onclick = "edit.deletePhoto()";
                         $onclick1 = "";
                      } else {
                         $none_report = "";
                         $none_delete = "none";
                         $onclick1 = "report.show({$row['id']}, 'photo')";
                         $onclick = "";
                      }

                      //parse info
                      $this->tpl->template("album_photo.TPL");

                      $this->tpl->parse_tpl("{id}", $row['id'], true);
                      $this->tpl->parse_tpl("{uid}", $row['uid'], true);
                      $this->tpl->parse_tpl("{button}", $button, true);
                      $this->tpl->parse_tpl("{src}", $src, true);
                      $this->tpl->parse_tpl("{descr}", $row['descr'], true);
                      $this->tpl->parse_tpl("{title}", $row['title'], true);
                      $this->tpl->parse_tpl("{date}", $date, true);
                      $this->tpl->parse_tpl("{time}", $time, true);
                      $this->tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                      $this->tpl->parse_tpl("{none_report}", $none_report, true);
                      $this->tpl->parse_tpl("{none_delete}", $none_delete, true);
                      $this->tpl->parse_tpl("{onclick}", $onclick, true);
                      $this->tpl->parse_tpl("{onclick1}", $onclick1, true);

                      $this->tpl->parse_tpl("{name}", $name_user, true);
                      $this->tpl->parse_tpl("{url}", $url, true);

                      $this->tpl->complete("album-photo-OR-not-photo-in-album");

                      //free query
                      $this->db_->free($result_query_info);
                  }
                  $this->tpl->parse_tpl("{album-photo-OR-not-photo-in-album}", "");
              }

              $this->db_->free($result_select_photo);

              $this->tpl->print_file();
          }

          public function deletePhoto($pid) {
              $query_select_id = "SELECT uid FROM album WHERE id = $pid";
              $result_query = $this->db_->query($query_select_id);
              $fetch_result = $this->db_->fetch($result_query);

              if ($this->id == $fetch_result['uid']) {
                 $delete_query = "UPDATE album SET del = 1 WHERE id = $pid";
                 $result_delete = $this->db_->query($delete_query);

                 if ($result_delete) die(0);
                 else die(1);

              } else die(1);

              $this->db_->free($result_query);
          }

          private function setError($descrError) {
              $this->error = $desrcError;
              $this->getError();
          }

          private function getError() {
              die($this->error);
          }
    }
