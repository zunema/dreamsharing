<?php

require_once(ROOT_PATH . '/Models/User.php');
require_once(ROOT_PATH . '/Models/Dream.php');
require_once(ROOT_PATH . '/Models/Good.php');
require_once(ROOT_PATH . '/Models/Like.php');

class DreamsharingController
{
  private $request;  // リクエストパラメータ(GET,POST)
  private $User;  //Userモデル
  private $Dream;  //Dreamモデル
  private $Like;  //Likeモデル

  public function __construct()
  {
    // リクエストパラメータの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;
    // モデルオブジェクトの生成
    $this->User = new User();
    $this->Dream = new Dream();
    $this->Like = new Like();
  }

  public function url_check()
  {
    if (!isset($_SERVER["HTTP_REFERER"])) {
      header("location:signup.php");
    }
  }

  // 新規登録
  public function insert_control()
  {
    return $this->User->signup_insert($_SESSION["form"]);
  }
  public function signup_control()
  {
    if (!empty($this->request["post"])) {
      return $this->signup_validate();
    }
  }

  // パスワードリセット
  public function pass_control()
  {
    if (!empty($this->request["post"])) {
      return $this->pass_validate();
    }
  }

  // ログイン処理
  public function login_control()
  {
    if (!empty($this->request["post"])) {
      return $this->login_validate();
    } else if (isset($_SESSION["users"])) {
      $_SESSION = array();
      header("location:login.php");
    }
  }

  // ログアウト処理
  public function logout()
  {
    $_SESSION = array();
    session_destroy();
  }

  // 一覧画面
  public function index_control()
  {
    $page = 0;
    if(isset($this->request['get']['page'])) {
      $page = $this->request['get']['page'];
    }
    $postAll = $this->Dream->post_All($page);
    $emotionDate = $this->Dream->emotionAll();
    $postCount = $this->Dream->countAll();
    $params = [
      'postAll' => $postAll,
      'emotionDate' => $emotionDate,
      'pages' => $postCount / 10,
    ];
    return $params;
  }
  public function likes($postId)
  {
    $like = $this->Like->likeCount($postId);
    return $like;
  }

  // マイページ
  public function user_date()
  {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません';
      exit;
    }

