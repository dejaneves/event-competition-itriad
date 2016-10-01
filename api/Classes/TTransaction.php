<?php
include_once('TConnection.php');

final class TTransaction {

    private static $conn;
    private static $logger;

    private function __construct() {}

    public static function open(){
        // abre uma conexão e armazena na propriedade estática $conn
        if (empty(self::$conn)){
            self::$conn = TConnection::open();
            // inicia a transação
            self::$conn->beginTransaction();
            // desliga o log de SQL
            self::$logger = NULL;
        }
    }

    public static function get(){
        return self::$conn;
    }

    public static function rollback(){
        if (self::$conn){
            self::$conn->rollback();
            self::$conn = NULL;
        }
    }

    public static function close() {
        if (self::$conn){
            self::$conn->commit();
            self::$conn = NULL;
        }
    }
}
