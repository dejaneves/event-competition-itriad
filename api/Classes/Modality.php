<?php

class Modality {
    public $result;

    private static $_table = "modalidade";

    public function __construct(){}

    public function modalityCompetition(){
        try {
            TTransaction::open();
            $conn = TTransaction::get();
                $sql = "
                    SELECT * FROM competicao_has_modalidade AS cm
                    JOIN modalidade AS m ON m.modalidade_id = cm.fk_modalidade_id
                    WHERE cm.fk_competicao_id = 1 ";
                $select = $conn->prepare($sql);
                $select->execute();
                $this->result = $select->fetchAll(PDO::FETCH_ASSOC);
            TTransaction::close();
        } catch (Exception $e) {
            TTransaction::rollback();
            return $e;
        }
    }


}
