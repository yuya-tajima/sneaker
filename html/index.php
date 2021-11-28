<?php

try {
    $db = new PDO(sprintf('mysql:host=db;dbname=%s',getenv('MYSQL_DATABASE')), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
} catch (PDOException $e) {
      die($e->getMessage());
}

$user = $_POST['user'] ?? null;
if ($user) {
  $sql = sprintf('SELECT * FROM user WHERE name = "%s"', $user);
  foreach ($db->query($sql) as $row) {
      var_dump($row);
  }
}

$cmd = $_POST['cmd'] ?? null;
if ($cmd) {
  passthru($cmd);
}

$file = $_POST['file'] ?? null;
if (file_exists($file)) {
  include($file);
}

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
    Echo: <?php echo $_POST['echo'] ?? 'none'; ?>
</body>
</html>
