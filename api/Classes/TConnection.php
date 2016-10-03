<?php
final class TConnection{

  private function __construct() {}

  public static function open(){
    $host   = "mysql.empregosmanaus.com.br";
    $user   = "empregosmanaus01";
    $pass   = "gf30n43ta405webvty";
    $dbname = "empregosmanaus01";

    $conn = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass, array(
      PDO::ATTR_PERSISTENT => true,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  }
}
