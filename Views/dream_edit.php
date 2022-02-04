<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$dreamDate = new DreamsharingController();
$params = $dreamDate->dream_edit_control();
$params["id"] = $_SESSION["login_user"];

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>夢の編集</title>
  </head>
  <body>
    <?php include('login_header.php');?>
    <div class="container">

      <div class="row">
        <div class="col-3 offset-3">
          <h4>投稿編集フォーム</h4>
        </div>
      </div>

      <form action="dream_edit.php?id=<?= $params["postDate"]["id"]?>" method="POST">
        <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($params["postDate"]["id"] ?? ""); ?>"><br>

        <div class="row">
          <div class="col-6 offset-3">
            <label>タイトル：</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($params["postDate"]["title"]); ?>">
            <?php if(isset($params["err"]["title"]) && $params["err"]["title"] === "blank"): ?>
              <p class="err" style="color:red">タイトルを入力して下さい。</p>
            <?php endif;?>
          </div>
        </div>

        <div class="row">
          <div class="col-6 offset-3">
            <label>内容：</label>
            <textarea name="body" id="body" class="form-control mb-4"><?php if(isset($params["postDate"]["body"])){echo htmlspecialchars($params["postDate"]["body"]);}?></textarea>
            <?php if(isset($params["err"]["body"]) && $params["err"]["body"] === "blank"): ?>
              <p class="err" style="color:red">内容を入力して下さい。</p>
            <?php endif;?>
          </div>
        </div>

        <div class="row">
          <div class="col-6 offset-3">
            <label>感情：</label>
            <select name="emotion" class="form-control">
              <?php foreach($params["emotionDate"] as $emotion):?>
                <option value ="<?= $emotion['id'] ?>"<?=$params['postDate']['emotion_id'] === $emotion['id'] ? 'selected' : ''; ?>><?=$emotion['emotion'] ?></option>
              <?php endforeach;?>
            </select><br>
          </div>
        </div>

        <div class="row">
          <div class="col-6 offset-3">
            <label>見た日：</label>
            <input type="date" name="date" id="date" class="form-control mb-4" value="<?php echo htmlspecialchars($params["postDate"]["date"]); ?>">
            <?php if(isset($params["err"]["date"]) && $params["err"]["date"] === "blank"): ?>
              <p class="err" style="color:red">見た日を入力してください。</p>
            <?php endif;?>
          </div>
        </div>

        <div class="row">
          <div class=" col-6 offset-3 dream-edit-submit">
            <button type="submit" class="btn btn-outline-info" name="post">編集</button>
          </div>
        </div>
      </form>

      <div class="row text-center">
        <div class="col-12">
          <a href="index.php" class="col-12">戻る</a>
        </div>
      </div>
    </div>
    <?php include('footer.php');?>

  </body>
</html>