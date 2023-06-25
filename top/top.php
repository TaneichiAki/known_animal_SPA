<?php
		require_once(__DIR__."/../classes/Dao.php");
		require_once(__DIR__."/../classes/constants.php");
		session_start();
		//ログアウトボタン押下後、セッションIDを削除する
		if( !empty($_GET['btn_logout']) ) {
			unset($_SESSION['login']);
		}

		//セッションIDがセットされていなかったらログインページに戻る
		if(! isset($_SESSION['login'])){
			header("Location:".Constants::LOGIN_URL);
			exit();
		}

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<!-- Required meta tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="./top.css">
		<link rel="stylesheet" type="text/css" href="../css/common.css">
		<title>TOP</title>
	</head>
	<body>

		<section id="modal" class="__modal__area hidden">
			<div id="modal_bg" class="__modal__bg"></div>
			<div class="__modal__wrapper">
				<div class="__modal__contents">
					<div class="row">
						<div id="modal_title" class="col-12 p-2 text-center"></div>
							<div id="animal_modal" class="hidden">
								<form method="post" id="uploadForm">
									<div class="col-12 p-2 text-center">
										<input class="form-control" id="animal_name" type="text" name="animal_name" placeholder="動物の名称">
									</div>
									<div class="col-12 p-2 text-center">
										<input class="form-control" id="animal_family" type="text" name="animal_family" placeholder="何科">
									</div>
									<div class="col-12 p-2 text-center">
										<input class="form-control" id="animal_features" type="text" name="animal_features" placeholder="特徴">
									</div>
									<div class="col-12 p-2 text-center">
										<input class="form-control" id="animal_date" type="date" name="animal_date" placeholder="知った日">
									</div>
									<div class="col-12 p-2 text-center">
										<input class="form-control" id ="fileup" type="file" name="fileupload">
									</div>
								</form>
							</div>
							<div id="user_modal" class="hidden">
								<form method="post" id="userForm">
									<div class="col-12 mt-3 p-2 hidden" id="old_pass_div">
										<label class="form-label mb-2" id="old_pass_label" for="old_pass" class="control-label">現在のパスワード:</label>
										<input type="password" class="form-control" id="old_pass" name="old_pass">
									</div>
									<div class="col-12 mt-3 p-2">
										<label class="form-label mb-2" id="user_label" for="user_edit" class="control-label"></label>
										<input class="form-control" id="user_edit" name="user_up">
										<p id="mail_comment" class="mt-3　mb-3 hidden">※更新ボタンクリック後、上記アドレスに変更完了メールが送信されます。</p>
									</div>
									<div class="col-12 mt-3 p-2 hidden"  id="re_new_pass_div">
										<label class="form-label mb-2" id="re_new_pass_label" for="re_new_pass" class="control-label">新しいパスワード（再）:</label>
										<input type="password" class="form-control" id="re_new_pass" name="re_new_pass" placeholder="もう一度入力してください">
										<p class="mt-3 mb-3 text-center">※パスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上にしてください。</p>
									</div>
								</form>
							</div>
					</div>
					<div class="__modal__buttons">
						<button id="close" class="__modal__button __modal__close__btn">閉じる</botton>
						<button id="md_entry" class="__modal__button __modal__exec__btn"></botton>
					</div>
				</div>
			</div>
		</section>

		<div class="container-fluid">
			<div class="row mb-2">
			<header>
				<!-- ナビゲーションバー -->
				<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
				  <!-- タイトル -->
				  <a class="navbar-brand" href="#">
						<img src="../image/KnownAnimalLogo.png" width="180" height="auto" class="d-inline-block align-top" alt="">
					</a>
				  <!-- ハンバーガーメニュー -->
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <!-- ナビゲーションメニュー -->
				 <!--
				 <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav">
				      <li class="nav-item active">
				        <a class="nav-link" id="entry">新規登録</a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link" href='<?php echo Constants::USER_EDIT_URL?>'>ユーザー情報の編集</a>
				      </li>
						</ul>
					</div>
				-->
								<form name="logout" class="logout" method="get" action="">
									<button type="button" class="btn btn-primary" id="logout">ログアウト</button>
									<input type="hidden" id="hidden" name="btn_logout" value="ログアウト">
								 </form>
								 <script>
								  var a_link = document.getElementById("logout");

								  a_link.addEventListener('click', function() {
								    //submit()でフォームの内容を送信
								    document.logout.submit();
								  })
									console.dir(document.getElementById("hidden"));
								</script>
				</nav>
			</header>
			</div>
			<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	 		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	 		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

			<div class="row mt-5 mb-2">
				<div class="offset-sm-10 col-sm-2">
				<br>
				<p class="account">
				</p>
				</div>
			</div>
			<div class="row" id="navbarNav">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a  href="#contents1" id="top_tab" class="nav-link active" data-toggle="tab">TOP</a>
					</li>
					<li class="nav-item">
						<a  href="#contents2" id="user_edit_tab" class="nav-link" data-toggle="tab" href='<?php echo Constants::USER_EDIT_URL?>'>ユーザー情報の編集</a>
					</li>
				</ul>
			</div>
			<div class="tab-content">
	    	<div id="contents1" class="tab-pane active">
					<div class="row mt-5 mb-5">
						<button type="button" class="btn btn-primary offset-10 col-1" id="entry">新規登録</button>
					</div>
					<div class="row">
						<div class="card-group" id="loop">
						</div>
					</div>
				</div>
				<div id="contents2" class="tab-pane">
					<div class="row">
						<div class="offset-1 col-10 offset-md-3 col-md-6 text-center mt-3">
							<h4>ユーザー情報</h4>
						</div>
					</div>
						<div class="table-responsive col-12 offset-md-3 col-md-6 text-center mt-3 mb-3">
						<table class="table table-sm table-striped table-bordered">
							<thead>
							<tr class="bg-secondary text-white">
								<th style="width: 20%">項目</th>
								<th style="width: 60%">登録データ</th>
								<th style="width: 20%"></th>
							</tr>
						</thead>
							<tr>
								<th>会員番号</th>
								<td id="id">
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<th>ユーザーID</th>
								<td id="user_id">
								</td>
								<td>
								</td>
							 </tr>
							 <tr>
								<th>姓</th>
								<td id="last_name">
								</td>
								<td>
									<button id="last_name_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
								</td>
								</tr>
								<tr>
									<th>名</th>
									<td id="first_name">
									</td>
									<td>
										<button id="first_name_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
									</td>
								</tr>
								<tr>
									<th>部署</th>
									<td id="department">
									</td>
									<td>
										<button id="department_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
									</td>
								</tr>
								<tr>
									<th>役職</th>
									<td id="post">
									</td>
									<td>
										<button id="post_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
									</td>
								</tr>
								<tr>
									<th>生年月日</th>
									<td id="birth">
									</td>
									<td>
										<button id="birth_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
									</td>
								</tr>
								<tr>
									<th>メールアドレス</th>
									<td id="mail">
									</td>
									<td>
										<button id="mail_btn" class="btn btn-primary btn-sm user_info" type="button">変更</button>
									</td>
								</tr>
								<tr>
									<th>パスワード</th>
									<td id="pass">
										<?php
											echo '********';
										?>
									</td>
									<td>
										<button id="pass_btn" class="btn btn-primary btn-sm user_info"　type="button">変更</button>
									</td>
								</tr>
						</table>
				</div>
				</div>
			</div>
		</div>
		<script type="module">
			import { WebApi,LoadingCircle,Modal } from "../js/common.js";
			const lc = new LoadingCircle({});

			const top = (() => {
				/**
				*ユーザー情報取得
				*/
				async function user_get(){
					try{
						const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/user_db.php","GET");
						let response = JSON.parse(result);

						if(response.result !== true){
							window.location.href = '/~testaki/known_animal_SPA/login/login.php';
							return false;
						}
							document.getElementsByClassName('account')[0].textContent = 'ようこそ！'+ response.data[0].first_name + 'さん';
							document.getElementById('id').textContent = response.data[0].id;
							document.getElementById('user_id').textContent = response.data[0].user_id;
							document.getElementById('last_name').textContent = response.data[0].last_name;
							document.getElementById('first_name').textContent = response.data[0].first_name;
							document.getElementById('department').textContent = response.data[0].department;
							document.getElementById('post').textContent = response.data[0].post;
							document.getElementById('birth').textContent = response.data[0].birth;
							document.getElementById('mail').textContent = response.data[0].mail;

					}catch(e){
							let err = e;
					}
				}
				/**
				*ユーザー情報一部取得
				*/
				async function part_of_user_get(e) {
					try{
						let edit_target = e.target.id;
						const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/user_db.php","GET");
						let response = JSON.parse(result);
						let user_edit = document.getElementById("user_edit");
						let user_label = document.getElementById("user_label");

						switch(edit_target){
							case "last_name_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("placeholder","新しい姓");
								user_edit.setAttribute("type","text");
								user_edit.setAttribute("edit_info","last_name");
								user_edit.value = response.data[0].last_name;
								user_label.textContent = "新しい姓:";
								break;

							case "first_name_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("placeholder","新しい名");
								user_edit.setAttribute("type","text");
								user_edit.setAttribute("edit_info","first_name");
								user_edit.value = response.data[0].first_name;
								user_label.textContent = "新しい名:";
								break;

							case "department_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("placeholder","新しい部署名");
								user_edit.setAttribute("type","text");
								user_edit.setAttribute("edit_info","department");
								user_edit.value = response.data[0].department;
								user_label.textContent = "新しい部署名:";
								break;
							case "post_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("type","text");
								user_edit.setAttribute("placeholder","新しい役職名");
								user_edit.setAttribute("edit_info","post");
								user_edit.value = response.data[0].post;
								user_label.textContent = "新しい役職名:";
								break;

							case "birth_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("type","date");
								user_edit.setAttribute("placeholder","新しい生年月日");
								user_edit.setAttribute("edit_info","birth");
								user_edit.value = response.data[0].birth;
								user_label.textContent = "新しい生年月日:";
								break;

 							case "mail_btn":
								modal_title.textContent = "ユーザー情報の編集";
								user_edit.setAttribute("type","email");
								user_edit.setAttribute("placeholder","新しいメールアドレス");
								user_edit.setAttribute("edit_info","mail");
								user_edit.value = response.data[0].mail;
								user_label.textContent = "新しいメールアドレス:";
								document.getElementById("mail_comment").classList.remove("hidden");
								break;

							case "pass_btn":
								modal_title.textContent = "パスワード変更";
								user_edit.setAttribute("type","password");
								user_edit.placeholder = "";
								user_edit.setAttribute("edit_info","pass");
								user_edit.value = "";
								user_label.textContent = "新しいパスワード:";
								document.getElementById("old_pass_div").classList.remove("hidden");
								document.getElementById("re_new_pass_div").classList.remove("hidden");
								break;

							}
						}catch(e){
							let err = e;
						}
				}

				function pass_check() {
					let new_pass = document.getElementById('user_edit');
					let re_new_pass = document.getElementById('re_new_pass');
					let msg = "";
					if(document.getElementById('old_pass').value == "") {
						msg = '現在のパスワードを入力してください。';
					}
					if(new_pass.value == "") {
						msg = msg + '\n新しいパスワードを入力してください。';
					}
					if(re_new_pass.value == "") {
						msg = msg + '\n新しいパスワード（再）を入力してください。';
					}
					if(new_pass.value != re_new_pass.value) {
						msg = msg + '\n１回目と２回目で新しいパスワードが一致しません。'
					}
					if(msg != "") {
						return msg;
					}else{
						return "";
					}
				}

				async function pass_change_done() {
					let msg = pass_check();
					if(msg != "") {
						alert(msg);
					}else{
						const url = '../user_edit/pass_change.php';
						const method = 'POST';
						const formdata = new FormData(document.getElementById("userForm"));
						const pass_result = await new WebApi({}).call(url,method,formdata);
						let response = JSON.parse(pass_result);
						if(response.result === "old_pass_false") {
							alert("現在のパスワードが正しくありません。");
						}else if(response.result === "pass_pattern_false") {
							alert("新しいパスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上のパスワードにしてください。");
						}else if(response.result === true){
							alert("更新しました！");
							// キャッシュを無視してサーバーからリロード
							window.location.reload(true);
						}else{
							alert('エラーが発生したため、更新できませんでした。');
						}
					}
				}

				function user_edit_check() {
					let msg = "";
					if(document.getElementById('user_edit').value == ""){
						msg = '更新後の内容を入力してください。';
					}
					if(msg != "") {
						return msg;
					}else{
						return "";
					}
				}

				async function user_edit_done() {
					let msg = user_edit_check();
					if(msg != "") {
						alert(msg);
					}else{
						let edit_info = document.getElementById("user_edit").getAttribute("edit_info");
						const url = '../user_edit/user_info_edit.php?update_info=' + edit_info;
						const method = 'POST';
						const formdata = new FormData(document.getElementById("userForm"));
						const edit_result = await new WebApi({}).call(url,method,formdata);
						let response = JSON.parse(edit_result);
						if(response.result === true){
							alert("更新しました！");
							// キャッシュを無視してサーバーからリロード
							window.location.reload(true);
						}else if(response.result === "mail_true"){
							alert("登録したメールアドレスに登録完了のメールを送りました。\nメールの受信をご確認ください。");
							// キャッシュを無視してサーバーからリロード
							window.location.reload(true);
						}else if(response.result === "mail_false"){
							alert("メール送信失敗です");
						}else{
							alert('エラーが発生したため、更新できませんでした。');
						}
					}
				}

				async function all_animals_get(){
					const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/animal_db.php","GET");
					let response = JSON.parse(result);
					if(response.result === true){
						let animal_count = response.data[0].length;

						let loop = document.getElementById('loop');
						for(let i=0; i<animal_count; i++){
							let newElement = document.createElement("div"); // div要素作成
							newElement.classList.add('col-sm-3');//クラス属性追加
	  					loop.appendChild(newElement);

							let newElement2 = document.createElement("div"); // div要素作成
							newElement2.classList.add('card');//クラス属性追加
							newElement.appendChild(newElement2);
							newElement2.setAttribute("animal_no",response.data[0][i].no);
							let newElement_img = document.createElement("img");


							newElement_img.setAttribute("src","animal_image_db.php?imgNo="+response.data[0][i].no);
							newElement_img.classList.add('card-img-top');
							//newElement_img.setAttribute("width","100%");
							//newElement_img.setAttribute("object-fit","cover");
							newElement2.appendChild(newElement_img);

							let newElement3 = document.createElement("div"); // div要素作成
							newElement3.classList.add('card-body');//クラス属性追加
							newElement2.appendChild(newElement3);

							let newElement4 = document.createElement("h5"); // div要素作成
							newElement4.classList.add('card-title');//クラス属性追加
							newElement4.textContent = response.data[0][i].name;
							newElement3.appendChild(newElement4);

							let newElement_p = document.createElement("p"); // div要素作成
							newElement_p.textContent = "科：" + response.data[0][i].family;
							newElement3.appendChild(newElement_p);

							let newElement_p2 = document.createElement("p"); // div要素作成
							newElement_p2.textContent = "特徴：" + response.data[0][i].features;
							newElement3.appendChild(newElement_p2);

							let newElement_p3 = document.createElement("p"); // div要素作成
							newElement_p3.textContent = "知った日：" + response.data[0][i].date;
							newElement3.appendChild(newElement_p3);

							let newElement_bt_e = document.createElement("button"); // div要素作成
							newElement_bt_e.textContent = "更新";
							newElement_bt_e.classList.add("btn","btn-primary","edit");//クラス属性追加
							newElement_bt_e.setAttribute("type","button");
							newElement_bt_e.setAttribute("id","edit" + response.data[0][i].no);
							newElement3.appendChild(newElement_bt_e);

							let newElement_bt_d = document.createElement("button"); // div要素作成
							newElement_bt_d.textContent = "削除";
							newElement_bt_d.classList.add("btn","btn-primary","delete");//クラス属性追加
							newElement_bt_d.setAttribute("type","button");
							//newElement_bt_d.setAttribute("onclick","window.open('/~testaki/known_animal_SPA/delete/delete.php?delete_animal="+ response.data[0][i].no +"','Delete','width=800,height=600')");
							newElement3.appendChild(newElement_bt_d);
						}

					}else{
						alert('まだ動物データは登録されていません');
					}
				}

				function entry() {
					md_entry.textContent = "登録";
					modal_title.textContent = "新規登録";
					let animal_name = document.getElementById("animal_name");
					let animal_family = document.getElementById("animal_family");
					let animal_features = document.getElementById("animal_features");
					let animal_date = document.getElementById("animal_date");

					animal_name.value = "";
					animal_family.value = "";
					animal_features.value = "";
					animal_date.value = "";

					animal_name.readOnly = false;
					animal_family.readOnly = false;
					animal_features.readOnly = false;
					animal_date.readOnly = false;

					animal_modal.classList.remove("hidden");
					modal.classList.remove("hidden");
				}

				function check() {
					let msg = "";
					if(document.getElementById('animal_name').value == ""){
						msg = '動物の名称を入力してください。';
					}
					if(document.getElementById('animal_family').value == ""){
						msg =　msg + '\n何科か入力してください。';
					}
					if(document.getElementById('animal_features').value == ""){
						msg =　msg + '\n特徴を入力してください。';
					}
					if(document.getElementById('animal_date').value == ""){
						msg =　msg + '\n知った日を入力してください。';
					}
					if(fileup.value != ""){
						const allowExtensions = '.(jpeg|jpg|png|bmp|gif)$'; // 許可する拡張子
						if(fileup.value.match(allowExtensions) == null){
							msg = msg + '\n拡張子が jpeg, jpg, png, bmp, gif 以外のファイルはアップロードできません。';
						}
					}
					if(msg != "") {
						return msg;
					}else{
						return "";
					}
				}

				async function entry_done() {
						let msg = check();
						if(msg != "") {
							alert(msg);
						}else{
							const url = '../animal_entry/entry.php';
							const method = 'POST';
							const formdata = new FormData(document.getElementById("uploadForm"));
							const entry_result = await new WebApi({}).call(url,method,formdata);
							let response = JSON.parse(entry_result);
							if(response.result === true){
								alert("登録しました！")
								// キャッシュを無視してサーバーからリロード
								window.location.reload(true);
							}else{
								alert('エラーが発生したため、登録できませんでした。');
							}
						}
					}

				async function edit_done() {
						let msg = check();
						if(msg != "") {
							alert(msg);
						}else{
							let select_a_no = document.getElementById("animal_name").getAttribute("animal_no");

							const url = '../animal_edit/edit.php?update_animal=' + select_a_no;
							const method = 'POST';
							const formdata = new FormData(document.getElementById("uploadForm"));
							const edit_result = await new WebApi({}).call(url,method,formdata);
							let response = JSON.parse(edit_result);
							if(response.result === true){
								alert("更新しました！")
								// キャッシュを無視してサーバーからリロード
								window.location.reload(true);
							}else{
								alert('エラーが発生したため、更新できませんでした。');
							}
						}
				}

				async function delete_done() {
					let select_a_no = document.getElementById("animal_name").getAttribute("animal_no");

					const url = '../delete/delete.php?delete_animal=' + select_a_no;
					const method = 'GET';
					const delete_result = await new WebApi({}).call(url,method);
					let response = JSON.parse(delete_result);
					if(response.result === true){
						alert("削除しました！")
						// キャッシュを無視してサーバーからリロード
						window.location.reload(true);
					}else{
						alert('エラーが発生したため、削除できませんでした。');
					}
				}

				async function animal_get(e) {
					let animal_no = e.target.parentElement.parentElement.getAttribute("animal_no");
					const url = '/~testaki/known_animal_SPA/top/animal_db.php?select_animal=' + animal_no;
					const method = 'GET';
					const result = await new WebApi({}).call(url,method);
					let response = JSON.parse(result);
					if(response.result === true){
						animal_name.value = response.data[0].name;
						animal_family.value = response.data[0].family;
						animal_features.value = response.data[0].features;
						animal_date.value = response.data[0].date;
						animal_name.setAttribute("animal_no",animal_no);
					}
				}

				function bind() {
					let new_entry = document.getElementById("entry");
					let close = document.getElementById("close");
					let modal = document.getElementById("modal");
					let modal_bg = document.getElementById("modal_bg");
					let md_entry = document.getElementById("md_entry");
					let modal_title = document.getElementById("modal_title");
					let fileup = document.getElementById("fileup");
					let animal_name = document.getElementById("animal_name");
					let animal_family = document.getElementById("animal_family");
					let animal_features = document.getElementById("animal_features");
					let animal_date = document.getElementById("animal_date");
					let user_tab = document.getElementById("user_edit_tab");
					let animal_modal = document.getElementById("animal_modal");
					let user_modal = document.getElementById("user_modal");

					//TOPタブの新規登録ボタン押下
					new_entry.addEventListener('click',() => {
						entry()
					}, false);
					//モーダルの閉じるボタン押下
					close.addEventListener('click',() => {
						modal.classList.add("hidden");
						animal_modal.classList.add("hidden");
						user_modal.classList.add("hidden");
						document.getElementById("old_pass_div").classList.add("hidden");
						document.getElementById("re_new_pass_div").classList.add("hidden");
						document.getElementById("mail_comment").classList.add("hidden");
						if(fileup.classList.contains("hidden") == true){
							fileup.classList.remove("hidden")};
					}, false);
					//モーダル外押下
					modal_bg.addEventListener('click',() =>{
						modal.classList.add("hidden")
						animal_modal.classList.add("hidden");
						user_modal.classList.add("hidden");
						document.getElementById("old_pass_div").classList.add("hidden");
						document.getElementById("re_new_pass_div").classList.add("hidden");
						document.getElementById("mail_comment").classList.add("hidden");
						if(fileup.classList.contains("hidden") == true){
							fileup.classList.remove("hidden")};
					}, false);

					md_entry.addEventListener('click',() => {
						//モーダルの登録ボタン押下後
						if(modal_title.textContent == "新規登録"){
							entry_done();
						//モーダルの更新ボタン押下後
						}else if(modal_title.textContent == "更新"){
							edit_done();
						//モーダルの削除ボタン押下後
						}else if(modal_title.textContent == "このデータを削除しますか？"){
							delete_done();
						//パスワード変更モーダルの更新ボタン押下後
						}else if(modal_title.textContent == "パスワード変更"){
							pass_change_done();
						//ユーザー情報の編集モーダルの更新ボタン押下後
						}else{
							user_edit_done();
						}
					}, false);

					document.getElementById("loop").addEventListener('click', function(e) {
						//TOPタブの更新ボタン押下後
						if(e.target.classList.contains('edit')){
							animal_get(e);
							animal_name.readOnly = false;
							animal_family.readOnly = false;
							animal_features.readOnly = false;
							animal_date.readOnly = false;
							md_entry.textContent = "更新";
							modal_title.textContent = "更新";
							animal_modal.classList.remove("hidden");
							modal.classList.remove("hidden");
						}
						//TOPタブの削除ボタン押下後
						if(e.target.classList.contains('delete')){
							animal_get(e);
							animal_name.readOnly = true;
							animal_family.readOnly = true;
							animal_features.readOnly = true;
							animal_date.readOnly = true;
							md_entry.textContent = "削除";
							modal_title.textContent = "このデータを削除しますか？";
							animal_modal.classList.remove("hidden");
							fileup.classList.add("hidden");
							modal.classList.remove("hidden");
						}
					},false);
					//ユーザー情報の編集タブの変更ボタン押下
					let user_info = document.querySelectorAll('.user_info');
					user_info.forEach(function(userInfo){
						userInfo.addEventListener('click', (e) => {
							part_of_user_get(e);
							md_entry.textContent = "更新";
							user_modal.classList.remove("hidden");
							modal.classList.remove("hidden");
						}, false)
					})
				}

				function _startup(){
					window.onload = function(){
						lc.show();
						user_get();
						all_animals_get();
						bind();
						lc.hide();
					}
				}
				return {startup:_startup}
			})();
			top.startup();

		</script>
	</body>
</html>
