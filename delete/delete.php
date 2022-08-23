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
		$delete_sql = 'delete from animal where no = ?';
		$delete_animal = Dao::db()->mod_exec($delete_sql,array($_REQUEST['delete_animal']));

    if($delete_animal["result"] == true){
        $response = array(
          "result"=>true
        );
        echo json_encode($response);
				//登録していた画像ファイルを削除
				unlink(Constants::ANIMAL_PHOTO_SERVER.$_REQUEST['delete_animal'].'_animal.jpg' );
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
