<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The addadmin.php file
* This file displays the form to add a new user
* It is accessible from the Manage Administrators
******************************************************
 -->
<?php
  require '../Divisions/adminheader.php';
  require '../../Divisions/checkExisting.php';
?>


<?php
// If the form is filled and submitted, the details are stored onto the users table.
// The user type will be admin and can access the administration area
if(isset($_POST['submit'])){
  $stmt = $pdo->prepare("INSERT INTO users(fullname, username, email, password, type)
                        VALUES(:fullname, :username, :email, :password, :type)");
  $criteria = [
    'fullname' => $_POST['fullname'],
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'type' => "admin"
  ];


  if(checkUsername() && checkEmail() && $stmt->execute($criteria)){
    echo'<h3>You successfully added the Administrator account with username: <strong>'.$_POST['username'].'</strong>.</h3><br><br>';
    echo'<h3><a href = "./manageadministrators.php">Click here to view the latest list of administrators.</a></h3>';
  }

// The checkUsername and checkEmail functions are taken called in the checkExisting.php file
// This file checks whether the supplied username or email already exists in the database and returns a boolean
  else if(!checkUsername()){
    echo '<h3>Adding user not successful. Please enter a unique username.</h3>';
    echo'<h3><a href = "./addadmin.php">Click here to return to the add a new user.</a></h3>';
  }
  elseif(!checkEmail()){
    echo '<h3>Adding user not successful. Please enter a unique email.</h3>';
    echo'<h3><a href = "./addadmin.php">Click here to return to the add a new user.</a></h3>';
  }
} //end of if(isset($_POST['submit']))

else{
?>

<!--
     The $actionPath variable sets the form action value which is passed to the form from regform.php
     The form for adding a new user is extracted from the regform.php file
     This has been done in order to reduce redundancy of code
-->

   <h1>Add an Admin</h1>
   <?php
    $type = "admin";
    $actionPath = "./addadmin.php";
    require '../../Divisions/regform.php';
   ?>

   <?php
 } //end of else statement for if(isset($_POST['submit']))

     require '../Divisions/adminsidebar.php';
     require '../../Divisions/footer.php';
   ?>
