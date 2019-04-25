<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

-The form for signing up.
-The form for signing up an admin and a customer is almost the same, the key difference being
-Their type when entering the data into the database.
-If the signup is being done from the customers area, there will also be an extra checkbox
-That asks if the user would want to receive email notifications when a new product is added
 -->

<div id = "formDiv">
  <form action = "<?php echo $actionPath ?>" method = "POST">
    <label for = "fullname">Full Name:</label>
    <input type = "text" name = "fullname" required><br><br>

    <label for = "email">Email:</label>
    <input type = "email" name = "email" required><br><br>

    <label for = "username">Username:</label>
    <input type = "text" name = "username" required><br><br>

    <label for = "password">Password:</label>
    <input type = "password" name = "password" onkeyup="checkPassword()" id = "password" required><br><br>
    <p id = "passtest" style="font-size: 15px; color: red; clear: left;">Passwords must contain 8-16 characters</p>

    <label for = "confirmpassword">Confirm password:</label>
    <input type = "password" name = "confirmpassword" onkeyup="checkPassword()" id = "confirmpassword" required><br><br>
    <p id = "confirmpasstest" style="font-size: 15px; color: red; clear: left;"><br></p>
    <br>
<?php
      if($type=="customer"){
?>
        <span style = "float: right; margin-right: 70px;">I want to get notified by email when new products are posted</span>
        <input style="float: right; width: 50px; margin: 5px; margin-right: 0;" type = "checkbox" name = "notifications" value = "yes">
<?php
      }
?>
    <br><br><br>
    <input type = "submit" value = "Sign up" name = "submit" id = "submission">
  </form>
</div>
