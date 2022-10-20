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
    $file = Constants::ANIMAL_PHOTO_SERVER.$_GET['imgNo'].'_animal.jpg';
    if(!file_exists($file)){
      $file = '/home/testaki/animal_photo/no_image.jpeg';
    }

    //MIMEタイプの取得
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file);

    header('Content-Type: '.$mime_type);
    readfile($file);

  }catch(PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }
 ?>
