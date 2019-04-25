<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The viewdministrators.php file
* This page is used to edit or delete admins, as well as
* change their password
*******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>

<?php
  if(isset($_GET['edit'])){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $arr = ['user_id'=>$_GET['edit']];
    $stmt->execute($arr);
    $user = $stmt->fetch();

// The number of products posted by an administrator is also listed in this page
    $stmt = $pdo->prepare('SELECT users.user_id, COUNT(products.user_id) AS NumberOfProducts
                            FROM users
                            INNER JOIN products ON
                            users.user_id = products.user_id
                            GROUP BY products.user_id
                            HAVING products.user_id = :user_id');
    $stmt->execute($arr);
    $admin = $stmt->fetch();

  if(isset($_GET['action'])){
    if($_GET['action']=="delete"){
      header('Location: ./deleteadmin.php?user='.$user['user_id']);
    }//end of if($_GET['action']=="delete")
// If the action selected is edit, the form to change user's fullname appears
    if($_GET['action']=="edit"){
      if(isset($_POST['submitname'])){
        $update = $pdo->prepare('UPDATE users SET fullname = :fullname WHERE user_id = :user_id');
        $criteria = [
          'fullname'=>$_POST['fullname'],
          'user_id'=>$user['user_id']
        ];
        if($update->execute($criteria)){
          echo '<h3>Succesfully edited fullname from '.$user['fullname'].' to '.$_POST['fullname'].'.</h3><br><br>';
          echo '<h3><a href = "./manageadministrators.php">Click here to return to view latest list of administrators</a>
          <h3><br><br><br><hr>';
        }// end of if($update->execute($criteria))
        else{
          echo 'Error! Could not change fullname from '.$user['fullname'].' to '.$_POST['fullname'].'.';
        }// end of else for if($update->execute($criteria))
      }//end of if(isset($_POST['submitname']))
      else{
        echo '<b>Enter new name for '.$user['fullname'].'</b><br><br>';
?>
  <form method = "POST" action = "viewadministrators.php?edit=<?php echo $_GET['edit'];?>&action=edit">
    <label for = "fullname">Full Name:</label>
    <input type = "text" name = "fullname" placeholder="Full Name" required>
    <input type = "submit" value = "Submit" name = "submitname">
  </form>

<?php
      } // end of else for if(isset($_POST['submitname']))
    } // end of if($_GET['action']=="edit")

// If the action selected is password, the form to change user's password appears
    if($_GET['action']=="password"){
      $passverification = '<p style="font-size: 15px; color: red; clear: left;"></p>';
      if(isset($_POST['submitpassword'])){
// Verifying the hashed password using php's password_verify method.
// If the old password matches, only then the password is updated
        if(password_verify( $_POST['oldpassword'], $user['password'])){
          $update = $pdo->prepare('UPDATE users SET password = :password WHERE user_id = :user_id');
          $criteria = [
            'password'=>password_hash($_POST['newpassword'], PASSWORD_DEFAULT),
            'user_id'=>$user['user_id']
          ];
          if($update->execute($criteria)){
            echo '<h3>Succesfully edited password. </h3><br><br>';
            echo '<h3><a href = "./manageadministrators.php">Click here to return to view latest list of administrators</a>
            <h3><br><br><br><hr>';
          } // end of if($update->execute($criteria))
          else{
            echo 'Error! Could not change password.';
          } // end of else for if($update->execute($criteria))
        } // end of if(password_verify( $_POST['oldpassword'], $user['password']))
        else{
          $passverification = '<p style = "color:red; font-size: 15px; clear: left;">Error! Incorrect old password</p>';
          require'../../Divisions/passchangeform.php';
        } // end of else for if(password_verify( $_POST['oldpassword'], $user['password']))
    } // end of if(isset($_POST['submitpassword']))
    else{
?>

<?php require'../../Divisions/passchangeform.php';?>
<?php
    } //end of else for if(isset($_POST['submitpassword']))
  } // end of if($_GET['action']=="password")
} // end of if(isset($_GET['action']))
  else{

?>

<!-- These buttons are the available actions to perform for the selected user account -->

<hr><br>
<a href = "./viewadministrators.php?<?php echo 'edit='.$user['user_id'].'&action=delete';?>">
  <button class = "viewButton deleteButton"><img src = "../Images/rubbish-bin.svg" class = "btnImg"><br>Delete</button>
</a>

<a href = "./viewadministrators.php?<?php echo 'edit='.$user['user_id'].'&action=password';?>">
  <button class = "viewButton editPasswordButton"><img src = "../Images/149307.svg" class = "btnImg"><br>Edit Password</button>
</a>

<a href = "./viewadministrators.php?<?php echo 'edit='.$user['user_id'].'&action=edit';?>">
  <button class = "viewButton editButton"><img src = "../Images/resume.svg" class = "btnImg"><br>Edit Name</button>
</a>

<br>
<!-- Displaying user details -->
  <h3>User Details: </h3><br>

  <p>
    <b>Name: </b><?php echo $user['fullname'];?><br><br>
    <b>Username: </b><?php echo $user['username'];?><br><br>
    <b>Email: </b><?php echo $user['email'];?><br><br>
    <b>Total posts by Admin: </b><?php if($admin['NumberOfProducts']=="")echo"0"; else echo $admin['NumberOfProducts'];?><br><br>
<?php if($admin['NumberOfProducts']>0){?>
    <b style = "color: red;">*Note: If you delete this account, all the products under it will be deleted.</b>
<?php } // end of if($admin['NumberOfProducts']>0)
      else{
        ?>
    <b style = "color: green;">Deleting this account will not delete any products.</b>
<?php }// end of else for if($admin['NumberOfProducts']>0)
?>
  </p>
<hr>

 <?php
  }
} // end of if(isset($_GET['edit']))
else{
  echo '<h1>Error! You should not be on this page!</h1>';
  echo '<h3><a href = "./manageadministrators.php">Click here view latest list of administrators</a>
  <h3><br><br><br><hr>';
} // end of else for // end of if(isset($_GET['edit']))

  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
 ?>
