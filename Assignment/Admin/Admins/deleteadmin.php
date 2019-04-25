<!--
******************************************************
* The deleteadmin.php file
* This file prompts to delete an Administrator
* If clicked yes, the selected Administrator account
* Along with all the records related to it will be
* Removed from the system
******************************************************
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
 -->
<?php require '../Divisions/adminheader.php';?>


<?php

// The page is only accessible if the $_GET['user'] variable is set
// Otherwise, the page redirects to manageadministrators.php
  if(isset($_GET['user'])){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user');
    $delete = $pdo->prepare('DELETE FROM users WHERE user_id = :user');

    $arr = ['user'=>$_GET['user']];
    $stmt->execute($arr);
    $user = $stmt->fetch();

// The response variable checks for the confirmation of deleting the account.
// If the response is available, the user is deleted, otherwise, the page redirects back to the account's details
    if(isset($_GET['response'])){
      if($delete->execute($arr)){
        echo '<h3>The administrator account <b>'.$user['username'].'</b> was deleted succesfully.</h3><br><br>';
        echo '<h3><a href = "./manageadministrators.php">Click here updated latest list of administrators</a>
        <h3><br><br><br><hr>';
      }// end of if($delete->execute($arr))

    }//end of if(isset($_GET['response']))
    else{
?>
<h2>You are about to remove the administrator <?php echo $user['username'];?>. Are you sure?</h2>

<a href="./deleteadmin.php?user=<?php echo $user['user_id'];?>&response=yes"><button class = "viewButton editButton" style="background: green;  float: left;">
  <img src = "../Images/tick-inside-a-circle.svg" class = "btnImg"><br>Yes</button></a>

<a href="./viewadministrators.php?edit=<?php echo $user['user_id'];?>"><button class = "viewButton deleteButton" style="float: left;">
  <img src = "../Images/error.svg" class = "btnImg"><br>No</button></a>

<?php
  }//end of else for if(isset($_GET['response']))
} // end of if(isset($_GET['user']))
else{
    header("Location: ./manageadministrators.php");
} // end of else for if(isset($_GET['user']))
?>

<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
