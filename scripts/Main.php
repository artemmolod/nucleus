<?php
   namespace Nucleus;

   //main
   //use Nucleus\Profile;
   //use Nucleus\lenta;
   //use Nucleus\Settings;
   //use Nucleus\Friends;

   //modules
   //use Nucleus\Album;
   //use Nucleus\Like;
   //use Nucleus\Report;
   //use Nucleus\King;
   //use Nucleus\Comment;

   class Main
   {
       /**
       *@var id - ID user
       */
       public $id;

       /**
       *@var king;
       */
       public $king;

       /**
       * @var rating
       */
       public $rating_;

       /**
       *@var auth - Authorization user
       */
       private $auth = false;

       /**
       *@var tpl - template parse
       */
       public $tpl;

       /**
       *@var VERSION - const
       */
       const VERSION = "1.0";

       /**
       * room start
       * @var room_start
       */
       private $room_start = 0;

       /**
       *init for app
       */
       public function __construct() {
          $tpl = new TPL();
          $db  = DB::getInstance();
          //language site
          $lang_session = !empty($_GET['lang']) ? $_SESSION['lang'] = $_GET['lang'] : isset($_SESSION['lang']) ? $_SESSION['lang'] : "ru";
          $lang_dir = $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $lang_session . ".ini";
          $lang_parse = parse_ini_file($lang_dir);

          //tpl
          $tpl->file("main.TPL");

          $tpl->parse_tpl("%logo_title%", $lang_parse['logo_title']);
          $tpl->parse_tpl("%logo_question%", $lang_parse['logo_question']);
          $tpl->parse_tpl("%logo_answer%", $lang_parse['logo_answer']);
          $tpl->parse_tpl("%logo_answer_c%", $lang_parse['logo_answer_c']);
          $tpl->parse_tpl("%login_info%", $lang_parse['login_info']);
          $tpl->parse_tpl("%log_in%", $lang_parse['log_in']);
          $tpl->parse_tpl("%sign_up%", $lang_parse['sign_up']);
          $tpl->parse_tpl("%email%", $lang_parse['email']);
          $tpl->parse_tpl("%password%", $lang_parse['password']);
          $tpl->parse_tpl("%about%", $lang_parse['about']);
          $tpl->parse_tpl("%terms%", $lang_parse['terms']);
          $tpl->parse_tpl("%developers%", $lang_parse['developers']);

          $tpl->parse_tpl("{version}", VERSION);

          //Authorization
          $this->auth = (new Authorization)->getAuth();
          $this->id = $_SESSION['id'];

          if ($this->auth !== false) {
             $tpl->parse_block("[no-reg]", "[/no-reg]");
             $tpl->parse_tpl("[reg]", "");
             $tpl->parse_tpl("[/reg]", "");

             $query = "SELECT first_name, last_name, email, king, room_start, premiumAccountDays, rating FROM users WHERE id = $this->id";
             $result = $db->query($query);
             $fetch = $db->fetch($result);

             if ($fetch['first_name'] == "" AND $fetch['last_name'] == "") {
                header("Location: /registration_info");
                exit();
             }

             $this->room_start = $fetch['room_start'];

             $user_name_js = $fetch['first_name'] . " " . $fetch['last_name'];
             $tpl->parse_tpl("{user.name.js}", $user_name_js);
             $tpl->parse_tpl("{id}", $this->id);

             $this->king = $fetch['king'];
             $this->premiumAccountDays = $fetch['premiumAccountDays'];
             $this->rating_ = $fetch['rating'];


             $icon_profile = "/upload/".$this->id."/photo/icon-profile.jpg";
             if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_profile)) {
               $icon_profile = "/tpl/img/no-photo-profile.png";
             }
             $tpl->parse_tpl("{id}", $this->id);
             $tpl->parse_tpl("{icon-profile}", $icon_profile);

             $db->free($result);
          } else {
             $tpl->parse_block("[reg]", "[/reg]");
             $tpl->parse_tpl("[no-reg]", "");
             $tpl->parse_tpl("[/no-reg]", "");
             $tpl->parse_tpl("{id}", 0);
          }

          //competition status (start or end)
          $competition = new Competition();
          //$competition->competitionStart();
          $competitionStatus = $competition->getCompetitionStatus();
          if ($competitionStatus != -1) {
            $nowTime = time();
            $dateTimeEnd = $competitionStatus['dateEnd'];
            if ($nowTime >= $dateTimeEnd) {
              //end competition
              $competition->competitionEnd();

              //select winners
              $users_winner = $competition->getCompetitionWinner();
              $count_winner = count($users_winner);

              $test_one_id = (int) $users_winner[0]['uid'];
              $test_two_id = (int) $users_winner[1]['uid'];
              $test_thr_id = (int) $users_winner[2]['uid'];

              if ($count_winner == 1 AND $test_one_id != 0) {
                $winner_id = (int) $users_winner[0]['uid'];
                $query = "UPDATE users SET rating = rating + 1000, king = 1, king_cnt = king_cnt + 1 WHERE id = $winner_id";
                $db->query($query);

                //select email winner user
                $select_email_winner_user = "SELECT email FROM users WHERE id = $winner_id AND email_ver = 1";
                $result_select_email_winner_user = $db->query($select_email_winner_user);
                $fetch_result_email_ = $db->fetch($result_select_email_winner_user);
                $email = $fetch_result_email_['email'];

                //send notify on email address
                $mail = new Mail($email, 4);

                $notify = new Notification();
                $notify->create(4, $winner_id);

                //free db and end select email winner user
                $db->free($result_select_email_winner_user);
              } else if ($count_winner == 2 AND $test_one_id != 0 AND $test_two_id != 0) {
                $winner_id = (int) $users_winner[0]['uid'];
                $query = "UPDATE users SET rating = rating + 1000, king = 1, king_cnt = king_cnt + 1 WHERE id = $winner_id";
                $db->query($query);

                //select email winner user
                $select_email_winner_user = "SELECT email FROM users WHERE id = $winner_id AND email_ver = 1";
                $result_select_email_winner_user = $db->query($select_email_winner_user);
                $fetch_result_email_ = $db->fetch($result_select_email_winner_user);
                $email = $fetch_result_email_['email'];

                //send notify on email address
                $mail = new Mail($email, 4);

                $notify = new Notification();
                $notify->create(4, $winner_id);

                //free db and end select email winner user
                $db->free($result_select_email_winner_user);
                //

                $winner_id_two = (int) $users_winner[1]['uid'];
                $query = "UPDATE users SET rating = rating + 500 WHERE id = $winner_id_two";
                $db->query($query);

                $notify = new Notification();
                $notify->create(5, $winner_id_two);
              } else if ($count_winner == 3 AND $test_one_id != 0 AND $test_two_id != 0 AND $test_thr_id != 0) {
                $winner_id = (int) $users_winner[0]['uid'];
                $query = "UPDATE users SET rating = rating + 1000, king = 1, king_cnt = king_cnt + 1 WHERE id = $winner_id";
                $db->query($query);

                //select email winner user
                $select_email_winner_user = "SELECT email FROM users WHERE id = $winner_id AND email_ver = 1";
                $result_select_email_winner_user = $db->query($select_email_winner_user);
                $fetch_result_email_ = $db->fetch($result_select_email_winner_user);
                $email = $fetch_result_email_['email'];

                //send notify on email address
                $mail = new Mail($email, 4);

                $notify = new Notification();
                $notify->create(4, $winner_id);

                //free db and end select email winner user
                $db->free($result_select_email_winner_user);
                //

                $winner_id_two = (int) $users_winner[1]['uid'];
                $query = "UPDATE users SET rating = rating + 500 WHERE id = $winner_id_two";
                $db->query($query);

                $notify = new Notification();
                $notify->create(5, $winner_id_two);

                $winner_id_three = (int) $users_winner[2]['uid'];
                $query = "UPDATE users SET rating = rating + 250 WHERE id = $winner_id_three";
                $db->query($query);

                $notify = new Notification();
                $notify->create(6, $winner_id_three);
              }

              //notify for start&end competition
              //...

              //start new competition
              $competition->competitionStart();
            }
          }
          //end competition

          //settings switch (act)
          $act = $_GET['act'];

          switch ($act) {
            case "profile":
                if (!$this->id) header("Location: /");

                $uid = $_GET['uid'];
                $prof = new Profile($uid);

                //data
                $name               = $prof->getName();
                $sex                = $prof->getSex();
                $profile_king       = $prof->getKing();
                $user_              = $prof->getUser();
                $bdate              = $prof->getBdate();
                $rating             = $prof->getRating();
                $photo              = $prof->getSrcPhoto();
                $cover              = $prof->getSrcPhoto();
                $king_cnt           = $prof->getCountKing();
                $cnt_photo          = $prof->getCountPhoto();
                $user_ver           = $prof->getUserVerified();
                $cnt_friends        = $prof->getCountFriends();
                $popular_photo      = $prof->getPopularPhoto();
                $del_user           = $prof->getDeletedUser();
                $blocking_user      = $prof->getBlockingUser();
                $off_user           = $prof->getOffUser();
                $cnt_subscription   = $prof->getCountSubscription();
                $premiumAccountDays = $prof->getPremiumAccountDays();

                //blocking or deleted user
                if ($blocking_user == 1) {
                  $tpl->template("blockingUser.TPL");
                  $tpl->complete("content");
                  break;
                }
                if ($del_user == 1) {
                  $tpl->template("deletedUser.TPL");
                  $tpl->complete("content");
                  break;
                }
                if ($off_user == 1) {
                  $tpl->template("offUser.TPL");
                  $tpl->complete("content");
                  break;
                }

                //profile admin && support
                if ($uid == 14) {
                  $tpl->template("profile-a.TPL");
                  $tpl->parse_tpl("{block-user}", "", true);
                  $tpl->parse_tpl("{name}", $name, true);
                  $tpl->parse_tpl("{photo_src}", $photo, true);
                  $tpl->parse_tpl("{uid}", $uid, true);
                  if ($user_ver == 0) {
                    $tpl->parse_tpl("{user-ver}", "", true);
                    $tpl->parse_tpl("{img_cover}", "", true);
                  } else {
                    $tpl->parse_tpl("{user-ver}", "<span class=\"profile-verified\"></span>", true);
                    if ($uid == 4) {
                      $photo_src_cover = "/tpl/img/back-about.png";
                    } else {
                      $photo_src_cover = $cover;
                    }
                    $img = "<img width=705 class=\"blur profile-cover-img\" src=\"$photo_src_cover\" style=\"opacity: 0;\">";
                    $tpl->parse_tpl("{img_cover}", $img, true);
                  }

                  $tpl->complete("content");

                  //
                  if ($uid == 14) {
                    $tpl->template("profile-support.TPL");
                    $tpl->complete("profile-content");
                  }

                  break;
                }

                //block user
                $block_user_query = "SELECT * FROM block_user WHERE uid = $uid AND bid = $this->id";
                $block_user_result = $db->query($block_user_query);
                $block_numRows = $db->numRows($block_user_result);
                if ($block_numRows != 0) {
                    $tpl->template("blocking_user.TPL");
                    $tpl->complete("content");
                } else {
                    //parse data in template
                    $tpl->template("profile.TPL");

                    $tpl->parse_tpl("{name}", $name, true);
                    $tpl->parse_tpl("{photo_src}", $photo, true);
                    $tpl->parse_tpl("{uid}", $uid, true);

                    $tpl->parse_tpl("{cnt_photo}", $cnt_photo, true);
                    $tpl->parse_tpl("{friends}", $cnt_friends, true);
                    $tpl->parse_tpl("{subscription}", $cnt_subscription, true);
                    $tpl->parse_tpl("{king_cnt}", $king_cnt, true);
                    $tpl->parse_tpl("{rating}", $rating, true);

                    if ($cover == "") {
                      $tpl->parse_tpl("{img_cover}", "", true);
                    }

                    if ($user_ver == 0) {
                      $tpl->parse_tpl("{user-ver}", "", true);
                      $tpl->parse_tpl("{img_cover}", "", true);
                    } else {
                      $tpl->parse_tpl("{user-ver}", "<span class=\"profile-verified\"></span>", true);
                      if ($uid == 4) {
                        $photo_src_cover = "/tpl/img/back-about.png";
                      } else {
                        $photo_src_cover = $cover;
                      }
                      $img = "<img width=705 class=\"blur profile-cover-img\" src=\"$photo_src_cover\" style=\"opacity: 0;\">";
                      $tpl->parse_tpl("{img_cover}", $img, true);
                    }

                    //user king status
                    if ($profile_king == 0) {
                      $tpl->parse_tpl("{king_status}", "", true);
                    } else {
                      $king_tpl_status = "<span class=\"king-profile-status\" title=\"Данная отметка означает, что пользователь получил статус короля\"></span>";
                      $tpl->parse_tpl("{king_status}", $king_tpl_status, true);
                    }

                    /**
                    * premium account
                    */
                    if ($premiumAccountDays > 0) {
                      $icon_premium_account = "<span class=\"icon-premium-account\" title=\"Premium Account for {$premiumAccountDays} days\"></span>";
                      $tpl->parse_tpl("{premium_account}", $icon_premium_account, true);
                    } else {
                      $tpl->parse_tpl("{premium_account}", "", true);
                    }

                    ///user info
                    $tpl->parse_tpl("{sex}", $sex, true);
                    $tpl->parse_tpl("{bdate}", $bdate, true);

                    $tpl->complete("content");

                    //Popular photo
                    if ($cnt_photo == 0) {
                      $tpl->template("popular_photo/no.TPL");
                      $tpl->complete("profile-photo-content");
                    } else {
                      while ($row = $db->fetch($popular_photo)) {
                        $tpl->template("popular_photo/list.TPL");
                        $tpl->parse_tpl("{url}", $row['src'], true);
                        $tpl->parse_tpl("{image_id}", $row['id'], true);
                        $tpl->complete("profile-photo-content");
                      }
                      $tpl->parse_tpl("{profile-photo-content}", "");
                    }

                    // $user_
                    if ($user_) {
                        $tpl->template("profile_btn.TPL");
                        $tpl->complete("profile_btn");
                        $tpl->parse_tpl("{block-user}", "");
                    } else {
                        $query_friends = "SELECT * FROM friends WHERE fid = $this->id AND uid = $uid";
                        $result_friends = $db->query($query_friends);
                        $numRows = $db->numRows($result_friends);

                        //not found user
                        $foundUser = $prof->getFoundUser();
                        if ($foundUser) {
                           $tpl->parse_tpl("{profile_btn}", "");
                           $tpl->parse_tpl("{block-user}", "");
                           break;
                        }

                        //blocking user
                        $block_user_query = "SELECT * FROM block_user WHERE uid = $this->id AND bid = $uid";
                        $block_user_result = $db->query($block_user_query);
                        $block_numRows = $db->numRows($block_user_result);

                        if ($block_numRows == 0) {
                             $tpl->template("profile_btn_no.TPL");
                             $tpl->parse_tpl("{uid}", $uid, true);

                             if ($numRows == 0) {
                                 $tpl->parse_tpl("{onclick}", "friends.new({$uid}, this.id)", true);
                                 $tpl->parse_tpl("{none}", "", true);
                                 $tpl->parse_tpl("{none2}", "none", true);
                                 $tpl->parse_tpl("{onclick2}", "", true);
                                 $tpl->parse_tpl("{btn_friends}", "btn_friends", true);
                                 $tpl->parse_tpl("{btn_friends2}", "", true);

                                 $tpl->parse_tpl("{onclick3}", "", true);
                                 $tpl->parse_tpl("{none3}", "none", true);
                                 $tpl->parse_tpl("{btn_friends3}", "", true);
                             } else {
                                 $tpl->parse_tpl("{onclick2}", "friends.del({$uid}, this.id)", true);
                                 $tpl->parse_tpl("{none}", "none", true);
                                 $tpl->parse_tpl("{none2}", "", true);
                                 $tpl->parse_tpl("{onclick}", "", true);
                                 $tpl->parse_tpl("{btn_friends2}", "btn_friends", true);
                                 $tpl->parse_tpl("{btn_friends}", "", true);

                                 $tpl->parse_tpl("{onclick3}", "", true);
                                 $tpl->parse_tpl("{none3}", "none", true);
                                 $tpl->parse_tpl("{btn_friends3}", "", true);
                             }

                             $tpl->complete("profile_btn");
                             $tpl->parse_tpl("{block-user}", "");
                        } else {
                            $tpl->template("block_user.TPL");
                            $tpl->complete("block-user");

                            $tpl->template("profile_btn_no.TPL");
                            $tpl->parse_tpl("{uid}", $uid, true);

                            $tpl->parse_tpl("{onclick}", "", true);
                            $tpl->parse_tpl("{none}", "none", true);
                            $tpl->parse_tpl("{btn_friends}", "", true);
                            $tpl->parse_tpl("{onclick2}", "", true);
                            $tpl->parse_tpl("{none2}", "none", true);
                            $tpl->parse_tpl("{btn_friends2}", "", true);

                            $tpl->parse_tpl("{onclick3}", "subscription.release({$uid})", true);
                            $tpl->parse_tpl("{none3}", "", true);
                            $tpl->parse_tpl("{btn_friends3}", "release_btn", true);

                            $tpl->complete("profile_btn");
                        }

                        $db->free($result_friends);
                    }
                    //promotion profile
                    $nawDate = time();
                    $selectPromotionProfile = "SELECT * FROM promotionPictures WHERE user_id = $uid AND
                                              (date_ <= $nawDate AND endDate >= $nawDate) AND del = 0 ORDER BY date_ LIMIT 5";
                    $resultPromotionProfile = $db->query($selectPromotionProfile);
                    if ($db->numRows($resultPromotionProfile) == 0) {
                      $tpl->parse_tpl("{profile-promotion}", "");
                    } else {
                      $tpl->template("profile-promotion-content.TPL");
                      $tpl->complete("profile-promotion");
                      while ($row = $db->fetch($resultPromotionProfile)) {
                        //select info
                        $selectInfoPhoto = "SELECT * FROM album WHERE id = {$row['post_id']}";
                        $resultInfoPhoto = $db->query($selectInfoPhoto);
                        $fetchInfo = $db->fetch($resultInfoPhoto);

                        $pathPhoto = $fetchInfo['src'];
                        $uid = $fetchInfo['uid'];
                        $endDate = date("d.m.Y H:m", $row['endDate']);
                        $date = date("d.m.Y H:m", $fetchInfo['time_']);
                        $db->free($resultInfoPhoto);

                        $selectNameUser = "SELECT first_name, last_name FROM users WHERE id = $uid";
                        $resultNameUser = $db->query($selectNameUser);
                        $fetchName = $db->fetch($resultNameUser);
                        $userName = $fetchName['first_name'] . " " . $fetchName['last_name'];
                        $db->free($resultNameUser);

                        //parse info
                        $tpl->template("profile-promotion.TPL");
                        $tpl->parse_tpl("{pathImage}", $pathPhoto, true);
                        $tpl->parse_tpl("{pid}", $row['post_id'], true);
                        $tpl->parse_tpl("{uid}", $uid, true);
                        $tpl->parse_tpl("{cntDays}", $row['cntDays'], true);
                        $tpl->parse_tpl("{date}", $date, true);
                        $tpl->parse_tpl("{name}", $userName, true);
                        $tpl->complete("profile-promotion-list");
                      }
                      $tpl->parse_tpl("{profile-promotion-list}", "");
                    }
                }
                break;

            case "access":
                $pass = $_POST['password'];
                $type = $_GET["type"];

                if (isset($type)) $_SESSION['type'] = $type;

                if (!empty($pass)) {
                  $new_pass = (new Authorization())->passD($pass);
                  $query = "SELECT password FROM users WHERE id = $this->id";
                  $result = $db->query($query);
                  $fetch_pass = $db->fetch($result);

                  if ($fetch_pass['password'] == $new_pass)  {
                     $s_type = (int) $_SESSION['type'];
                     $_SESSION['key'] = 0;

                     switch ($s_type) {
                       case 0:
                          if ($_SESSION['key'] != 0) return;

                          $off_query = "UPDATE users SET off = 1 WHERE id = $this->id";
                          $result_off = $db->query($off_query);

                          if ($result_off) die("0");
                          break;
                       case 3:
                          if ($_SESSION['key'] != 0) return;

                          $tpl->file("access/password.TPL");
                          $tpl->print_file();
                          break;
                     }
                  } else die("1");

                  $db->free($result);
                  exit();
                }

                //update email (tpl)
                if (isset($_GET['emailUpdate']) && $_GET['emailUpdate'] == "true") {
                    $tpl->file("access/email.TPL");
                    $tpl->print_file();
                    $tpl->clear();
                    return;
                }

                //update name (tpl)
                if (isset($_GET['nameUpdate']) && $_GET['nameUpdate'] == "true") {
                    $tpl->file("access/name.TPL");
                    $tpl->print_file();
                    $tpl->clear();
                    return;
                }

                $tpl->file("access/main.TPL");
                $tpl->print_file();
                exit();
                break;

            case "updateName":
                $f_name = (string) $db->escapeString($_GET['fname']);
                $l_name = (string) $db->escapeString($_GET['lname']);

                if (strlen($f_name) == 0 || strlen($f_name) == 1) return;
                if (strlen($l_name) == 0 || strlen($l_name) == 1) return;

                //update name
                $update_name_query = "UPDATE users SET first_name = '" . $f_name . "', last_name = '" . $l_name . "' WHERE id = $this->id";
                $result_update_name = $db->query($update_name_query);

                if ($result_update_name) die("0");
                else die("1");

                exit();
                break;

            case "updateEmail":
                $new_email = (string) $db->escapeString($_GET['new_email']);
                if (strlen($new_email) == 0) return;

                //SELECT EMAIL FOR users
                $select_all_email = "SELECT email FROM users WHERE email = '" . $new_email . "'";
                $result_select_email = $db->query($select_all_email);
                $numRows_email = $db->numRows($result_select_email);

                if ($numRows_email != 0) {
                   die("2");
                   exit();
                }
                $db->free($result_select_email);

                //update email for user
                $update_query_email = "UPDATE users SET email = '" . $new_email . "', email_ver = 0 WHERE id = $this->id";
                $result_up_email = $db->query($update_query_email);

                if (!$result_up_email) die("1");

                /**
                * Send notification on email
                * ...
                */
                $mail = new Mail($new_email, 0);

                die("0");
                exit();
                break;

            case "updatePassword":
                if (!isset($_SESSION['key'])) return;

                $new_pass = $db->escapeString($_POST['password']);
                $hash_pass = (new Authorization())->passD($new_pass);

                $update_pass_query = "UPDATE users SET password = '" . $hash_pass . "' WHERE id = $this->id";
                $result_query = $db->query($update_pass_query);

                if (!$result_query) die("1");

                /**
                * Send notification on email
                * ...
                */

                $mail = new Mail($new_email, 2);

                die("0");
                exit();
                break;

            case "settings":
                if (!$this->id) header("Location: /");

                $name = $fetch["first_name"] . " " . $fetch['last_name'];
                $email = $fetch["email"];
                $domen_email = explode("@", $email);
                $first_ch = substr($domen_email[0], 0, 1);
                $new_email = $first_ch . "***@" . $domen_email[1];

                $tpl->template("settings/main.TPL");
                $tpl->parse_tpl("{name}", $name, true);
                $tpl->parse_tpl("{email}", $new_email, true);
                $tpl->complete("content");

                if ($this->premiumAccountDays > 0) {
                  $tpl->template("settings/premium.TPL");
                  $tpl->complete("premium-content");
                } else {
                  $tpl->parse_tpl("{premium-content}", "");
                }
                break;

            case "album":
                if (!$this->id) header("Location: /");

                $p = $_GET['p'];
                $album = new Album();

                if ($p == "previewImageID") die($album->getImagePreviewID());
                else if ($p == "updateInfo") die($album->updateInfo([
                                                $_GET['title'],
                                                $_GET["text"],
                                                $_GET['category']
                                             ]));
                else if ($p == "loadAlbum") $album->loadAlbum($_GET['category']);
                else if ($p == "deletePhoto") $album->deletePhoto($_GET['id']);
                else die("Error. Parameter not found.");

                exit();
                break;

            case "roomCategory":
                $tpl->template("room/main-category.TPL");
                $tpl->complete("content");
                break;

            case "roomStart":
                die($this->room_start);
                exit();
                break;

            case "roomStart_":
                $tpl->template("room/main-msg-start.TPL");
                $tpl->complete("content");
                break;

            case "roomLessonEnd":
                $query = "UPDATE users SET room_start = 1, rating = rating + 5 WHERE id = $this->id";
                $result = $db->query($query);
                if ($result) die("0");
                else die("1");
                exit();
                break;

            case "bonus":
                $tpl->template("store/bonus.TPL");
                $tpl->complete("content");
                break;

            case "promocode":
                $code = $_GET['code'];
                if (empty($code)) die("1");

                $promocode_ = new Promocode();
                $issetCode = $promocode_->getPromocode($code);
                if ($issetCode == 1) {
                  die("1");
                } else if ($issetCode == 2) {
                  die("2");
                } else {
                  die("0");
                }
                exit();
                break;

            case "lenta":
                if (!$this->id) header("Location: /");

                $lenta = new Lenta();
                $count = !empty($_GET['cnt']) ? $_GET['cnt'] : 10;

                //load lenta
                if (!$lenta->getLentaNumRows()) {
                    $tpl->template("no_lenta.TPL");
                    $tpl->complete("content");
                } else  {
                    //select id friends
                    $query_friends_all = "SELECT * FROM friends WHERE fid = $this->id AND friends = 1";
                    $result_query_friends_all = $db->query($query_friends_all);

                    if ($db->numRows($result_query_friends_all) == 0) {
                      $tpl->template("lenta/no.TPL");
                      $tpl->complete("content");
                      break;
                    }

                    $tpl->template("lenta/main.TPL");
                    $tpl->complete("content");

                    $time_ = 0;

                    while ($rows = $db->fetch($result_query_friends_all)) {
                      $friends_id = (int) $rows['uid'];
                      $query_popular_photo = "SELECT * FROM album WHERE uid = $friends_id AND upload != 1 AND del != 1 ORDER BY time_ DESC LIMIT 4";
                      $result_query_popular = $db->query($query_popular_photo);

                      //promotion
                      $nawDate = time();
                      $selectPromotionUsers = "SELECT * FROM promotionPictures WHERE user_id = $friends_id AND (date_ <= $nawDate AND endDate >= $nawDate) AND del = 0 ORDER BY date_ LIMIT 6";
                      $resultPromotionUsers = $db->query($selectPromotionUsers);
                      if ($db->numRows($resultPromotionUsers) != 0) {
                        //select info post
                        $fetchPromotion = $db->fetch($resultPromotionUsers);
                        $post_id = $fetchPromotion['post_id'];
                        $authorPromotion = $fetchPromotion['user_id'];
                        $db->free($resultPromotionUsers);

                        $selectPromotionInfo = "SELECT * FROM album WHERE id = $post_id";
                        $resultPromotionInfo = $db->query($selectPromotionInfo);
                        $fetchInfo = $db->fetch($resultPromotionInfo);
                        $pathPhoto = $fetchInfo['src'];
                        $db->free($resultPromotionInfo);

                        //photo user promotion
                        $photoAuthor = "/upload/" . $authorPromotion . "/photo/icon-profile.jpg";
                        $dirPhoto = $_SERVER['DOCUMENT_ROOT'] . $photoAuthor;
                        if (!file_exists($dirPhoto)) $photoAuthor = "/tpl/img/no-photo-profile.png";

                        //parse info
                        $tpl->template("lenta/lenta-promotion.TPL");
                        $tpl->parse_tpl("{pathPhoto}", $pathPhoto, true);
                        $tpl->parse_tpl("{pid}", $post_id, true);
                        $tpl->parse_tpl("{photoAuthor}", $photoAuthor, true);
                        $tpl->parse_tpl("{uid}", $authorPromotion, true);
                        $tpl->complete("promotion-lenta");
                      }

                      //select info
                      $selectInfoUser = "SELECT first_name, last_name FROM users WHERE id = {$rows['uid']}";
                      $resultInfoUser = $db->query($selectInfoUser);
                      $fetchInfo = $db->fetch($resultInfoUser);
                      $friendsName = $fetchInfo['first_name'] . " " . $fetchInfo['last_name'];
                      $friendsPhoto = "/upload/" . $friends_id . "/photo/photo-profile.jpg";
                      $db->free($resultInfoUser);

                      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $friendsPhoto)) {
                        $friendsPhoto = "/tpl/img/no-photo-profile.png";
                      }

                      $tpl->template("lenta/list-user.TPL");
                      $tpl->parse_tpl("{photo-user}", $friendsPhoto, true);
                      $tpl->parse_tpl("{name-user}", $friendsName, true);
                      $tpl->parse_tpl("{uid}", $friends_id, true);

                      if ($db->numRows($result_query_popular) == 0) {
                        $lastDateUpload = "";
                        $tplPath = $_SERVER['DOCUMENT_ROOT'] . "/tpl/lenta/list-user-no.TPL";
                        $no_content_photo = file_get_contents($tplPath);
                        $tpl->parse_tpl("{photo-user-list}", $no_content_photo, true);
                      } else {
                        $tpl->complete("lenta-container");
                        while ($info = $db->fetch($result_query_popular)) {
                          if ($info['time_'] > $time_) $time_ = $info['time_'];
                          $tpl->template("lenta/list-user-photo.TPL");
                          $tpl->parse_tpl("{photo-path}", $info['src'], true);
                          $tpl->parse_tpl("{pid}", $info['id'], true);
                          $tpl->complete("photo-user-list");
                        }
                        $tpl->parse_tpl("{photo-user-list}", "");

                        //last date upload photo
                        $yearLastUpload = date("Y", $time_);
                        if ($yearLastUpload == date("Y")) {
                          $lastDateUpload = date("d.m H:m", $time_);
                        } else {
                          $lastDateUpload = date("d.m.Y H:m", $time_);
                        }
                      }
                      $tpl->parse_tpl("{last-date-upload-photo}", $lastDateUpload);
                    }
                    $tpl->parse_tpl("{promotion-lenta}", "");

                    /*
                    while ($rows = $db->fetch($result_query_friends_all)) {
                      $friends_id = (int) $rows['uid'];
                      $query_popular_photo = "SELECT * FROM album WHERE uid = $friends_id AND upload != 1 AND del != 1 ORDER BY rating, time_ DESC LIMIT 10";
                      $result_query_popular = $db->query($query_popular_photo);

                      if ($db->numRows($result_query_popular) == 0) {
                         $tpl->template("lenta/no.TPL");
                         $tpl->complete("content");
                         break;
                      }

                      //load news
                      $tpl->template("lenta/main.TPL");
                      $tpl->complete("content");

                      $cnt = 0;
                      while ($row = $db->fetch($result_query_popular)) {
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
                        $result_query_info = $db->query($query_info_user);
                        $fetch_result_info = $db->fetch($result_query_info);
                        $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                        $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
                          $url = "/tpl/img/no-photo-profile.png";
                        }
                        $db->free($result_query_info);

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

                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                          $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);
                          $imageWidth = $size[0];
                          $imageHeight = $size[1];
                          if ($imageWidth > $imageHeight) {
                            $newImageWidth = 645;
                            $newIMageHeight = 400;
                            $class = "mobile-photo-album";
                          } else if ($imageWidth < $imageHeight) {
                            $newImageWidth = 645;
                            $newIMageHeight = 862;
                            $class = "mobile-photo-portrait";
                          } else {
                            $newImageWidth = 645;
                            $newIMageHeight = 645;
                            $class = "mobile-photo-album";
                          }
                        } else {
                          $src = "/tpl/img/no-image.png";
                          $newImageWidth = 645;
                          $newIMageHeight = 400;
                          $class = "mobile-photo-album";
                        }

                        //load template
                        $tpl->template("lenta/list.TPL");

                        $tpl->parse_tpl("{id}", $row['id'], true);
                        $tpl->parse_tpl("{uid}", $row['uid'], true);
                        $tpl->parse_tpl("{src}", $src, true);
                        $tpl->parse_tpl("{button}", $button, true);
                        $tpl->parse_tpl("{descr}", $row['descr'], true);
                        $tpl->parse_tpl("{title}", $row['title'], true);
                        $tpl->parse_tpl("{date}", $date, true);
                        $tpl->parse_tpl("{time}", $time, true);
                        $tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                        $tpl->parse_tpl("{imageWidth}", $newImageWidth, true);
                        $tpl->parse_tpl("{imageHeight}", $newIMageHeight, true);
                        $tpl->parse_tpl("{class}", $class, true);

                        $tpl->parse_tpl("{none_report}", $none_report, true);
                        $tpl->parse_tpl("{none_delete}", $none_delete, true);
                        $tpl->parse_tpl("{onclick}", $onclick, true);
                        $tpl->parse_tpl("{onclick1}", $onclick1, true);

                        $tpl->parse_tpl("{name}", $name_user, true);
                        $tpl->parse_tpl("{url}", $url, true);

                        $tpl->complete("lenta-container");
                        $cnt++;
                      }
                      $db->free($result_query_popular);
                    }*/
                    $tpl->parse_tpl("{count}", $cnt);
                    $tpl->parse_tpl("{lenta-container}", "");

                    $db->free($result_query_friends_all);
                }
                break;

            case "competition":
                if (!$this->id) header("Location: /");

                $competition = new Competition();
                //$competition->competitionStart();
                $competitionStatus = $competition->getCompetitionStatus();
                if ($competitionStatus == -1) {
                  $tpl->template("competition/main.TPL");
                  $tpl->complete("content");
                  $tpl->template("competition/no.TPL");
                  $tpl->complete("content");
                } else {
                  //load main tpl
                  $tpl->template("competition/main.TPL");
                  $tpl->complete("content");

                  //parse data
                  $dateStart = date("d.m.Y", $competitionStatus['dateStart']);
                  $dateEnd   = date("d.m.Y", $competitionStatus['dateEnd']);

                  //load tpl container
                  $tpl->template("competition/container.TPL");
                  $tpl->parse_tpl("{dateStart}", $dateStart, true);
                  $tpl->parse_tpl("{dateEnd}", $dateEnd, true);
                  $tpl->complete("content");

                  //load TOP photo and users
                  $competitionTop = $competition->getCompetitionTop();

                  if ($competitionTop == -1) {
                    $tpl->template("competition/no.TPL");
                    $tpl->complete("competition-lenta");
                  } else {
                    for ($i = 0; $i < count($competitionTop); $i++) {
                      //info
                      $title = strlen($competitionTop[$i]['title']) == 0 ? "" : $competitionTop[$i]['title'];
                      $descr = strlen($competitionTop[$i]['descr']) == 0 ? "" : $competitionTop[$i]['descr'];
                      $date  = date("d.m.Y", $competitionTop[$i]['time']);
                      $time  = date("H:m", $competitionTop[$i]['time']);

                      //select name
                      $uid = $competitionTop[$i]['user_id'];
                      $select_name = "SELECT first_name, last_name FROM users WHERE id = $uid";
                      $result_select = $db->query($select_name);
                      $fetch_name  = $db->fetch($result_select);
                      $name = $fetch_name['first_name'] . " " . $fetch_name['last_name'];
                      $db->free($result_select);
                      $image_profile = "/upload/" . $competitionTop[$i]['user_id'] . "/photo/icon-profile.jpg";
                      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $image_profile)) {
                        $image_profile = "/tpl/img/no-photo-profile.png";
                      }

                      //button edit photo
                      if ($this->id == $competitionTop[$i]['user_id']) {
                         $none_report = "none";
                         $none_delete = "";
                         $onclick = "edit.deletePhoto()";
                         $onclick1 = "";
                      } else {
                         $none_report = "";
                         $none_delete = "none";
                         $onclick1 = "report.show({$competitionTop[$i]['photo_id']}, 'photo')";
                         $onclick = "";
                      }

                      //parse src image
                      $src_image_album = $competitionTop[$i]['photo'];
                      $len = strlen($src_image_album) - 4;
                      $new_src_ = substr($src_image_album, 0, $len);
                      $src = $new_src_ . "-album.jpg";

                      //width & height image
                      $url_image = $_SERVER['DOCUMENT_ROOT'] . $competitionTop[$i]['photo'];
                      $size = getimagesize($url_image);

                      $width_image = $size[0];
                      $height_image = $size[1];

                      if ($width_image > $height_image) {
                         $width = "100%";
                         $height = "450px";
                      } else if ($width_image < $height_image) {
                         $width = "100%";
                         $height = "650px";
                      } else {
                         $width = "100%";
                         $height = "500px";
                      }
                      $style = "width: $width; height: $height;";

                      //parse tpl
                      $tpl->template("competition/top.TPL");
                      $tpl->parse_tpl("{place-num}", $i + 1, true);
                      $tpl->parse_tpl("{id}", $competitionTop[$i]['photo_id'], true);
                      $tpl->parse_tpl("{uid}", $competitionTop[$i]['user_id'], true);
                      $tpl->parse_tpl("{title}", $title, true);
                      $tpl->parse_tpl("{descr}", $descr, true);
                      $tpl->parse_tpl("{date}", $date, true);
                      $tpl->parse_tpl("{time}", $time, true);
                      $tpl->parse_tpl("{src}", $src, true);
                      $tpl->parse_tpl("{url}", $image_profile, true);
                      $tpl->parse_tpl("{name}", $name, true);
                      $tpl->parse_tpl("{none_report}", $none_report, true);
                      $tpl->parse_tpl("{none_delete}", $none_delete, true);
                      $tpl->parse_tpl("{onclick}", $onclick, true);
                      $tpl->parse_tpl("{onclick1}", $onclick1, true);
                      $tpl->parse_tpl("{style}", "", true);                 //BETA
                      $tpl->complete("competition-lenta");
                    }
                    $tpl->parse_tpl("{competition-lenta}", "");
                  }
                }
                break;

            case "competitionOldResult":
                $competition = new Competition();
                $competitionWinnerOld = $competition->getCompetitionWinnerOld();
                if ($competitionWinnerOld == -1) {
                  die("-1");
                } else {
                  $winner_id = (int) $competitionWinnerOld['wid'];
                  $id_place_two = (int) $competitionWinnerOld['placeTwo'];
                  $id_place_three = (int) $competitionWinnerOld['placeThree'];
                  $image_profile_winner = "/upload/" . $winner_id . "/photo/photo-profile.jpg";
				          if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $image_profile_winner)) {
					          $image_profile_winner = "/tpl/img/no-photo-profile.png";
				          }

                  if ($winner_id != 0) {
                    //select of the rating for winner photo and winner name for user
                    $select_winner_info = "SELECT album.rating, album.time_, competition.dateStart, competition.dateEnd, users.first_name, users.last_name
                                           FROM album, users, competition
                                           WHERE album.time_ >= competition.dateStart AND album.time_ <= competition.dateEnd AND competition.end_ = 1
                                           AND users.id = $winner_id AND album.src = '" . $competitionWinnerOld['photoOne'] . "'
                                           ORDER BY album.rating, competition.dateEnd DESC LIMIT 1";

                    $result_select_info = $db->query($select_winner_info);
                    $fetch_info = $db->fetch($result_select_info);
                    $winner_name = $fetch_info['first_name'] . " " . $fetch_info['last_name'];
                    $winner_photo_rating = $fetch_info['rating'];
                    $db->free($result_select_info);
                  } else {
                    $winner_id_ = true;
                  }

                  //select info name place Two
                  if ($id_place_two == 0) {
                    $name_id_two_ = true;
                  } else {
                    $select_id_two_info = "SELECT first_name, last_name FROM users WHERE id = $id_place_two";
                    $result_id_two_info = $db->query($select_id_two_info);
                    $fetch_id_two_info  = $db->fetch($result_id_two_info);
                    $name_id_two = $fetch_id_two_info['first_name'] . " " . $fetch_id_two_info['last_name'];
                    $db->free($result_id_two_info);
                  }

                  //select info name place Three
                  if ($id_place_three == 0) {
                    $name_id_three_ = true;
                  } else {
                    $select_id_three_info = "SELECT first_name, last_name FROM users WHERE id = $id_place_three";
                    $result_id_three_info = $db->query($select_id_three_info);
                    $fetch_id_three_info  = $db->fetch($result_id_three_info);
                    $name_id_three = $fetch_id_three_info['first_name'] . " " . $fetch_id_three_info['last_name'];
                    $db->free($result_id_three_info);
                  }

                  //parse_
                  $tpl->file("competition/oldResult.TPL");

                  if (!$winner_id_ && !$name_id_two_ && !$name_id_three_) {
                    $tpl->parse_tpl("{king-name}", $winner_name);
                    $tpl->parse_tpl("{rating-king-photo}", $winner_photo_rating);
                    $tpl->parse_tpl("{place-two-name}", $name_id_two);
                    $tpl->parse_tpl("{place-three-name}", $name_id_three);
                    $tpl->parse_tpl("{wid}", $winner_id);
                    $tpl->parse_tpl("{twoid}", $id_place_two);
                    $tpl->parse_tpl("{threeid}", $id_place_three);
                    $tpl->parse_tpl("{src}", $image_profile_winner);

                    $tpl->parse_tpl("[three]", "");
                    $tpl->parse_tpl("[/three]", "");
                    $tpl->parse_block('[two]', '[/two]');
                    $tpl->parse_block('[one]', '[/one]');
                    $tpl->parse_block('[none]', '[/none]');
                  } else if (!$winner_id_ && !$name_id_two_) {
                    $tpl->parse_tpl("{king-name}", $winner_name);
                    $tpl->parse_tpl("{rating-king-photo}", $winner_photo_rating);
                    $tpl->parse_tpl("{place-two-name}", $name_id_two);
                    $tpl->parse_tpl("{wid}", $winner_id);
                    $tpl->parse_tpl("{twoid}", $id_place_two);
                    $tpl->parse_tpl("{src}", $image_profile_winner);

                    $tpl->parse_tpl("[two]", "");
                    $tpl->parse_tpl("[/two]", "");
                    $tpl->parse_block('[three]', '[/three]');
                    $tpl->parse_block('[one]', '[/one]');
                    $tpl->parse_block('[none]', '[/none]');
                  } else if (!$winner_id_) {
                    $tpl->parse_tpl("{king-name}", $winner_name);
                    $tpl->parse_tpl("{rating-king-photo}", $winner_photo_rating);
                    $tpl->parse_tpl("{wid}", $winner_id);
                    $tpl->parse_tpl("{src}", $image_profile_winner);

                    $tpl->parse_tpl("[one]", "");
                    $tpl->parse_tpl("[/one]", "");
                    $tpl->parse_block('[three]', '[/three]');
                    $tpl->parse_block('[two]', '[/two]');
                    $tpl->parse_block('[none]', '[/none]');
                  } else {
                    $src = "/tpl/img/no-photo-profile.png";
                    $tpl->parse_tpl("{src}", $src);
                    $tpl->parse_tpl("[none]", "");
                    $tpl->parse_tpl("[/none]", "");
                    $tpl->parse_block('[three]', '[/three]');
                    $tpl->parse_block('[one]', '[/one]');
                    $tpl->parse_block('[two]', '[/two]');
                  }

                  $tpl->print_file();
                }
                exit();
                break;

            case "subscription":
                if (!$this->id) header("Location: /");

                $uid = !empty($_GET['uid']) ? (int) $_GET['uid'] : $this->id;
                $subscription = new Subscription($uid);
                $numSubscription = $subscription->getNum();
                if ($numSubscription == 0) {
                    $tpl->template("subscription/no.TPL");
                    $tpl->complete("content");
                } else {
                    $load = $subscription->getLoadQuery();
                    if ($this->id == $uid) {
                      $tpl->template("subscription/ajax_page.TPL");
                      $tpl->complete("content");
                    } else {
                      $tpl->template("friends/friends_main.TPL");
                      $tpl->complete("content");
                    }
                    while ($row = $db->fetch($load)) {
                        //select info
                        $query_select_info = "SELECT first_name, last_name FROM users WHERE id = {$row['uid']}";
                        $result_select_info = $db->query($query_select_info);
                        $fetch_info = $db->fetch($result_select_info);
                        $name = $fetch_info['first_name']." ".$fetch_info['last_name'];
                        $src_image = "/upload/".$row['uid']."/photo/photo-profile.jpg";
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $src_image)) {
                          $src_image = "/tpl/img/no-photo-profile.png";
                        }

                        if ($this->id == $uid) {
                          $tpl->template("subscription/list.TPL");
                          $tpl->parse_tpl("{uid}", $row['uid'], true);
                          $tpl->parse_tpl("{name}", $name, true);
                          $tpl->parse_tpl("{src}", $src_image, true);
                          $tpl->complete("list");
                        } else {
                          $tpl->template("friends/list.TPL");
                          $tpl->parse_tpl("{uid}", $row['uid'], true);
                          $tpl->parse_tpl("{name}", $name, true);
                          $tpl->parse_tpl("{photo_src}", $src_image, true);
                          $tpl->complete("list");
                        }

                        //free result
                        $db->free($result_select_info);
                    }
                    $tpl->parse_tpl("{list}", "");
                }
                break;

            case "photo":
                if (!$this->id) header("Location: /");
                $uid_for_photo = (int) $_GET['uid_photo'];
                $from_list = isset($_GET['from_list']) ? (int) $_GET['from_list'] : 0;

                //photo for user where id = $uid
                if (!empty($uid_for_photo)) {
                  $query_select_photo = "SELECT * FROM album WHERE uid = $uid_for_photo AND upload != 1 AND del != 1
                                         ORDER BY rating DESC LIMIT $from_list, 10";
                  $result_select_photo = $db->query($query_select_photo);

                  if ($db->numRows($result_select_photo) == 0) {
                    $tpl->template("lenta/no.TPL");
                    $tpl->complete("content");
                    break;
                  }

                  //load news
                  $tpl->template("lenta/users_for_lenta.TPL");
                  $tpl->complete("content");

                  while ($row = $db->fetch($result_select_photo)) {
                      $src_image_album = $row['src'];
                      $len = strlen($src_image_album) - 4;
                      $new_src_ = substr($src_image_album, 0, $len);
                      $src = $new_src_ . "-album.jpg";

                      //date and time
                      $date  = date("d.m.Y", $row['time_']);
                      $time  = date("H:m", $row['time_']);

                      //info user photo
                      $query_info_user = "SELECT first_name, last_name FROM users WHERE id = {$row['uid']}";
                      $result_query_info = $db->query($query_info_user);
                      $fetch_result_info = $db->fetch($result_query_info);
                      $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                      $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";
                      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
                        $url = "/tpl/img/no-photo-profile.png";
                      }
                      $db->free($result_query_info);

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

                      //load template
                      $tpl->template("lenta/list.TPL");

                      $tpl->parse_tpl("{id}", $row['id'], true);
                      $tpl->parse_tpl("{uid}", $row['uid'], true);
                      $tpl->parse_tpl("{src}", $src, true);
                      $tpl->parse_tpl("{button}", $button, true);
                      $tpl->parse_tpl("{descr}", $row['descr'], true);
                      $tpl->parse_tpl("{title}", $row['title'], true);
                      $tpl->parse_tpl("{date}", $date, true);
                      $tpl->parse_tpl("{time}", $time, true);

                      $tpl->parse_tpl("{none_report}", $none_report, true);
                      $tpl->parse_tpl("{none_delete}", $none_delete, true);
                      $tpl->parse_tpl("{onclick}", $onclick, true);
                      $tpl->parse_tpl("{onclick1}", $onclick1, true);
                      $tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                      $tpl->parse_tpl("{name}", $name_user, true);
                      $tpl->parse_tpl("{url}", $url, true);

                      $tpl->complete("lenta-container");
                  }
                  $tpl->parse_tpl("{lenta-container}", "");
                  $db->free($result_select_photo);
                  break;
                }

                $photo = new Photo();

                $tpl->template("photo.TPL");
                $tpl->complete("content");

                break;

            case "friends":
                if (!$this->id) header("Location: /");

                $uid_ = (int) $_GET["uid_"];

                if (!empty($uid_)) {
                  $from_list = isset($_GET['from_list']) ? (int) $_GET['from_list'] : 0;
                  $select_friends = "SELECT * FROM friends WHERE uid = $uid_ LIMIT $from_list, 10";
                  $result_select_friends = $db->query($select_friends);

                  $tpl->template("friends/friends_main_my.TPL");
                  $tpl->complete("content");

                  if ($db->numRows($result_select_friends) == 0) {
                    $tpl->template("friends/no.TPL");
                    $tpl->complete("list");
                    break;
                  }

                  while ($row = $db->fetch($result_select_friends)) {
                    //info user photo
                    $query_info_user = "SELECT first_name, last_name, photo_src FROM users WHERE id = {$row['fid']}";
                    $result_query_info = $db->query($query_info_user);
                    $fetch_result_info = $db->fetch($result_query_info);
                    $name = $fetch_result_info['first_name'] . " " . $fetch_result_info['last_name'];
                    if ($fetch_result_info['photo_src'] != "") {
                      $photo_src = "/upload/" . $row['fid'] . "/photo/photo-profile.jpg";
                    } else {
                      $photo_src = "/tpl/img/no-photo-profile.png";
                    }
                    $db->free($result_query_info);

                    //parse info
                    $tpl->template("friends/list.TPL");
                    $tpl->parse_tpl("{name}", $name, true);
                    $tpl->parse_tpl("{uid}", $row['fid'], true);
                    $tpl->parse_tpl("{photo_src}", $photo_src, true);
                    $tpl->parse_tpl("{rating}", $rating, true);
                    $tpl->complete("list");
                  }
                  $tpl->parse_tpl("{list}", "");
                  $db->free($result_select_friends);
                  break;
                }

                $friends = new Friends();
                $req     = !empty($_GET['request']) ? $_GET['request'] : 0;
                $uid     = (int) $_GET['uid'];

                if (!empty($uid)) {
                    if ($req == 0)
                       die($friends->add($uid));
                    else
                       die($friends->del($uid));
                }

                break;

            case "search":
                $query = $_GET["q"];
                $search = new Search();
                if (isset($query) AND strlen($query) != 0) $search->q($query);
                else {
                  $tpl->template("search/main.TPL");
                  $tpl->complete("content");
                }
                break;

            case "promotion":
                $p = $_GET['p'];
                $post_id = (int) $_GET['post_id'];
                if ($p == "showDialog") {
                  $tpl->file("promotion/dialog.TPL");
                  $tpl->parse_tpl("{pid}", $post_id);
                  $tpl->print_file();
                  $tpl->clear();
                  exit();
                } else if ($p == "publication") {
                  $pos = strlen($_GET["count_days"]) - 1;
                  $countDays = $_GET["count_days"][$pos];
                  $selectQueryAuthor = "SELECT uid FROM album WHERE id = {$post_id}";
                  $resultQueryAuthor = $db->query($selectQueryAuthor);
                  if ($db->numRows($resultQueryAuthor) == 0) {
                    die("2"); //Error
                    exit();
                  }
                  //select author
                  $fetchAuthor = $db->fetch($resultQueryAuthor);
                  $price = $this->id == $fetchAuthor['uid'] ? 150 : 100;
                  $db->free($resultQueryAuthor);

                  //rating for users
                  $allPrice = $countDays * $price;
                  $selectUserRating = "SELECT rating FROM users WHERE id = $this->id";
                  $resultSelectRating = $db->query($selectUserRating);
                  $fetchRating = $db->fetch($resultSelectRating);

                  if ($fetchRating['rating'] - $allPrice < 0) {
                    die("1"); //Error -> lacks rating
                    exit();
                  }

                  //successful
                  //update rating
                  $queryUpdateRating = "UPDATE users SET rating = rating - $allPrice WHERE id = $this->id";
                  $resultQuery = $db->query($queryUpdateRating);
                  if (!$resultQuery) {
                    die("2");
                    exit();
                  }
                  //add promotion in db
                  $dateAdd = time();
                  $endDate = $dateAdd + (3600 * 24 * $countDays);
                  $queryAddPromotion = "INSERT INTO promotionPictures SET user_id = $this->id,
                                        post_id = '" . $post_id . "', date_ = $dateAdd, endDate = $endDate,
                                        cntDays = {$countDays}";
                  $resultAddQuery = $db->query($queryAddPromotion);
                  if ($resultAddQuery && $resultQuery) die(0);
                  exit();
                } else {
                  die("Error");
                }
                break;

            case "registration_info":
                if (!$this->id) header("Location: /");

                $tpl->template("registration_info.TPL");
                $tpl->complete("content");

                break;

            case "store":
                $s = $_GET['s'];
                if (!empty($s)) {
                  switch ($s) {
                    case "buy":
                      $p = (int) $_GET['p'];
                      switch ($p) {
                        case 1: $price = 250; $premiumDays = 1; break;
                        case 2: $price = 750; $premiumDays = 3; break;
                        case 3: $price = 1750; $premiumDays = 7; break;
                        case 4: $price = 7500; $premiumDays = 30; break;
                        case 5: $price = 22500; $premiumDays = 90; break;
                        case 6: $price = 45000; $premiumDays = 180; break;
                        case 7: $price = 90000; $premiumDays = 360; break;
                        default: die("2"); break;
                      }

                      if ($this->rating_ - $price < 0) {
                        die("1");
                      } else {
                        $updateQueryPremiumDays = "UPDATE users SET
                                                   rating = rating - $price,
                                                   premiumAccountDays = premiumAccountDays + $premiumDays WHERE id = $this->id";
                        $resultQuery = $db->query($updateQueryPremiumDays);
                        if ($resultQuery) {
                          die("0");
                        } else {
                          die("2");
                        }
                      }
                      break;
                  }
                  break;
                }
                $tpl->template("store/main.TPL");
                $tpl->complete("content");
                break;

            case "storeCancel":
                $tpl->template("store/cancel.TPL");
                $tpl->complete("content");
                break;

            case "storeThank":
                $paypalemail = "molodcov.artyom@mail.ru";
                $adminemail  = "support@web-nucleus.com";
                $currency    = "USD";

                $postdata = "";
                foreach ($_POST as $key => $value) $postdata .= $key . "=" . urlencode($value) . "&";
                $postdata .= "cmd=_notify-validate";
                $curl = curl_init("https://www.paypal.com/cgi-bin/webscr");
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
                $response = curl_exec($curl);
                curl_close($curl);

                if ($response != "VERIFIED")  {
                  $tpl->template("store/cancel.TPL");
                  $tpl->complete("content");
                }

                if ($_POST['receiver_email'] != $paypalemail || $_POST["txn_type"] != "web_accept")
                  die("You should not be here ...");

                $orders = new Orders();
                $duplicate = $orders->duplicate($_POST['txn_id']);
                if ($duplicate == 1) {
                  die("I feel like I met you before ...");
                  exit();
                }

                $cart_id = intval($_POST['item_number']);
                $order_date = date("Y-m-d H:i:s", strtotime($_POST["payment_date"]));
                $order_info = [
                  "cart_id"    => $cart_id,
                  "date"       => $order_date,
                  "first_name" => $_POST['first_name'],
                  "last_name"  => $_POST['last_name'],
                  "street"     => $_POST['address_street'],
                  "city"       => $_POST['address_city'],
                  "state"      => $_POST['address_state'],
                  "zip"        => $_POST['address_zip'],
                  "country"    => $_POST['address_country'],
                  "email"      => $_POST["payer_email"],
                  "total"      => $_POST["mc_gross"]
                ];

                $order_new = $orders->insert($order_info);
                if ($order_new) {
                  $tpl->template("store/thank.TPL");
                  $tpl->complete("content");

                  if ($_POST['mc_gross'] == "50.99") {
                    $query = "UPDATE users SET rating = rating + 25 WHERE id = $this->id";
                  } else if ($_POST['mc_gross'] == "100.99") {
                    $query = "UPDATE users SET rating = rating + 50 WHERE id = $this->id";
                  } else if ($_POST['mc_gross'] == "135.99") {
                    $query = "UPDATE users SET rating = rating + 150 WHERE id = $this->id";
                  }
                  $result = $this->db->query($query);
                } else {
                  die("An error has occurred. Please write in support.");
                }
                break;

            case "intro":
                $src = "/upload/".$this->id."/photo/photo-profile.jpg";
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                  $src = "/tpl/img/no-photo-profile.png";
                }
                $tpl->file("intro/main.TPL");
                $tpl->parse_tpl("{name}", $fetch['first_name']);
                $tpl->parse_tpl("{src}", $src);
                $tpl->print_file();
                exit();
                break;

            case "report":
                $type    = (string) $db->escapeString($_GET['type']);
                $rid     = (int)    $db->escapeString($_GET["rid"]); //repost id
                $theme   = (string) $db->escapeString($_GET["theme"]);
                $comment = (string) $db->escapeString($_GET["comment"]);
                $date    = time();

                if (!isset($type) || !isset($rid) || !isset($theme)) return;

                if (strlen($comment) == 0) $comment = "not specified";

                $report_query = "INSERT INTO `report` (`uid`, `rid`, `type`, `theme`, `msg`, `date_`)
                                 VALUES ($this->id, $rid, '" . $type . "', '" . $theme . "', '" . $comment . "', '" . $date . "')";

                $result_report_query = $db->query($report_query);

                if ($result_report_query) die("0");

                exit();
                break;

            case "feedback":
                $message = (string) $db->escapeString($_GET['message']);
                $date    = time();

                if (!isset($message)) return;

                $feedback_query = "INSERT INTO `feedback` (`uid`, `msg`, `date_`)
                                   VALUES ($this->id, '" . $message . "', '" . $date . "')";

                $result_feedback_query = $db->query($feedback_query);

                if ($result_feedback_query) die("0");

                exit();
                break;

            case "vote":
                $id_post = empty($_GET['id_post']) ? -1 : (int) $_GET['id_post'];
                if ($id_post == -1) return;

                $vote = new Vote($id_post);
                $vote_ = $_GET['vote'];

                //VOTE main
                if (isset($vote_) && $id_post != -1) {
                  //select uid
                  $query_select_uid = "SELECT uid FROM album WHERE id = $id_post";
                  $result_query = $db->query($query_select_uid);
                  $fetch_uid = $db->fetch($result_query);

                  if ($fetch_uid['uid'] == $this->id) return;
                  $uid_photo_author = $fetch_uid['uid'];
                  $db->free($result_query);

                  //select rating for user
                  $query_select_rating = "SELECT rating, premiumAccountDays FROM users WHERE id = $uid_photo_author";
                  $result_query_select_rating = $db->query($query_select_rating);
                  $fetch_select_rating = $db->fetch($result_query_select_rating);
                  $rating_default_user = $fetch_select_rating['rating'];
                  $premiumAccountDays  = $fetch_select_rating['premiumAccountDays'];
                  $db->free($result_query_select_rating);

                  //select vote user
                  $query_select_vote = "SELECT * FROM vote_users_photo WHERE uid = $this->id AND post_id = $id_post";
                  $result_query_select_vote = $db->query($query_select_vote);
                  $query_select_vote_num_rows = $db->numRows($result_query_select_vote);
                  $query_fetch_vote = $db->fetch($result_query_select_vote);

                  //vote true or false
                  if ($vote_ == "true") {
                    //
                    if ($query_select_vote_num_rows == 0) {
                        //Update vote for photo
                        $cnt_points_rating = $premiumAccountDays == 0 ? 5 : 10;
                        $query_vote = "UPDATE album SET rating = rating + $cnt_points_rating WHERE id = $id_post";
                        $update_vote_users = "INSERT INTO `vote_users_photo`(`uid`, `post_id`, `type`) VALUES($this->id, $id_post, 0)";
                        $result_vote_users = $db->query($update_vote_users);

                        //Update rating for user
                        $query_update_rating = "UPDATE users SET rating = rating + $cnt_points_rating WHERE id = $uid_photo_author";
                        $result_update_rating = $db->query($query_update_rating);

                        //send notification
                        $type = 0;
                        $rating = 5;
                        $notify = new Notification();
                        $notify->create($type, $rating, $uid_photo_author, $id_post);
                    } else {
                        if ($query_fetch_vote['type'] == 0) {
                            die("2"); //vote is isset
                            exit();
                        } else {
                            //Update vote for photo
                            $cnt_points_rating = $premiumAccountDays == 0 ? 3 : 11;
                            $query_vote = "UPDATE album SET rating = rating + $cnt_points_rating WHERE id = $id_post";
                            $update_vote_users = "UPDATE vote_users_photo SET type = 0 WHERE uid = $this->id AND post_id = $id_post";
                            $result_vote_users = $db->query($update_vote_users);

                            //Update rating for user
                            $query_update_rating = "UPDATE users SET rating = rating + $cnt_points_rating WHERE id = $uid_photo_author";
                            $result_update_rating = $db->query($query_update_rating);

                            //send notification
                            $type = 0;
                            $rating = 3;
                            $notify = new Notification();
                            $notify->create($type, $rating, $uid_photo_author, $id_post);
                        }
                    }
                  } else {
                    //
                    if ($query_select_vote_num_rows == 0) {
                        //select rating
                        $query_vote_select = "SELECT rating FROM album WHERE id = $id_post";
                        $result_query_vote_s = $db->query($query_vote_select);
                        $fetch_query_vote = $db->fetch($result_query_vote_s);

                        $cnt_points_rating = $premiumAccountDays == 0 ? 2 : 1;

                        if ($fetch_query_vote['rating'] - $cnt_points_rating <= 0) $rating = 0;
                        else $rating = $fetch_query_vote['rating'] - $cnt_points_rating;

                        //update rating
                        $query_vote = "UPDATE album SET rating = $rating WHERE id = $id_post";
                        //update users vote
                        $update_vote_users = "INSERT INTO `vote_users_photo`(`uid`, `post_id`, `type`) VALUES($this->id, $id_post, 1)";
                        $result_vote_users = $db->query($update_vote_users);

                        //free select
                        $db->free($result_query_vote_s);

                        //Update rating for user
                        if ($rating_default_user - $cnt_points_rating <= 0) $rating_for_user_d = 0;
                        else $rating_for_user_d = $rating_default_user - $cnt_points_rating;
                        $query_update_rating = "UPDATE users SET rating = $rating_for_user_d WHERE id = $uid_photo_author";
                        $result_update_rating = $db->query($query_update_rating);

                        //send notification
                        $type = 1;
                        $rating = -2;
                        $notify = new Notification();
                        $notify->create($type, $rating, $uid_photo_author, $id_post);
                    } else {
                        if ($query_fetch_vote['type'] == 1) {
                            die("3");
                            exit();
                        } else {
                            //select rating
                            $query_vote_select = "SELECT rating FROM album WHERE id = $id_post";
                            $result_query_vote_s = $db->query($query_vote_select);
                            $fetch_query_vote = $db->fetch($result_query_vote_s);

                            $cnt_points_rating = $premiumAccountDays == 0 ? 7 : 11;

                            if ($fetch_query_vote['rating'] - $cnt_points_rating <= 0) $rating = 0;
                            else $rating = $fetch_query_vote['rating'] - $cnt_points_rating;

                            //update rating
                            $query_vote = "UPDATE album SET rating = $rating WHERE id = $id_post";
                            //update users vote
                            $update_vote_users = "UPDATE vote_users_photo SET type = 1 WHERE uid = $this->id AND post_id = $id_post";
                            $result_vote_users = $db->query($update_vote_users);

                            //
                            $db->free($result_query_vote_s);

                            //Update rating for user
                            if ($rating_default_user - $cnt_points_rating <= 0) $rating_for_user_d = 0;
                            else $rating_for_user_d = $rating_default_user - $cnt_points_rating;
                            $query_update_rating = "UPDATE users SET rating = $rating_for_user_d WHERE id = $uid_photo_author";
                            $result_update_rating = $db->query($query_update_rating);

                            //send notification
                            $type = 1;
                            $rating = -7;
                            $notify = new Notification();
                            $notify->create($type, $rating, $uid_photo_author, $id_post);
                        }
                    }
                  }
                  //free
                  $db->free($result_query_select_vote);
                  //update query rating photo
                  $result_vote = $db->query($query_vote);
                  if ($result_vote) die("0");
                  else die("1");
                } else {
                  $vote->init();
                }

                exit();
                break;

            case "voteComment":
                $post_id = (int) $db->escapeString($_GET['post_id']);
                $display = (string) $_GET["display"];

                if (isset($display) && $display == "comment" && !empty($post_id)) {
                  //output tpl comment for window
                  $tpl->file("vote/comment.TPL");
                  $tpl->parse_tpl("{post_id}", $post_id);
                  $tpl->print_file();

                  exit();
                }

                //add comment for photo
                $comment = (string) $db->escapeString($_GET['textComment']);
                if (strlen($comment) == 0) return;

                $date = time();
                $comment_query = "INSERT INTO `comment_photo_album` (`uid`, `post_id`, `msg`, `date_`)
                                  VALUES ($this->id, $post_id, '" . $comment . "', '" . $date . "')";

                $result_add_comment = $db->query($comment_query);

                //notify comment
                //select id for user on notify
                $select_query_id_notify = "SELECT uid FROM album WHERE id = $post_id";
                $result_select_id_notify = $db->query($select_query_id_notify);
                $fetch_id_notify = $db->fetch($result_select_id_notify);
                $notify_id = $fetch_id_notify['uid'];
                $db->free($result_select_id_notify);

                //send notify
                $notification = new Notification();
                $notification->create(3, $notify_id, $post_id, $comment);

                if ($result_add_comment) die("0");

                exit();
                break;

            case "reply":
                $reply = new Reply();
                if ($reply->getNumReply() == 0) {
                  $tpl->template("reply/no.TPL");
                  $tpl->complete("content");
                } else {
                  $tpl->template("reply/main.TPL");
                  $tpl->complete("content");

                  $result = $reply->getResultReply();
                  while ($row = $db->fetch($result)) {
                    //parse info reply
                    $date = date("d.m.Y", $row['date_']) == date("d.m.Y") ? "сегодня" : date("d.m.Y", $row['date_']);
                    $time = date("H:m", $row['date_']);

                    //select name for user
                    $query_select_name = "SELECT first_name, last_name, sex FROM users WHERE id = {$row['uid']}";
                    $result_select_name = $db->query($query_select_name);
                    $fetch_result = $db->fetch($result_select_name);
                    $name = $fetch_result['first_name'] . " " . $fetch_result["last_name"];
                    $image = "/upload/" . $row['uid'] . "/photo/photo-profile.jpg";
					          $sex = $fetch_result['sex'];

                    //type
                    if ($row['type'] == 0) {
						          if ($sex = 1) $type_reply = "проголосовал за <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикацию</span>.";
						          else $type_reply = "проголосовала за <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикацию</span>";
                    } else if ($row['type'] == 1) {
					            if ($sex == 1) $type_reply = "проголосовал против <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикации</span>.";
						          else $type_reply = "проголосовал против <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикации</span>.";
                    } else if ($row['type'] == 2) {
						          if ($sex == 1) $type_reply = "подписался на Вас.";
					            else $type_reply = "подписалась на Вас.";
				            } else if ($row['type'] == 3) {
						          if ($sex == 1) $type_reply = "оставил комментарий под <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикацей</span>.";
						          else $type_reply = "оставила комментарий под <span class=\"reply-span-c\" onclick=\"preview.loadImage({$row['post_photo']})\">публикацей</span>.";
					          } else if ($row['type'] == 4) {
                      $user_id = $this->id;
                      $image = "/tpl/img/notify.png";
					            $name = "Вы ";
                      $type_reply = "занали 1 место в конкурсе";
                    } else if ($row['type'] == 5) {
                      $user_id = $this->id;
                      $image = "/tpl/img/notify.png";
					            $name = "Вы ";
                      $type_reply = "занали 2 место в конкурсе";
                    } else if ($row['type'] == 6) {
                      $user_id = $this->id;
                      $image = "/tpl/img/notify.png";
					            $name = "Вы ";
                      $type_reply = "занали 3 место в конкурсе";
                    } else if ($row['type'] == 7) {
                      $user_id = $this->id;
                      $image = "/tpl/img/notify.png";
					            $name = "";
                      $type_reply = "Уведомление от администрации";
                    }

                    $user_id = $row['uid'];
                    if ($row['type'] == 3 || $row['type'] == 0 || $row['type'] == 1) {
                      if ($this->king == 0) {
                        $user_id = 0;
                        $name = "Засекречено";
                        $image = "/tpl/img/no-photo-profile.png";
                      }
                    }

                    if ($row['read_'] == 0) {
                      $class = "new_notify";
                    } else {
                      $class = "";
                    }

                    //parse tpl
                    $tpl->template("reply/list.TPL");
                    $tpl->parse_tpl("{uid}", $user_id, true);
                    $tpl->parse_tpl("{date}", $date, true);
                    $tpl->parse_tpl("{time}", $time, true);
                    $tpl->parse_tpl("{name}", $name, true);
                    $tpl->parse_tpl("{url}", $image, true);
                    $tpl->parse_tpl("{reply}", $type_reply, true);
                    $tpl->parse_tpl("{msg}", $row['post_comment'], true);
                    $tpl->parse_tpl("{new-notify}", $class, true);
                    $tpl->complete("reply-content");

                    //update read notify
                    $n_id = (int) $row['id'];
                    $upd_read = $reply->updateReadNotify($n_id);
                  }
                  $tpl->parse_tpl("{reply-content}", "");
                }
                break;

            case "comment":
                $post_id = (int) $db->escapeString($_GET['post_id']);
                $king_status = $this->king;
                $comment = new Comment($post_id, $king_status);
                $comment->init();
                exit();
                break;

            case "preview":
                $p = $_GET['p'];
                switch ($p) {
                   case "loadImage":
                      $image_id = (int) $_GET['image_id'];
                      if (empty($image_id)) {
                         die("1");
                         exit();
                      }
                      $query_select_info = "SELECT * FROM album WHERE id = $image_id";
                      $result_select_info = $db->query($query_select_info);
                      $fetch_result_ = $db->fetch($result_select_info);

                      //size fo image
                      $url_image = $_SERVER['DOCUMENT_ROOT'] . $fetch_result_['src'];
                      $size = getimagesize($url_image);

                      $width_image = $size[0];
                      $height_image = $size[1];

                      if ($width_image > $height_image) {
                         $width = "700px";
                         $height = "450px";
                      } else if ($width_image < $height_image) {
                         $width = "380px";
                         $height = "650px";
                      } else {
                         $width = "380px";
                         $height = "380px";
                      }

                      $tpl_css = "background-image: url({$fetch_result_['src']});";
                      $tpl_css .= "width: {$width};max-width: 100%;";
                      $tpl_css .= "height: {$height}";

                      $date = date("d.m.Y H:m", $fetch_result_['time_']);

                      $selectNameUser = "SELECT first_name, last_name FROM users WHERE id = {$fetch_result_['uid']}";
                      $resultSelectQuery = $db->query($selectNameUser);
                      $fetchNameUser = $db->fetch($resultSelectQuery);

                      $name = $fetchNameUser['first_name'] . " " . $fetchNameUser['last_name'];
                      $db->free($resultSelectQuery);

                      $iconUser = "/upload/" . $fetch_result_['uid'] . "/photo/icon-profile.jpg";

                      if (empty($fetch_result_['title']) && empty($fetch_result_['descr'])) {
                        $none = "none";
                        $imageTitle = "";
                        $imageDescr = "";
                      } else {
                        $none = "";
                        $imageTitle = $fetch_result_['title'];
                        $imageDescr = $fetch_result_['descr'];
                      }

                      if ($fetch_result_['category'] == 1) $category = "Животные";
                      else if ($fetch_result_['category'] == 2) $category = "Еда и напитки";
                      else if ($fetch_result_['category'] == 3) $category = "Люди и общество";
                      else if ($fetch_result_['category'] == 4) $category = "Технологии";
                      else if ($fetch_result_['category'] == 5) $category = "Природа";
                      else if ($fetch_result_['category'] == 6) $category = "Селфи";
                      else $category = "Животные";

                      if ($fetch_result_['uid'] == $this->id) {
                        $btnPreviewPhoto = "Удалить";
                        $onclickBtnPhoto = "edit.deletePhoto({$fetch_result_['id']})";
                      } else {
                        $btnPreviewPhoto = "Пожаловаться";
                        $onclickBtnPhoto = "report.show({$fetch_result_['id']}, 'photo')";
                      }

                      $tpl->file("preview/image.TPL");
                      $tpl->parse_tpl("{id}", $image_id);
                      $tpl->parse_tpl("{w}", $width);
                      $tpl->parse_tpl("{h}", $height);
                      $tpl->parse_tpl("{src}", $fetch_result_['src']);
                      $tpl->parse_tpl("{css}", $tpl_css);
                      $tpl->parse_tpl("{uid}", $fetch_result_['uid']);
                      $tpl->parse_tpl("{name}", $name);
                      $tpl->parse_tpl("{date}", $date);
                      $tpl->parse_tpl("{icon-user}", $iconUser);
                      $tpl->parse_tpl("{none}", $none);
                      $tpl->parse_tpl("{title}", $imageTitle);
                      $tpl->parse_tpl("{text}", $imageDescr);
                      $tpl->parse_tpl("{category}", $category);
                      $tpl->parse_tpl("{rating}", $fetch_result_['rating']);
                      $tpl->parse_tpl("{txt-btn}", $btnPreviewPhoto);
                      $tpl->parse_tpl("{clickReport}", $onclickBtnPhoto);
                      $tpl->print_file();
                      $tpl->clear();

                      $db->free($result_select_info);
                      break;
                }
                exit();
                break;

            case "blocking":
                if (!$this->id) header("Location: /");

                $uid = (int) $_GET['uid'];
                if (empty($uid)) die("Error");

                $query_blocking = "INSERT INTO block_user(`uid`, `bid`) VALUES ($this->id, $uid)";
                $result = $db->query($query_blocking);

                $query_delete_friends = "DELETE FROM friends WHERE fid = $this->id AND uid = $uid";
                $result_delete_req = $db->query($query_delete_friends);

                $query_delete_ = "DELETE FROM friends WHERE fid = $uid AND uid = $this->uid";
                $result_delete_ = $db->query($query_delete_friends);

                if ($result && $result_delete_req && $result_delete_) die("0");
                else die("1");

                exit();
                break;

            case "release":
                if (!$this->id) header("Location: /");

                $uid = (int) $_GET['uid'];
                if (empty($uid)) die("Error");

                $query_release = "DELETE FROM block_user WHERE uid = $this->id AND bid = $uid";
                $result = $db->query($query_release);

                if ($result) die("0");
                else die("1");

                exit();
                break;

            case "log_out":
                $this->log_out();
                break;

            case "edit":
                $query_select_info = "SELECT first_name, last_name, sex, bdate FROM users WHERE id = $this->id";
                $result_info = $db->query($query_select_info);
                $fetch_info  = $db->fetch($result_info);

                $sex = $fetch_info['sex'] == 0 ? "женский" : "мужской";
                $bdate = $fetch_info['bdate'];

                $tpl->template("edit/main.TPL");
                $tpl->parse_tpl("{first_name}", $fetch_info['first_name'], true);
                $tpl->parse_tpl("{last_name}", $fetch_info['last_name'], true);
                $tpl->parse_tpl("{sex}", $sex, true);
                $tpl->parse_tpl("{bdate}", $bdate, true);
                $tpl->complete("content");

                $db->free($result_info);
                break;

            case "ajax":
                if (!$this->id) break;
                $from = (int) empty($_GET['from']) ? 0 : $_GET['from'];
                $href = $_GET['href'];
                switch ($href) {
                  case "/":
                    $selectQuery = "SELECT * FROM album WHERE upload != 1 AND del != 1 ORDER BY rating DESC LIMIT $from, 10";
                    $resultQuery = $db->query($selectQuery);
                    if ($db->numRows($resultQuery) == 0) {
                      die("1");
                      break;
                    }
                    $tpl->file("lenta/ajax.TPL");

                    while ($row = $db->fetch($resultQuery)) {
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
                      $result_query_info = $db->query($query_info_user);
                      $fetch_result_info = $db->fetch($result_query_info);
                      $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                      $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";
                      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
                        $url = "/tpl/img/no-photo-profile.png";
                      }
                      $db->free($result_query_info);

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

                      if (file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                        $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);
                        $imageWidth = $size[0];
                        $imageHeight = $size[1];
                        if ($imageWidth > $imageHeight) {
                          $newImageWidth = 645;
                          $newIMageHeight = 400;
                          $class = "mobile-photo-album";
                        } else if ($imageWidth < $imageHeight) {
                          $newImageWidth = 645;
                          $newIMageHeight = 862;
                          $class = "mobile-photo-portrait";
                        } else {
                          $newImageWidth = 645;
                          $newIMageHeight = 645;
                          $class = "mobile-photo-album";
                        }
                      } else {
                        $src = "/tpl/img/no-image.png";
                        $newImageWidth = 645;
                        $newIMageHeight = 400;
                        $class = "mobile-photo-album";
                      }

                      //load template
                      $tpl->template("lenta/list.TPL");

                      $tpl->parse_tpl("{id}", $row['id'], true);
                      $tpl->parse_tpl("{uid}", $row['uid'], true);
                      $tpl->parse_tpl("{src}", $src, true);
                      $tpl->parse_tpl("{button}", $button, true);
                      $tpl->parse_tpl("{descr}", $row['descr'], true);
                      $tpl->parse_tpl("{title}", $row['title'], true);
                      $tpl->parse_tpl("{date}", $date, true);
                      $tpl->parse_tpl("{time}", $time, true);
                      $tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                      $tpl->parse_tpl("{imageWidth}", $newImageWidth, true);
                      $tpl->parse_tpl("{imageHeight}", $newIMageHeight, true);
                      $tpl->parse_tpl("{class}", $class, true);

                      $tpl->parse_tpl("{none_report}", $none_report, true);
                      $tpl->parse_tpl("{none_delete}", $none_delete, true);
                      $tpl->parse_tpl("{onclick}", $onclick, true);
                      $tpl->parse_tpl("{onclick1}", $onclick1, true);

                      $tpl->parse_tpl("{name}", $name_user, true);
                      $tpl->parse_tpl("{url}", $url, true);

                      $tpl->complete("lenta-container");
                      $cnt++;
                    }
                    $tpl->parse_tpl("{lenta-container}", "");

                    $tpl->print_file();
                    $tpl->clear();
                    break;

                  case "/lenta":
                    //select id friends
                    $query_friends_all = "SELECT * FROM friends WHERE fid = $this->id AND friends = 1";
                    $result_query_friends_all = $db->query($query_friends_all);

                    while ($rows = $db->fetch($result_query_friends_all)) {
                      $friends_id = (int) $rows['uid'];
                      $query_popular_photo = "SELECT * FROM album WHERE uid = $friends_id AND upload != 1 AND del != 1 ORDER BY rating, time_ DESC LIMIT $from, 10";
                      $result_query_popular = $db->query($query_popular_photo);

                      if ($db->numRows($result_query_popular) == 0) {
                         die("1");
                         break;
                      }

                      //load news
                      $tpl->file("lenta/ajax.TPL");

                      $cnt = 0;
                      while ($row = $db->fetch($result_query_popular)) {
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
                        $result_query_info = $db->query($query_info_user);
                        $fetch_result_info = $db->fetch($result_query_info);
                        $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                        $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
                          $url = "/tpl/img/no-photo-profile.png";
                        }
                        $db->free($result_query_info);

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

                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                          $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);
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
                        } else {
                          $src = "/tpl/img/no-image.png";
                          $newImageWidth = 645;
                          $newIMageHeight = 400;
                        }

                        //load template
                        $tpl->template("lenta/list.TPL");

                        $tpl->parse_tpl("{id}", $row['id'], true);
                        $tpl->parse_tpl("{uid}", $row['uid'], true);
                        $tpl->parse_tpl("{src}", $src, true);
                        $tpl->parse_tpl("{button}", $button, true);
                        $tpl->parse_tpl("{descr}", $row['descr'], true);
                        $tpl->parse_tpl("{title}", $row['title'], true);
                        $tpl->parse_tpl("{date}", $date, true);
                        $tpl->parse_tpl("{time}", $time, true);
                        $tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                        $tpl->parse_tpl("{imageWidth}", $newImageWidth, true);
                        $tpl->parse_tpl("{imageHeight}", $newIMageHeight, true);

                        $tpl->parse_tpl("{none_report}", $none_report, true);
                        $tpl->parse_tpl("{none_delete}", $none_delete, true);
                        $tpl->parse_tpl("{onclick}", $onclick, true);
                        $tpl->parse_tpl("{onclick1}", $onclick1, true);

                        $tpl->parse_tpl("{name}", $name_user, true);
                        $tpl->parse_tpl("{url}", $url, true);

                        $tpl->complete("lenta-container");
                        $cnt++;
                      }
                      $db->free($result_query_popular);
                      $tpl->parse_tpl("{lenta-container}", "");

                      $tpl->print_file();
                      $tpl->clear();
                    }
                    break;
                }
                exit();
              break;

            default:
                if (!$this->id) break;
                $lenta = new Lenta();
                $count = !empty($_GET['cnt']) ? $_GET['cnt'] : 10;

                //load lenta
                if (!$lenta->getLentaNumRows()) {
                    $tpl->template("no_lenta.TPL");
                    $tpl->complete("content");
                } else  {
                    $query_popular_photo = "SELECT * FROM album WHERE upload != 1 AND del != 1 ORDER BY rating DESC LIMIT 10";
                    $result_query_popular = $db->query($query_popular_photo);

                    if ($db->numRows($result_query_popular) == 0) {
                       $tpl->template("lenta/no.TPL");
                       $tpl->complete("content");
                       break;
                    }

                    //load news
                    $tpl->template("lenta/main.TPL");
                    $tpl->complete("content");
                    $tpl->parse_tpl("{promotion-lenta}", "");

                    $cnt = 0;
                    while ($row = $db->fetch($result_query_popular)) {
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
                      $result_query_info = $db->query($query_info_user);
                      $fetch_result_info = $db->fetch($result_query_info);
                      $name_user = $fetch_result_info['first_name']." ".$fetch_result_info['last_name'];
                      $url = "/upload/".$row['uid']."/photo/icon-profile.jpg";
                      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
                        $url = "/tpl/img/no-photo-profile.png";
                      }
                      $db->free($result_query_info);

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

                      if (file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                        $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);
                        $imageWidth = $size[0];
                        $imageHeight = $size[1];
                        if ($imageWidth > $imageHeight) {
                          $newImageWidth = 645;
                          $newIMageHeight = 400;
                          $class = "mobile-photo-album";
                        } else if ($imageWidth < $imageHeight) {
                          $newImageWidth = 645;
                          $newIMageHeight = 862;
                          $class = "mobile-photo-portrait";
                        } else {
                          $newImageWidth = 645;
                          $newIMageHeight = 645;
                          $class = "mobile-photo-album";
                        }
                      } else {
                        $src = "/tpl/img/no-image.png";
                        $newImageWidth = 645;
                        $newIMageHeight = 400;
                        $class = "mobile-photo-album";
                      }

                      //load template
                      $tpl->template("lenta/list.TPL");

                      $tpl->parse_tpl("{id}", $row['id'], true);
                      $tpl->parse_tpl("{uid}", $row['uid'], true);
                      $tpl->parse_tpl("{src}", $src, true);
                      $tpl->parse_tpl("{button}", $button, true);
                      $tpl->parse_tpl("{descr}", $row['descr'], true);
                      $tpl->parse_tpl("{title}", $row['title'], true);
                      $tpl->parse_tpl("{date}", $date, true);
                      $tpl->parse_tpl("{time}", $time, true);
                      $tpl->parse_tpl("{photo-rating}", $row['rating'], true);

                      $tpl->parse_tpl("{imageWidth}", $newImageWidth, true);
                      $tpl->parse_tpl("{imageHeight}", $newIMageHeight, true);
                      $tpl->parse_tpl("{class}", $class, true);

                      $tpl->parse_tpl("{none_report}", $none_report, true);
                      $tpl->parse_tpl("{none_delete}", $none_delete, true);
                      $tpl->parse_tpl("{onclick}", $onclick, true);
                      $tpl->parse_tpl("{onclick1}", $onclick1, true);

                      $tpl->parse_tpl("{name}", $name_user, true);
                      $tpl->parse_tpl("{url}", $url, true);

                      $tpl->complete("lenta-container");
                      $cnt++;
                    }
                    $tpl->parse_tpl("{count}", $cnt);
                    $tpl->parse_tpl("{lenta-container}", "");
                    $db->free($result_query_popular);
                }
                break;
          }

          //output file
          $tpl->print_file();
          $tpl->clear();
       }

       /**
       *log out is app
       */
       public function log_out() {
          session_destroy();
          header("Location: /");
       }

       /**
       *@return SESSION ID user
       */
       public function getSessionId() {
          return $_SESSION['id'];
       }
   }
