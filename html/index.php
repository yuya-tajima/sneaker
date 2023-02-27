<?php

require_once 'vendor/autoload.php';

# Maybe SQL Injection
$user = $_POST['sql'] ?? null;
if ($user) {

  try {
      $db = new \PDO(sprintf('mysql:host=db;dbname=%s',getenv('MYSQL_DATABASE')), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
  } catch (\PDOException $e) {
      die($e->getMessage());
  }

  $sql = sprintf('SELECT * FROM user WHERE name = "%s"', $user);
  $stmt = $db->query($sql);

  $result = $stmt->fetchAll();
  print_r($result);
}

# Maybe Command Injection
$cmd = $_POST['cmd'] ?? null;
if ($cmd) {
  passthru($cmd);
}

# Maybe File Inclusion
$file = $_POST['file'] ?? null;
if ($file && file_exists($file)) {
  include($file);
}

# Maybe Cross-site Scripting (XSS)
$xss = $_POST['xss'] ?? '';
echo $xss;

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
          <label for="xss">Script:</label>
          <input type="text" name="xss" id='xss' value="">
        </div>
        <div>
          <label for="sql">SQL:</label>
          <input type="text" name="sql" id='sql' value="">
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
