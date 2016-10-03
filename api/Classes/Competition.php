<?php

class Competition {

    public $result;
    private static $_table = "competicao";

    public function __construct(){}

    public function fetchCompetitionActive(){
        try {
            TTransaction::open();
            $conn = TTransaction::get();

            $select = $conn->prepare("
                SELECT * FROM ".self::$_table." AS c
                JOIN homenagiado AS h ON h.homenagiado_id = c.homenagiado_id
                WHERE c.status = 'ativo'
                ORDER BY c.competicao_id DESC LIMIT 1");
            $select->execute();
            $this->result = $select->fetch(PDO::FETCH_ASSOC);

            TTransaction::close();
        } catch (Exception $e) {
            return $e;
            TTransaction::rollback();
        }
    }

    public function subscribe($id){
        try {
            $conn = TTransaction::get();
            $select = $conn->prepare("
                SELECT
                im.inscricao_id,
                i.participante_id,
                p.nome
                FROM inscricao_has_modalidade AS im
                JOIN inscricao AS i ON i.inscricao_id = im.inscricao_id
                JOIN participante AS p ON p.participante_id = i.participante_id
                WHERE im.competicao_has_modalidade_id = ".$id);
            $select->execute();
            return $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fetchModalityId($id){
        try {
            $conn = TTransaction::get();
            $select = $conn->prepare("
                SELECT
                m.nome AS nome,
                c.competicao_has_modalidade_id AS compet_mod_id
                FROM competicao_has_modalidade AS c
                JOIN modalidade AS m ON c.fk_modalidade_id = m.modalidade_id
                WHERE c.fk_competicao_id = $id ");
            $select->execute();
            $parents = $select->fetchAll(PDO::FETCH_ASSOC);

            $temp = [];

            foreach ($parents as $parent ) {

                $temp['nome'] = $parent['nome'];
                $temp['inscricao'] = $this->subscribe($parent['compet_mod_id']);



                $result[] = $temp;

            }
            return $result;
        } catch (Exception $e) {}

    }

    public function fetchId($id){
        try {
            TTransaction::open();
            $conn = TTransaction::get();

            $select = $conn->prepare(" SELECT * FROM ".self::$_table." AS c WHERE c.competicao_id = $id ");
            $select->execute();
            $data = $select->fetch(PDO::FETCH_ASSOC);

            $competitions['modalidade'] = $this->fetchModalityId($data['competicao_id']);
            $competitions['competicaoId'] = $data['competicao_id'];
            $this->result = $competitions;

            TTransaction::close();
        } catch (Exception $e) {
            return $e;
            TTransaction::rollback();
        }
    }
}
