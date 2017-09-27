<?php 

require "config.php";

interface interMail
{
  public function __construct($to, $type);
  public function send();
}

class Mail
{
  public $to;
  public $subject;
  public $msg;
  public $headers;
  private $hash;

  public function __construct($to, $type) {
    switch ($type) {
      case 0:
        $this->hash = md5($to . "-nucleus-" . time());
        $_SESSION['hash_email_ver'] = $this->hash;

        $this->to = $to;
        $this->subject = "Confirmation email addresses";
        $this->msg = '
        Hi!<br/>
        In your E-mail address passed registration <a href="http://vtreke.xyz">vtreke.xyz</a> site. To continue, please confirm the email address at this link: <a href="http://vtreke.xyz/code.php?act=email_ver&hash='.$this->hash.'">http://vtreke.xyz/code.php?act=email_ver&hash='.$this->hash.'</a>.
        If you are not registered, please, do not go here.<br/><br/>
        Sincerely, <br/>Nucleus team.
        ';
   
        $this->send();
        break;
    }
  }

  public function send() {
    $this->headers  = 'MIME-Version: 1.0' . "\r\n";
    $this->headers .= "Content-type: text/html; charset=UTF-8 \r\n";
    $this->headers .= "From: <support@vtreke.xyz>";

    $res = mail($this->to, $this->subject, $this->msg, $this->headers);
  }
}

if ($_GET['secret_mail_key_admin'] && $_GET['secret_mail_key_admin'] == "dooliNucleusTestTwo") {
  $to = $_GET['to'];
  $type = (int) $_GET['type'];
  $mail = new Mail($to, $type);
}