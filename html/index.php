<?php

require_once 'vendor/autoload.php';

# Maybe SQL Injection
$user = $_POST['user'] ?? null;
if ($user) {

  try {
      $db = new \PDO(sprintf('mysql:host=db;dbname=%s',getenv('MYSQL_DATABASE')), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
  } catch (\PDOException $e) {
      die($e->getMessage());
  }

  $sql = sprintf('SELECT * FROM user WHERE name = "%s"', $user);

  $sth = $db->query($sql);
  if ($sth->rowCount()) {
      echo htmlspecialchars(sprintf( '%s exist.', $user), ENT_QUOTES, 'UTF-8' );
  } else {
      echo htmlspecialchars(sprintf( '%s does not exist.', $user), ENT_QUOTES, 'UTF-8' );
  }

  $sth = $db->prepare('SELECT * FROM user WHERE name = :user');
  $sth->bindValue(':user', $user, \PDO::PARAM_STR);
  $sth->execute();
  if ($sth->rowCount()) {
      echo htmlspecialchars(sprintf( '%s exist.', $user), ENT_QUOTES, 'UTF-8' );
  } else {
      echo htmlspecialchars(sprintf( '%s does not exist.', $user), ENT_QUOTES, 'UTF-8' );
  }
}

# Maybe Command Injection
$cmd = $_POST['cmd'] ?? null;
if ($cmd) {
  passthru($cmd);
}

# Maybe File Inclusion
$file = $_POST['file'] ?? null;
if (file_exists($file)) {
  include($file);
}

# Maybe Cross-site Scripting (XSS)
echo $_POST['echo'] ?? '';

?>
<html>
<style>
  div {
    margin: 3px;
  }
</style>
<body>
    <form action="" method="post" accept-charset="utf-8">
        <div>
          <label for="echo">Echo:</label>
          <input type="text" name="echo" id='echo' value="">
        </div>
        <div>
          <label for="user">User:</label>
          <input type="text" name="user" id='user' value="">
        </div>
        <div>
          <label for="cmd">Command:</label>
          <input type="text" name="cmd" id="cmd" value="">
        </div>
        <div>
          <label for="file">File:</label>
          <input type="text" name="file" id="file" value="">
        </div>
        <div>
          <input type="submit" value="submit">
         </div>
    </form>
</body>
</html>
