<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  session_start();
  //セッションIDがセットされていなかったらログインページに戻る
  if(! isset($_SESSION['login'])){
    //$response = array(
      //"s_result"=>false
    //);
    //echo json_encode($response);
    http_response_code(401);

  }

  try{
    //ログインユーザー情報
    $users_sql = 'select * from users where user_id = ?';
    $users = Dao::db()->show_one_row($users_sql,array($_SESSION['login']));
    if($users["result"] == true){
      $response = array(
        "result"=>true,
        "user"=>array(
          "firstname"=>$users['data']['first_name'],
          "lastname"=>$users['data']['last_name']
        )
      );
      echo json_encode($response);
    }else{
      $response = array(
        "result"=>false
      );
      //echo $response;
      echo json_encode($response);
    }
  }catch(PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }

 ?>
