<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The signup.php file                                 *
* It contains the sign up form and allows customers to*
* Register into the system                            *
*******************************************************
 -->

<?php
  require './Divisions/header.php';
  require './Divisions/checkExisting.php';
?>
<?php


if(isset($_POST['submit'])){
  // When the user submits the form:
  $password = $_POST['password'];
  // Store the password securely as an encrypted one
  $hash = password_hash($password, PASSWORD_DEFAULT);

  // If the user do not check the checkbox for receiving notifications
  if(!isset($_POST['notifications']))
    $_POST['notifications'] = "no";

  $stmt = $pdo->prepare("INSERT INTO users(fullname, username, email, password, type, notifications)
                        VALUES(:fullname, :username, :email, :password, :type, :notifications)");
  $criteria = [
    'fullname' => $_POST['fullname'],
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'password' => $hash,
    'type' => "customer",
    'notifications'=>$_POST['notifications']
  ];

// The checkUsername and checkEmail functions are taken called in the checkExisting.php file
// This file checks whether the supplied username or email already exists in the database and returns a boolean
  if(checkUsername() && checkEmail() && $stmt->execute($criteria)){
    echo'<h3>Thank you for signing up</h3>';
    echo'<h3>You successfully registered with username: <strong>'.$_POST['username'].'</strong>.</h3><br><br>';
    echo'<h3><a href = "./signin.php">Click here to Login</a></h3>';
  }


  else if(!checkUsername()){
    echo '<h3>Sign up not successful. That username is already taken.</h3>';
    echo'<h3><a href = "./signup.php">Click here to return to the Registration page.</a></h3>';
  }
  elseif(!checkEmail()){
    echo '<h3>Sign up not successful. An account already exists with that email.</h3>';
    echo'<h3><a href = "./signup.php">Click here to return to the Registration page.</a></h3>';
  }
}// end of if(isset($_POST['submit']))

else{
?>
<!-- Show the signup form -->
<!-- The actionpath variable defines the form's action -->
<!-- The type variable defines the type of user being created -->
<!-- These variables are passed into the form that is taken from regform.php -->
  <h1>Sign up</h1>
  <?php
    $actionPath = "./signup.php";
    $type = "customer";
    require './Divisions/regform.php';
  ?>

<?php
}
  require './Divisions/sidebar.php';
  require './Divisions/footer.php';
?>
