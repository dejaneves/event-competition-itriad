<?php

class Login{

  public $result;
  public function __construct(){}

  public function register($data){
    try {
      TTransaction::open();
      $conn = TTransaction::get();

        $select = $conn->prepare("SELECT email FROM admin WHERE email = :email");
        $select->bindValue(':email',$data['email']);
        $select->execute();

        if($select->fetch(PDO::FETCH_ASSOC)){
          $user['checkEmail'] = true;
          $user['checkPassword'] = false;

          $selectPassword = $conn->prepare("SELECT admin_id, name, email FROM admin WHERE password = :password");
          $selectPassword->bindValue(':password',$data['password']);
          $selectPassword->execute();
          $userData = $selectPassword->fetch(PDO::FETCH_ASSOC);
          if($userData){
            $user['data'] = $userData;
            $user['success'] = true;
            $user['checkPassword'] = true;

            // $user['sessionState'] = session_start();
            // $_SESSION['name']   = $userData['name'];
            // $_SESSION['email']  = $userData['email'];

            $session = Session::getInstance();
            $session->name = $userData['name'];
            $session->email = $userData['email'];
            $session->id = $userData['admin_id'];
            //$user['session'] = $_SESSION;
          }
          $result['user'] = $user;
          $this->result = $result;
        } else {
          $user['success'] = false;
          $result['user'] = $user;
          $this->result = $result;
        }
      TTransaction::close();
    } catch (Exception $e) {
      TTransaction::rollback();
      return $e;
    }
  }

}
