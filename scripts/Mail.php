<?php

namespace Nucleus;

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

  /**
  * @param int $type. Key and value:
  *  0 - Confirmation email addresses
  *  1 - Change email address
  *  2 - Change password
  *  3 - Started new competition
  *  4 - Winner user in competition
  *  5 - Place 2 in competition
  *  6 - Place 3 in competition
  *  7 - Restore password
  */
  public function __construct($to, $type) {
    switch ($type) {
      case 0:
        $this->hash = md5($to . "-nucleus-" . time());
        $_SESSION['hash_email_ver'] = $this->hash;

        $this->to = $to;
        $this->subject = "Confirmation email addresses";
        $this->msg = '
        Hi!<br/>
        In your E-mail address passed registration <a href="http://web-nucleus.com">web-nucleus.com</a> site. To continue, please confirm the email address at this link: <a href="http://web-nucleus.com/code.php?act=email_ver&hash='.$this->hash.'">http://web-nucleus.com/code.php?act=email_ver&hash='.$this->hash.'</a>.
        If you are not registered, please, do not go here.<br/>
        Sincerely, <br/>Nucleus team.
        ';

        $this->send();
        break;

      case 1:
        $this->to = $to;
        $this->subject = "Change email address";
        $this->msg = '
        The site <a href="http://web-nucleus.com">web-nucleus.com</a> was successfully changed email address. If you did not, then, immediately, report it to the support.<br/>
        Sincerely, <br/>Nucleus team.
        ';

        $this->send();
        break;

      case 2:
        $this->to = $to;
        $this->subject = "Change password";
        $this->msg = '
        The site <a href="http://web-nucleus.com">web-nucleus.com</a> was successfully changed password. If you did not, then, immediately, report it to the support.<br/>
        Sincerely, <br/>Nucleus team.
        ';

        $this->send();
        break;

      case 3:
        $this->to = $to;
        $this->subject = "A new competition";
        $this->msg = '
        The site <a href="http://web-nucleus.com">web-nucleus.com</a> was successfully changed password. If you did not, then, immediately, report it to the support.<br/>
        Sincerely, <br/>Nucleus team. (<a href="http://web-nucleus.com">web-nucleus.com</a>)
        ';
        break;

      case 4:
        $this->to = $to;
        $this->subject = "You are the winner";
        $this->msg = '
        Congratulations!<br/>
        You are the winner of our contest. Go back to the site to get bonuses.
        Sincerely, <br/>Nucleus team. (<a href="http://web-nucleus.com">web-nucleus.com</a>)
        ';
        break;

      case 5:
        $this->to = $to;
        $this->subject = "You took the second place";
        $this->msg = '
        Congratulations!<br/>
        You have taken the second place in the competition. Go back to the site to get bonuses.
        Sincerely, <br/>Nucleus team. (<a href="http://web-nucleus.com">web-nucleus.com</a>)
        ';
        break;

      case 6:
        $this->to = $to;
        $this->subject = "You took the third place";
        $this->msg = '
        Congratulations!<br/>
        You have taken the third place in the competition. Go back to the site to get bonuses.
        Sincerely, <br/>Nucleus team. (<a href="http://web-nucleus.com">web-nucleus.com</a>)
        ';
        break;

      case 7:
        $this->to = $to;
        $this->subject = "Restoring access to the page";
        $this->msg = "
        Hi!<br/>
        Your new temporary password: {$_SESSION['new_password']}<br/>
        Sincerely, <br/>Nucleus team.
        ";
        $this->send();
        break;
    }
  }

  public function send() {
    $this->headers  = 'MIME-Version: 1.0' . "\r\n";
    $this->headers .= "Content-type: text/html; charset=UTF-8 \r\n";
    $this->headers .= "From: <support@web-nucleus.com>";

    $res = mail($this->to, $this->subject, $this->msg, $this->headers);
  }
}
