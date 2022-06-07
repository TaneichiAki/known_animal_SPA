<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  session_start();
  //セッションIDがセットされていなかったらログインページに戻る
  if(! isset($_SESSION['login'])){
    $response = array(
      "s_result"=>false
    );
    //echo json_encode($response);
    //exit;
  }

  try{
    //データベースに接続し、テーブルに登録されているユーザーの知ってる動物データを抽出
    $animal_sql = 'select name,family,features,date from users inner join animal on users.id = animal.memberid  where user_id = ?';
    $animals = Dao::db()->show_any_rows($animal_sql,array('aki'));
    //var_dump($animals["data"][0]);

    //登録されている動物件数
    $count = Dao::db()->count_row($animal_sql,array('aki'));
    //var_dump($count);

    if($animals["result"] == true){
        $response = array($animals['data']);
        echo json_encode($animals['data']);
    }
    exit;
    //ログインユーザー情報
    $users_sql = 'select * from users where user_id = ?';
    $users = Dao::db()->show_one_row($users_sql,array($_SESSION['login']));
    if($users["result"] == true){
      $response = array(
        "l_result"=>true,
        "user"=>array(
          "firstname"=>$users['data']['first_name'],
          "lastname"=>$users['data']['last_name']
        )
      );
      echo json_encode($response);
    }else{
      $response = array(
        "l_result"=>false,
        "message"=>"ユーザー情報を取得できませんでした"
      );
      //echo $response;
      echo json_encode($response);
    }
  }catch(PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }

 ?>
