<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  try{
    //ログインユーザー情報
    $users_sql = 'select * from users where user_id = ?' ;
    $users = Dao::db()->show_one_row($users_sql,array('aki'));
  }catch(PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }
  echo aki;
  //echo {result:true,user:{firstname:".$users['data']['first_name'].",lastname:".$users['data']['last_name']."}};
 ?>
