<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The signin.php file                                 *
* It contains the sign in form and allows logging in  *
*******************************************************
 -->

<?php require './Divisions/header.php';?>
<?php

// When the user submits the login details
if(isset($_POST['submit'])){
// This part of code is copied from the week 9 lecture notes
  $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
  $criteria = [
  'username' => $_POST['username'],
  ];
  $stmt->execute($criteria);
  $user = $stmt->fetch();


  $password = $_POST['password'];
// If the password matches the username, log the user in and redirect to respective pages according to the user type
//  and the page they reach the sign in page
  if(password_verify($password, $user['password'])) {
   $_SESSION['loggedin'] = $user['user_id'];
   if($user['type']=="admin"){
     header("Location: ./Admin/Dashboard");
   }
   else if(isset($_GET['product'])){
     $location = './particularproduct.php?product='.$_GET['product'];
     header('Location: '.$location);
   }
   else if(isset($_GET['redirect']) && $_GET['redirect']=="checkout"){
     $location = './checkout.php';
     header('Location: '.$location);
   }
  else{
     header("Location: ./");
    }
  }
}// end of if(isset($_POST['submit']))

if(!isset($_SESSION['loggedin'])){
?>


<h1>Sign in</h1>


<div id = "formDiv">
  <form action = "signin.php
  <?php
  if(isset($_GET['product'])){
    echo '?product='.$_GET['product'];
  }
  else if(isset($_GET['redirect'])){
    echo '?redirect='.$_GET['redirect'];
  }
  ?>" method = "POST">
    <label for = "username">Username:</label>
    <input type = "text" name = "username" placeholder="Username"><br><br>

    <label for = "password">Password:</label>
    <input type = "password" name = "password" placeholder="Password"><br><br><br><br><br><br><br>
    <p>
<!-- If the password is incorrect, the message is displayed -->
      <?php
      if (isset($_POST['submit']) && !isset($_SESSION['loggedin'])) {
        echo'<font color = "red">*Wrong username or password. Please try again</font>';
      }
      ?>
    </p>
    <input type = "submit" value = "Sign in" name = "submit">
  </form>
</div>


<?php
}// end of if(!isset($_SESSION['loggedin']))
else {
  echo '<h1>Error! You are already logged in and should not be on this page!</h1>';
}


  require './Divisions/sidebar.php';
  require './Divisions/footer.php';
?>
