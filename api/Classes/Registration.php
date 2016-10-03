<?php
class Registration{

    private static $_table = "inscricao";
    public $inscricao_id;
    public $rowCountSubscribeModality;

    public $fk_participante_id;

    public function __construct(){}

    public function create($data){
        try {
            TTransaction::open();
            $conn = TTransaction::get();
                $sql = " INSERT INTO  ".self::$_table." (participante_id, data, participou_anterior)
                VALUES (:participante_id, :data, :participou_anterior)";

                $insert = $conn->prepare($sql);
                $insert->bindValue(':participante_id',$this->fk_participante_id);
                $insert->bindValue(':data',time());
                $insert->bindValue(':participou_anterior',$data['participou_anterior']);
                $insert->execute();
                $this->inscricao_id = $conn->lastInsertId();

            TTransaction::close();
        } catch (Exception $e) {
            TTransaction::rollback();
            return $e;
        }
    }

    public function subscribeModality($data){
        try {
            TTransaction::open();
            $conn = TTransaction::get();
                $sql = " INSERT INTO inscricao_has_modalidade (inscricao_id, competicao_has_modalidade_id) VALUES (:inscricao_id, :competicao_has_modalidade_id) ";
                $insert = $conn->prepare($sql);
                $insert->bindValue(':inscricao_id',$data['inscricao_id']);
                $insert->bindValue(':competicao_has_modalidade_id',$data['competicao_has_modalidade_id']);
                $insert->execute();
                $this->rowCountSubscribeModality = $insert->rowCount();
            TTransaction::close();
        } catch (Exception $e) {
            TTransaction::rollback();
            return $e;
        }
    }

    public function subscribe($data){
        try {
                // Insert Participant
                $participant = new Participant;
                $participant->create($data);
                $this->fk_participante_id = $participant->participante_id;

                // Insert Registration
                $this->create($data);

                return $this->inscricao_id;

        } catch (Exception $e) {
            return $e;
        }
    }
}
