<?php
Class Conn
{
  private static $instance= null;

  private function __construct () {
    $this->conncetion =new PDO('mysql:host=localhost;dbname=vezbaIT','newuser','');



}
  public static function getInstance () {
      if (!self::$instance) {
        self::$instance = new Conn;
      }
     return self::$instance;
  }
}
