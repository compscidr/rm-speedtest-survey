<?php
function attemptConnect() {
  global $host;
  global $username;
  global $password;
  global $db_name;
  $mysqli = new mysqli("localhost", "root", "rusU57hy!", "survey");
  return $mysqli;
}
?>
