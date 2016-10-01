<?php
require 'TTransaction.php';

class ActiveRecord{

    // Nome da tabela
    public static $_table = "nome_da_tabela";

    // Auto Increment
    private static $auto_increment = true;

    // Nome da coluna PK
    private static $_columns_id = "id";

    // Coluna para atualizaÃ§Ã£o (opcional).
    protected static $_columns_param = "";

    // Colunas da tabela
    private static $_columns = array();

    // lastInsertId
    private static $_lastInsetId = false;

    // Dados armazenados
    private static $_data;

    // Registro por pÃ¡gina
    public static $recordPage = 0;

    /**
    * Construtor da classe
    * @name __construct
    */
    public function __construct(){}

  /**
   * MÃ©todo para retorna os dados apÃ³s o cadastro
   * @name set_lastInsertId
   */
  public static function lastInsertId($value){
    self::$_lastInsetId = $value;
  }

  /**
   * Retorna quantidade total de registros.
   * @name countPagination
   * @return object
   */
  public static function totalRecord($paramSQL = NULL){
    try{
      TTransaction::open();
      $conn = TTransaction::get();
      $filter = "";

        if( !empty($paramSQL) )
          $filter .= $paramSQL;

        $count = $conn->query($sql=" SELECT COUNT(*) AS total FROM ".self::$_table." WHERE 1 {$filter} ")->fetch(PDO::FETCH_OBJ);

      TTransaction::close();
    } catch(PDOException $e){
      TTransaction::rollback();
    }
    return $count;
  }

  /**
   * Insere os registros.
   * @name insert
   * @param  array $data = Dados para serem armazenados no BD.
   * @return result
   */
  public static function insert($dados){
    try{
      TTransaction::open();
      $conn = TTransaction::get();

        self::$_data["success"] = false;

        if( self::$auto_increment == false )
          $dados['id'] = self::getLast() + 1;

        $columnKeys = count(self::$_columns) > 0 ? self::$_columns : array_keys($dados);

        $sql = " INSERT INTO " . self::$_table." ( ". implode(", ", $columnKeys) ." ) VALUES ( :".implode(", :", $columnKeys).")";

        $insert = $conn->prepare($sql);
        foreach($columnKeys as $column){
          $insert->bindValue(":".$column,$dados[$column]);
        }

        // Executa
        self::$_data["success"] = $insert->execute();
        self::$_data["rowCount"] = $insert->rowCount();

        if( self::$_lastInsetId == true )
          self::$_data["lastInsertId"] = $conn->lastInsertId();

      TTransaction::close();
    }catch(PDOException $e){
      self::$_data["erro"] = $e->getMessage();
      TTransaction::rollback();
    }

    return self::$_data;
  }

  /**
   * Atualiza os registros.
   * @name update
   * @param  array $dados = Dados para atualizaÃ§Ã£o
   * @return array
   */
  public static function update($dados){
    try{
     TTransaction::open();
     $conn = TTransaction::get();

      self::$_data["success"] = false;

      if(!$dados["id"])
        throw new InvalidArgumentException("Informe o id para atualizaÃ§Ã£o");

      $clone = $dados;

      // Verifica se a chave id existe no array.
      if (array_key_exists("id", $dados)){

        unset($dados["id"]);

        $sql = " UPDATE " . self::$_table." SET ";

        foreach ($dados as $chave => $valor){
          // Verifica a Ãºltima chave do array e armazena no $endKey.
          $endKey = end(array_keys($dados));
          $virgula = $endKey != $chave ? ", " : "";

          // Monta (chave = :chave) sem o id.
          $sql .= $chave." = :".$chave.$virgula;
        }

        // Coluna referencia para atualizaÃ§Ã£o.
        $_column = !empty(self::$_columns_param) ? self::$_columns_param : self::$_columns_id;

        $sql .= " WHERE ".$_column." = :id ";
        $update = $conn->prepare($sql);

        // Insere os valores
        foreach($clone as $chave => $valor){
          $update->bindValue(":".$chave,$clone[$chave]);
        }

      }// fim array_key_exists

      self::$_data["success"] = $update->execute();
      self::$_data["rowCount"] = $update->rowCount();

      TTransaction::close();
    } catch(PDOException $e){
      self::$_data["msg"] = $e->getMessage();
    }
    return self::$_data;
  }

