
<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

-The form used to change the password for an administrator
-The file is kept outside the admin folder, for a foreseeable future update where customers would be able to change
-their passwords as well. In that case, the same file could be used.
 -->

<!-- Password verification is used to confirm that the old password matches the entered password -->
<form method = "POST" action = "viewadministrators.php?edit=<?php echo $_GET['edit'];?>&action=password">
  <label for = "oldpassword">Old Password:</label>
  <input type = "password" name = "oldpassword" placeholder="Old Password" required>
  <?php echo $passverification; ?>

<!-- The new passwords are validated to have at least 8 characters and that the confirmation password matches the first one -->
  <label for = "newpassword">New Password:</label>
  <input type = "password" name = "newpassword" placeholder="New Password" onkeyup="checkPassword()" id = "password" required>
  <p id = "passtest" style="font-size: 15px; color: red; clear: left;">Passwords must contain 8-16 characters</p>

  <label for = "confirmpassword">Confirm Password:</label>
  <input type = "password" name = "confirmpassword" placeholder="Confirm Password" onkeyup="checkPassword()" id = "confirmpassword" required>
  <p id = "confirmpasstest" style="font-size: 15px; color: red; clear: left;"><br></p>

  <input type = "submit" value = "Submit" name = "submitpassword" id = "submission">
</form>
