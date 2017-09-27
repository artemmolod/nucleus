<?php
namespace Nucleus;

interface EmailNotification {
  public  function __construct($notificationType);
  private function initNotification();
  private function sendNotification();
}

class EmailNotification implements EmailNotification {

  private $email;
  private $type;

  public function __construct($notificationType) {}

  private function initNotification() {}

  private function sendNotification() {}

}
