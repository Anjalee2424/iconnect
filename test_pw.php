<?php
$password = "test1234";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo $hashedPassword;