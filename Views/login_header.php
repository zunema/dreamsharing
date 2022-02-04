<?php
$userID = $_SESSION["login_user"];
?>
<nav class="navbar navbar-expand-sm align-items-center">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand navbar-icon" href="index.php">dreamsharing</a>
  <div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <?php if($userID["role"] === "1") : ?>
          <a class="nav-link" href="mypage.php?id=<?=$userID["id"] ?>">マイページ</a>
        <?php endif; ?>
      </li>
      <li class="nav-item active">
        <?php if($userID["role"] === "1") : ?>
          <a class="nav-link" href="new.php">新規投稿</a>
        <?php endif; ?>
      </li>
      <li class="nav-item nav-item-end">
        <form action="logout.php" method="POST">
          <button class="btn btn-outline-secondary" name="logout">ログアウト</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
