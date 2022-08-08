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
    $animal_sql = 'select no,name,family,features,date from users inner join animal on users.id = animal.memberid  where user_id = ?';
    $animals = Dao::db()->show_any_rows($animal_sql,array($_SESSION['login']));
    //var_dump($animals["data"][0]);

    //登録されている動物件数
    $count = Dao::db()->count_row($animal_sql,array($_SESSION['login']));
    //var_dump($animals['data']);
    //exit;
    if($animals["result"] == true){
        $response = array(
          "result"=>true,
          "data"=>array($animals['data'])
        );
        echo json_encode($response);
    }else{
      $response = array(
        "result"=>false
      );
      echo json_encode($response);
    }
  }catch(PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }

 ?>
