<?php
   namespace Nucleus;

   class Profile
   {
       public $uid;
       public $id;
       public $db;

       public $rating;
       public $king;
       public $king_cnt;

       private $user_ver;
       private $premiumAccountDays;
       private $notUser = false;
       private $photo_src;
       private $sex;
       private $bdate;
       private $del;
       private $block;
       private $off;

       public function __construct($uid) {
           $this->uid = $uid;
           $this->id  = $_SESSION['id'];
           $this->db  = DB::getInstance();
       }

       /**
       *  @return name;
       */
       public function getName() {
           $query = "SELECT first_name, last_name, sex, bdate, user_ver, photo_src, rating, king, king_cnt, premiumAccountDays, off, del, block
                     FROM users WHERE id = $this->uid";
           $result = $this->db->query($query);

           if ($this->db->numRows($result) == 0) {
             $this->king_cnt = 0;
             $this->king = 0;
             $this->rating = 0;
             $this->user_ver = 0;
             $name = "User not found";
             $this->notUser = true;
             $this->photo_src = "";
             $this->premiumAccountDays = 0;
             $this->sex = 0;
             $this->bdate = "";
             $this->del = 0;
             $this->block = 0;
             $this->off = 0;
           } else {
             $fetch_ = $this->db->fetch($result);
             $this->rating = $fetch_['rating'];
             $this->king_cnt = $fetch_['king_cnt'];
             $this->king = $fetch_['king'];
             $this->user_ver = $fetch_['user_ver'];
             $this->photo_src = $fetch_['photo_src'];
             $name = $fetch_['first_name']." ".$fetch_['last_name'];
             $this->premiumAccountDays = $fetch_['premiumAccountDays'];
             $this->sex = $fetch_['sex'];
             $this->bdate = $fetch_['bdate'];
             $this->del = $fetch_['del'];
             $this->block = $fetch_['block'];
             $this->off = $fetch_['off'];
           }

           $this->db->free($result);

           return $name;
       }

       /**
       * @return user verification
       */
       public function getUserVerified() {
           return $this->user_ver;
       }

       /**
       * @return photo src
       */
       public function getPhotoSrc() {
           return $this->photo_src;
       }

       /**
       * @return boolean response of user
       */
       public function getFoundUser() {
           return $this->notUser;
       }

       /**
       * @return ratign for user
       */
       public function getRating() {
           if ($this->rating < 1000) {
             $rating = $this->rating;
           } else if ($this->rating <= 100000 && $this->rating >= 1000) {
             $rating = round($this->rating / 1000, 1, PHP_ROUND_HALF_UP) . "K";
           } else if ($this->rating < 999999 && $this->rating >= 100000) {
             $rating = round($this->rating / 1000, 1, PHP_ROUND_HALF_UP);
             $rating = substr($rating, 0, 3) . "K";
           } else if ($this->rating >= 999999 && $this->rating < 999999999) {
             $rating = round($this->rating / 1000000, 1, PHP_ROUND_HALF_UP) . "M";
             $rating = ceil($rating) . "M";
           }

           return $rating;
       }

       /**
       * @return count friends for user
       */
       public function getCountFriends() {
           $query_select_count_friends = "SELECT COUNT(fid) AS cnt FROM friends WHERE fid = $this->uid";
           $result_query = $this->db->query($query_select_count_friends);
           $fetch_result = $this->db->fetch($result_query);
           $count_friends = $fetch_result['cnt'];
           $this->db->free($result_query);

           return $count_friends;
       }

       /**
       * @return count subscription for user
       */
       public function getCountSubscription() {
           $query_select_count_subscription = "SELECT COUNT(uid) AS cnt FROM friends WHERE uid = $this->uid";
           $result_query = $this->db->query($query_select_count_subscription);
           $fetch_result = $this->db->fetch($result_query);
           $count_subscription = $fetch_result['cnt'];
           $this->db->free($result_query);

           return $count_subscription;
       }

       /**
       * @return count photo for user
       */
       public function getCountPhoto() {
           $query_select_count_photo = "SELECT COUNT(uid) AS cnt FROM album WHERE uid = $this->uid AND del != 1 AND upload != 1";
           $result_query = $this->db->query($query_select_count_photo);
           $fetch_result = $this->db->fetch($result_query);
           $count_photo = $fetch_result['cnt'];
           $this->db->free($result_query);

           return $count_photo;
       }

       /**
       * @return count king for user
       */
       public function getCountKing() {
           return $this->king_cnt;
       }

       /**
       * @return king for user
       */
       public function getKing() {
           return $this->king;
       }

       /**
       * @return  premiumAccountDays
       */
       public function getPremiumAccountDays() {
           return $this->premiumAccountDays;
       }

       /**
       * @return src photo profile
       */
       public function getSrcPhoto() {
           $photo_src = "/upload/".$this->uid."/photo/photo-profile.jpg";
           $photo_src_dir = $_SERVER['DOCUMENT_ROOT'] . $photo_src;
           if (!file_exists($photo_src_dir)) {
             $photo_src = "/tpl/img/no-photo-profile.png";
           }
           return $photo_src;
       }

       /**
       * @return true if user id = uid else false
       */
       public function getUser() {
           if ($this->uid == $this->id) return true;
           else return false;
       }

       /**
       * @return sex
       */
       public function getSex() {
          return $this->sex == 0 ? "женский" : "мужской";
       }

       /**
       * @return bdate
       */
       public function getBdate() {
          return $this->bdate;
       }

       /**
       * @return del user
       **/
       public function getDeletedUser() {
          return $this->del;
       }

       /**
       * @return off user
       **/
       public function getOffUser() {
          return $this->off;
       }

       /**
       * @return blocking user
       */
       public function getBlockingUser() {
          return $this->block;
       }

       /**
       * @return popular photo for user
       */
       public function getPopularPhoto() {
           $query_select_popular_photo = "SELECT * FROM album WHERE uid = $this->uid AND del != 1 AND upload = 0 ORDER BY rating DESC LIMIT 5";
           $result_query = $this->db->query($query_select_popular_photo);

           return $result_query;
       }
   }
