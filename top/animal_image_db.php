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
    $filename = Constants::ANIMAL_PHOTO_SERVER.$_GET['imgNo'].'_animal.jpg';
    if(file_exists($filename)){
      $response = array(
        "result"=>true
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