    $userDate = $this->User->userId($this->request['get']['id']);
    $params = [
      'userDate' => $userDate,
    ];
    return $params;
  }
  public function mypage()
  {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません';
      exit;
    }

    $postDate = $this->Dream->mypageData($this->request['get']['id']);
    $params = [
      'postDate' => $postDate,
    ];
    return $params;
  }


  //プロフィール編集
  public function edit_control()
  {
    // リクエストメソッドがgetだったらeditメソッドを、postだったらバリデーションを返す
    return $_SERVER['REQUEST_METHOD'] == "GET" ? $this->edit() : $this->edit_validate();
  }

  public function edit()
  {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません';
      exit;
    }
    $userDate = $this->User->userId($this->request['get']['id']);
    $params = [
      'userDate' => $userDate,
    ];
    return $params;
  }

  //プロフィール更新
  public function update()
  {
    $this->User->update($_SESSION["update"]);
  }

  //パスワード更新ページ管理
  public function pass_update_control()
  {
    if (!empty($this->request["post"])) {
      return $this->pass_update_validate();
    }
  }

  //パスワード更新
  public function pass_update()
  {
    $this->User->pass_update($_SESSION["pass_update"]);
  }


  // 新規投稿
  public function new_control()
  {
    if (!empty($this->request["post"])) {
      return $this->new_validate();
    }
    $userDate = $this->User->userId($_SESSION["login_user"]["id"]);
    $emotionDate = $this->Dream->emotionAll();
    $params = [
      'emotionDate' => $emotionDate,
      'userDate' => $userDate,
    ];
    return $params;
  }
  public function post_insert_control()
  {
    return $this->Dream->post_insert($_SESSION["input"]);
  }

  public function post_date()
  {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません';
      exit;
    }
    $postDate = $this->Dream->postId($this->request['get']['id']);
    $emotionDate = $this->Dream->emotionAll();
    $params = [
      'postDate' => $postDate,
      'emotionDate' => $emotionDate,
    ];
    return $params;
  }

  // 投稿データの取得
  public function dream_edit_control()
  {
    // リクエストメソッドがgetだったらeditメソッドを、postだったらバリデーションを返す
    return $_SERVER['REQUEST_METHOD'] == "GET" ? $this->post_date() : $this->dream_edit_validate();
  }

  // 投稿更新
  public function dream_update()
  {
    $this->Dream->dream_update($_SESSION["form"]);
  }

  // 投稿更新
  public function post_delete()
  {
    $this->Dream->post_delete($this->request['get']['id']);
  }

  // 検索
  public function search($searchAll)
  {
    $page = 0;
    if(isset($this->request['get']['page'])) {
      $page = $this->request['get']['page'];
    }
    $title = $searchAll["search_name"];
    $emotion = $searchAll["emotion"];
    $dateStart = $searchAll["date_start"];
    $dateEnd = $searchAll["date_end"];
    $emotionDate = $this->Dream->emotionAll();
    if($emotion === "0"){
      if($dateStart === ""){
        $searchAll = $this->Dream->search_name($title,$page);
        $searchCount = $this->Dream->search_name_page($title);
      }else{
        $searchAll = $this->Dream->search_name_date($title,$dateStart,$dateEnd,$page);
        $searchCount = $this->Dream->search_name_date_page($title,$dateStart,$dateEnd);
      }
    }else{
      if($dateStart === ""){
        $searchAll = $this->Dream->search_name_emotion($title,$emotion,$page);
        $searchCount = $this->Dream->search_name_emotion_page($title,$emotion);
      }else{
        $searchAll = $this->Dream->searchAll($title,$emotion,$dateStart,$dateEnd,$page);
        $searchCount = $this->Dream->searchAll_page($title,$emotion,$dateStart,$dateEnd);
      }
    }
    $postCount = count($searchCount);
    $params = [
      'emotionDate' => $emotionDate,
      'searchAll' => $searchAll,
      'pages' => $postCount / 10,
    ];
    return $params;
  }

  // 非同期いいね
  public function check_like_duplicate($user_id,$post_id)
  {
    $favorite = $this->Like->check_like($user_id,$post_id);
    return $favorite;
  }

  /**
   * 非同期いいね（削除）
   * @param integer $user_id, $post_id
   * @return Bool $params 削除完了
   */
  public function delete_like($user_id,$post_id)
  {
    $this->Like->delete_by_user_and_post($user_id,$post_id);
  }

  // 非同期いいね（削除）
  /**
   * emotionsテーブルからすべてデータを取得
   * @param integer $user_id, $post_id
   * @return Bool $params 挿入完了
   */
  public function insert_like($user_id,$post_id)
  {
    $this->Like->insert($user_id,$post_id);
  }

  // いいねした記事一覧
  public function good_index()
  {
    $goodIndex = $this->Like->good_index($this->request['get']['id']);
    $params = [
      'goodIndex' => $goodIndex,
    ];
    return $params;
  }

  /**
   * ユーザの退会処理
   * @param integer $
   */
  public function withdrawal()
  {
    $this->User->withdrawal($_SESSION["login_user"]["id"]);
  }

  // バリデーション
  public function signup_validate()
  {

    $err = [];

    $pass_str = "/\A[a-z\d]{8,100}+\z/i";

    if ($_POST["name"] === "") {
      $err["name"] = "blank";
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $err["email"] = "blank";
    }
    if ($_POST["birthday"] === "") {
      $err["birthday"] = "blank";
    }
    if (!preg_match($pass_str, $_POST["password"])) {
      $err["password"] = "no_pass";
    }
    if ($_POST["password"] !== $_POST["password_conf"]) {
      $err["password_conf"] = "no_pass_conf";
    }
    // ファイル関連
    $file = $_FILES['image'];
    $filename = basename($file['name']);
    $tmp_path = $file['tmp_name'];
    $file_err = $file['error'];
    $filesize = $file['size'];
    $upload_dir = 'img/';
    $save_filename = date('YmdHis').$filename;
    $err_msgs = array();
    $save_path = $upload_dir.$save_filename;
    if (count($err) === 0) {
      move_uploaded_file($tmp_path, $save_path);
      $_SESSION["form"] = $_POST;
      $_SESSION["form"]["image"] = $save_filename;
      header("location:confirm.php");
      exit();
    } else {
      $_SESSION["form"] = $_POST;
      return ["err" => $err];
    }
  }

  public function login_validate()
  {

    $err = [];

    $loginGet = new User();
    $login = $loginGet->login_get($_POST["email"]);

    if ($_POST["email"] == "") {
      $err["email"] = "no_email";
    }
    if ($_POST["password"] == "") {
      $err["password"] = "no_password";
    }
    if (false === $login) {
      $err["email"] = "no_email";
    }
    if (!password_verify($_POST["password"], $login["password"] ?? "")) {
      $err["password"] = "no_password";
    }
    if (count($err) == 0) {
      session_regenerate_id(true);
      $_SESSION['login_user'] = $login;
      header("location:index.php");
      exit();
    } else {
      $_SESSION["login_user"] = $_POST;
      return ["err" => $err];
    }
  }

  // パスワード再設定（メールアドレス、誕生日の情報確認）のバリデーション
  public function pass_validate()
  {
    $err = [];

    $passReset = new User();
    $userMailBirthday = $passReset->mail_birthday_get($_POST["email"],$_POST["birthday"]);
    if ($_POST["email"] == "") {
      $err["email"] = "no_email";
    }
    if ($_POST["birthday"] == "") {
      $err["birthday"] = "no_birthday";
    }
    if (count($err) == 0) {
      if (false === $userMailBirthday) {
        $err["match"] = "no_match";
      }
    }
    if (count($err) == 0) {
      $_SESSION['user_mail_birthday'] = $userMailBirthday;
      header("location:pass_update.php");
      exit();
    } else {
      $_SESSION["user_date"] = $_POST;
      return ["err" => $err];
    }
  }

  // パスワード更新のバリデーション
  public function pass_update_validate()
  {

    $err = [];
    $pass_str = "/\A[a-z\d]{8,100}+\z/i";

    if (!preg_match($pass_str, $_POST["password"])) {
      $err["password"] = "no_pass";
    }
    if ($_POST["password"] !== $_POST["password_conf"]) {
      $err["password_conf"] = "no_pass_conf";
    }
    if (count($err) === 0) {
      $_SESSION["pass_update"] = $_POST;
      header("location:pass_comp.php");
      exit();
    } else {
      $_SESSION["pass_update"] = $_POST;
      return ["err" => $err];
    }
  }

  public function edit_validate()
  {

    $error = [];

    if ($_POST["name"] === "") {
      $err["name"] = "blank";
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $err["email"] = "blank";
    }
    // ファイル関連
    $file = $_FILES['image'];
    $filename = basename($file['name']);
    $tmp_path = $file['tmp_name'];
    $file_err = $file['error'];
    $filesize = $file['size'];
    $upload_dir = 'img/';
    $save_filename = date('YmdHis').$filename;
    $err_msgs = array();
    $save_path = $upload_dir.$save_filename;
    if (count($err) === 0) {
      move_uploaded_file($tmp_path, $save_path);
      $_SESSION['update'] = $_POST;
      $_SESSION['update']["image"] = $save_filename;
      header("location:complete.php");
      exit();
    } else {
      $userDate = $this->User->userId($this->request['get']['id']);
      return ["userDate" => $userDate, "err" => $err];
    }
  }

  public function new_validate()
  {
    $err = [];

    if ($_POST["title"] === "") {
      $err["title"] = "blank";
    }
    if(htmlspecialchars($_POST["body"] === "")) {
      $err["body"] = "blank";
    }
    if ($_POST["date"] === "") {
      $err["date"] = "blank";
    }
    if (count($err) === 0) {
      $_SESSION["input"] = $_POST;
      header("location:post_comp.php");
      exit();
    } else {
      $post = $_POST;
      $userDate = $this->User->userId($_SESSION["login_user"]["id"]);
      $emotionDate = $this->Dream->emotionAll();
      $params = [
        'userDate' => $userDate,
        'emotionDate' => $emotionDate,
        "err" => $err
      ];
      return $params;
    }
  }

  public function dream_edit_validate()
  {
    $err = [];

    if ($_POST["title"] === "") {
      $err["title"] = "blank";
    }
    if ($_POST["body"] === "") {
      $err["body"] = "blank";
    }
    if ($_POST["date"] === "") {
      $err["date"] = "blank";
    }
    if (count($err) === 0) {
      $_SESSION["form"] = $_POST;
      header("location:dream_comp.php");
      exit();
    } else {
      $_SESSION["form"] = $_POST;
      $postDate = $this->Dream->postId($this->request['get']['id']);
      $emotionDate = $this->Dream->emotionAll();
      $params = [
        'postDate' => $postDate,
        'emotionDate' => $emotionDate,
        "err" => $err
      ];
      return $params;
    }
  }

}