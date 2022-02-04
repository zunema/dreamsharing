<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$new = new DreamsharingController();
$params = $new->new_control();
$post = $_POST;
$today = date('Y-m-d');

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>夢の新規投稿</title>
</head>

<body>
  <?php include('login_header.php');?>
  <div class="container">

    <div class="row text-center">
      <div class="col-12 new-top">
        <h4>夢の新規投稿フォーム</h4>
      </div>
    </div>

    <form action="new.php" method="POST">
      <input type="hidden" id="id" name="id" value="<?= $params["userDate"]["id"] ?>"><br>

      <div class="row new-item">
        <div class="col-8 offset-2">
          <table>
            <tr>
              <th><label class="mt-1">タイトル：</label></th>
            </tr>
          </table>
          <input type="text" name="title" id="title" class="form-control" placeholder="夢のタイトル" value="<?php if(isset($post['title'])){echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8');} ?>">
            <?php if(isset($params["err"]["title"]) && $params["err"]["title"] === "blank"): ?>
          <p class="err" style="color:red">タイトルを入力して下さい。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row">
        <div class="col-3 offset-2">
          <table>
            <tr>
              <th><label class="mt-1">感情：</label></th>
              <td>
                <select name="emotion" class="form-control">
                <?php foreach($params["emotionDate"] as $emotion):?>
                <option value ="<?= $emotion["id"]?>"><?= $emotion["emotion"] ?></option>
                <?php endforeach;?>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-5">
          <table>
            <tr>
              <th><label class="mt-1">見た日：　</label></th><td><input type="date" name="date" id="date" class="form-control" placeholder="20◯◯/◯◯/◯◯" value="<?php if(isset($post['date'])){echo htmlspecialchars($post['date']);}?>"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["date"]) && $params["err"]["date"] === "blank"): ?>
            <p class="err" style="color:red">見た日を入力してください。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row new-item">
        <div class="col-8 offset-2">
          <table>
            <tr>
              <th><label class="mt-1">内容：</label></th>
            </tr>
          </table>
          <textarea name="body" id="body" class="form-control" placeholder="夢の内容"><?php if(isset($post['body'])){echo htmlspecialchars($post['body'], ENT_QUOTES, 'UTF-8');}?></textarea>
          <?php if(isset($params["err"]["body"]) && $params["err"]["body"] === "blank"): ?>
            <p class="err" style="color:red">内容を入力して下さい。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-8 offset-2 new-submit">
          <button type="submit" name="post" class="btn btn-outline-primary">送信</button>
        </div>
      </div>

    </form>

    <div class="row pb-5">
      <div class="new-a">
        <a href="index.php" class="col-12">戻る</a>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>

</body>

</html>