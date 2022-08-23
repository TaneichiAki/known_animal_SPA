<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  session_start();
  //セッションIDがセットされていなかったらログインページに戻る
  if(! isset($_SESSION['login'])){
    $response = array(
      "s_result"=>false
    );
  }

  try{
		$update_sql = 'update animal set name = ?,family = ?,features = ?,date = ? where no = ?';
		$animal = Dao::db()->mod_exec($update_sql,array($_REQUEST['animal_name'],$_REQUEST['animal_family'],$_REQUEST['animal_features'],$_REQUEST['animal_date'],$_REQUEST['update_animal']));
		//アップロードされたファイルを一時フォルダから指定のフォルダへファイル名「（insert_id）_animal.jpg」にして移動
		move_uploaded_file($_FILES['fileupload']['tmp_name'] , Constants::ANIMAL_PHOTO_SERVER.$_REQUEST['update_animal'].'_animal.jpg' );

    if($animal["result"] == true){
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