  /**
   * Deleta um registro do BD.
   * @name delete
   * @param  int $id = ID para ser removido do BD.
   * @return array
   */
  public static function delete($id){
    try{
      TTransaction::open();
      $conn = TTransaction::get();
        self::$_data["success"] = false;

        if(!$id)
          throw new Exception(" Informe o id para exclusÃ£o ");

        $delete = $conn->prepare(" DELETE FROM ".self::$_table." WHERE id = :id ");
        $delete->bindValue(":id",$id);

        //Executa
        self::$_data["success"] = $delete->execute();
        self::$_data["rowCount"] = $delete->rowCount();

      TTransaction::close();
    } catch(PDOException $e){
      $result["erro"] = $e->getMessage();
      TTransaction::rollback();
    }

    return self::$_data;
  }

	/**
	 * Retorna os dados, passando o ID por parametro.
	 * @param   $filter["id"]      Int = Ã‰ obrigatÃ³rio.
   * @param   $filter["columns"] String.
   * @param   $filter["join"]    String.
   * @param   $filter["where"]   String.
   * @param   $filter["and"]     String.
	 * @return array
	 */
	public static function find($filter = array()){
		try{
     TTransaction::open();
     $conn = TTransaction::get();

      //if(!$filter['id'])
      	//throw new Exception("Informe um ID para consulta");

      $filter["columns"]  = !empty($filter["columns"])  ? $filter["columns"]  : " * ";
      $filter["join"]     = !empty($filter["join"])     ? $filter["join"]     : NULL;
      $filter["where"]    = !empty($filter["where"])    ? $filter["where"]    : " WHERE id = :id ";
      $filter["and"]      = !empty($filter["and"])      ? $filter["and"]      : NULL;

      $select = $conn->prepare(" SELECT ".$filter["columns"]." FROM ".self::$_table." ".$filter["join"]." ".$filter["where"]." ".$filter["and"]);
      if( !empty($filter['id']) )
        $select->bindValue(":id",$filter['id']);

      $select->execute();
      $dados = $select->fetch(PDO::FETCH_ASSOC);

      TTransaction::close();
    } catch(PDOException $e){
      $dados["error"] = $e->getMessage();
      TTransaction::rollback();
    }
    return $dados;
	}

	/**
	 * Retorna todos os dados da tabela.
	 * @name findAll
	 * @return object
	 */
	public static function findAll($filter = array()){
		try{
     TTransaction::open();
     $conn = TTransaction::get();

      $limit = "";

      $filter["columns"]  = !empty($filter["columns"])  ? $filter["columns"] : " * ";
      $filter["join"]     = !empty($filter["join"])     ? $filter["join"] : NULL;
      $filter["where"]    = !empty($filter["where"])    ? $filter["where"] : " WHERE 1 ";
      $filter["and"]      = !empty($filter["and"])      ? $filter["and"] : NULL;
      $filter["order"]    = !empty($filter["order"])    ? $filter["order"] : ' ORDER BY id DESC ';

      /**
       * Caso o usuario, informa uma quantidade de registro entra na condiÃ§Ã£o.
       */
      if( !empty(self::$recordPage) ){

        // Quantidade total de registros.
        $record = self::totalRecord();

        // Total de pÃ¡ginas.
        $pageTotal  = ceil( $record->total / self::$recordPage);

        $limit_OFFSET = ($filter["pagina"] - 1) * self::$recordPage;

        $limit = $filter["order"]." LIMIT ".self::$recordPage." OFFSET ".$limit_OFFSET;
      }

      // Executa SQL
      $select = $conn->prepare($sql=" SELECT ".$filter["columns"]." FROM ".self::$_table." ".$filter["join"]." ".$filter["where"]." ".$filter["and"]." ".$limit);
      $select->execute();
      $dados = $select->fetchAll(PDO::FETCH_ASSOC);

      // NÃºmero total de pÃ¡gina de acordo com a quantidade setada na variÃ¡vel self::$recordPage.
      if( isset($pageTotal) )
        $dados["pageTotal"] = $pageTotal;

      TTransaction::close();
    } catch(PDOException $e){
      $dados["error"] = $e->getMessage();
    }
    return $dados;
	}

}// fim class
