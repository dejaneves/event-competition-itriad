<?php
final class TConnection{

  private function __construct() {}

  public static function open(){
    $host   = "localhost";
    $user   = "root";
    $port   = "3306";
    $pass   = "qdert#2653@";
    $dbname = "triad";

    $conn = new PDO("mysql:host={$host};dbname={$dbname};port={$port}", $user, $pass, array(
      PDO::ATTR_PERSISTENT => true,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  }
}
