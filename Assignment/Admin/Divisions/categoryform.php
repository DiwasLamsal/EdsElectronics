<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The categoryform.php file
* This file contains the form for creating or
* Editing a category
******************************************************
 -->

<!-- Information about the variable $cattext is provided wherever this form is required -->
<form method = "POST" action = "viewcategories.php?edit=<?php echo $_GET['edit'];?>&action=edit">
  <label for = "catname">Category Name:</label>
  <input type = "text" name = "name" placeholder="Category Name" required>
  <?php echo $cattext;?>

  <input type = "submit" value = "Submit" name = "submit">
</form>
