<?php

class Participant {

    private static $_table = "participante";

    public $participante_id;

    public function __construct(){}

    /**
     * @name create
     * @param  [Array] $data
     */
    public function create($data){
        try {
            TTransaction::open();
            $conn = TTransaction::get();
                $sql = " INSERT INTO ".self::$_table." (nome, sobrenome, email, senha) VALUES (:nome, :sobrenome, :email, :senha) ";
                $insert = $conn->prepare($sql);

                $insert->bindValue(':nome',$data['nome']);
                $insert->bindValue(':sobrenome',$data['sobrenome']);
                $insert->bindValue(':email',$data['email']);
                $insert->bindValue(':senha','123');
                $insert->execute();

                $this->participante_id = $conn->lastInsertId();
            TTransaction::close();
        } catch (Exception $e) {
            return $e;
            TTransaction::rollback();
        }
    }
}
