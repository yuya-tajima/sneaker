<?php

require_once 'vendor/autoload.php';

# Prevent SQL Injection
$user = $_POST['sql'] ?? null;
if ($user) {

  try {
      $db = new \PDO(sprintf('mysql:host=db;dbname=%s',getenv('MYSQL_DATABASE')), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
  } catch (\PDOException $e) {
      die($e->getMessage());
  }

  $stmt = $db->prepare('SELECT * FROM user WHERE name = :user');
  $stmt->bindValue(':user', $user, \PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetchAll();
  print_r($result);
}

# Prevent Command Injection
passthru('/bin/date');

# Prevent File Inclusion
$file = dirname(__DIR__) . '/inc/header.php';
if (file_exists($file)) {
  include($file);
}

# Prevent Cross-site Scripting (XSS)
$xss = $_POST['xss'] ?? '';
echo htmlspecialchars($xss);

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
