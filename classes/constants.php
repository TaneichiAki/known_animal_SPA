<?php
class Constants {
	//ルートディレクトリのURL
	const ROOT_URL = "/~testaki";
	//アプリログパス
	const LOGPATH = "/home/testaki/logs/knownanimal.log";
	//共通パス
	const BASEPATH = Self::ROOT_URL."/known_animal_SPA";
	//login.phpのURL
	const LOGIN_URL = Self::BASEPATH."/login/login.php";
	//top.phpのURL
	const TOP_URL = Self::BASEPATH."/top/top.php";
	//delete.phpのURL
	const DELETE_URL = Self::BASEPATH."/delete/delete.php";
	//edit.phpのURL
	const EDIT_URL = Self::BASEPATH."/animal_edit/edit.php";
	//entry.phpのURL
	const ENTRY_URL = Self::BASEPATH."/animal_entry/entry.php";
	//pass_change.phpのURL
	const PASS_CHANGE_URL = Self::BASEPATH."/user_edit/pass_change.php";
	//user_edit.phpのURL
	const USER_EDIT_URL = Self::BASEPATH."/user_edit/user_edit.php";
	//new_account_done.phpのURL
	const NEW_ACCOUNT_DONE_URL = Self::BASEPATH."/new_account/new_account_done.php";
	//new_account.phpのURL
	const NEW_ACCOUNT_URL = Self::BASEPATH."/new_account/new_account.php";
	//pass_forget.phpのURL
	const PASS_FORGET_URL = Self::BASEPATH."/pass_forget/pass_forget.php";
	//サーバー上の動物の写真の登録フォルダ
	const ANIMAL_PHOTO_SERVER = "/home/testaki/animal_photo/";


}
?>
