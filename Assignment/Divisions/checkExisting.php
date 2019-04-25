<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

This file is used to confirm that unique data is inserted into the database.

-->
<?php

// function checkUsername()
// This function checks whether the supplied username already exists in the database
// If the username exists, it returns false
function checkUsername(){
  global $pdo;
  $check = $pdo->prepare('SELECT * FROM users WHERE username = :username');
  $criteria = [
    'username' => $_POST['username'],
  ];
  $check->execute($criteria);
  $a = 0;
  while ($check->fetch()) {
    $a++;
  }
  if($a > 0){
    return false;
  }
  return true;
}

// function checkEmail()
// This function checks whether the supplied email already exists in the database
// If the email exists, it returns false
function checkEmail(){
  global $pdo;
  $check = $pdo->prepare('SELECT * FROM users WHERE email = :email');
  $criteria = [
    'email' => $_POST['email'],
  ];
  $check->execute($criteria);
  $a = 0;
  while ($check->fetch()) {
    $a++;
  }

  if($a > 0){
    return false;
  }
  return true;
}

// function checkCategory()
// This function checks whether the supplied category already exists in the database
// If the category exists, it returns false
function checkCategory(){
  global $pdo;
  $check = $pdo->prepare('SELECT * FROM categories WHERE name = :name');
  $criteria = [
    'name' => $_POST['name'],
  ];
  $check->execute($criteria);
  $a = 0;
  while ($check->fetch()) {
    $a++;
  }

  if($a > 0){
    return false;
  }
  return true;
}


?>
