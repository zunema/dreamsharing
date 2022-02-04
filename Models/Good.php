<?php
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'Models/Db.php');

class Good extends Db {

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  function getGood($p_id)
  {
    $sql = 'SELECT * FROM good WHERE post_id = :p_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':p_id', (int)$p_id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
?>