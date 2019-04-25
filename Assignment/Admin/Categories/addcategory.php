<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The addcategory.php file 							             *
* This file contains the form to add a category      *
******************************************************
 -->
 <?php
   require '../Divisions/adminheader.php';
   require '../../Divisions/checkExisting.php';
 ?>
<?php
// When the submit button is clicked, the new category is added to the database.
if(isset($_POST['submit'])){
   $stmt = $pdo->prepare("INSERT INTO categories(name)
                         VALUES(:name)");
   $criteria = [
     'name' => $_POST['name'],
   ];

// However, the checkCategory() function is called from the checkExisting file which checks if the
// category name already exists. If it does, the category is not added to the database.
     if(checkCategory() && $stmt->execute($criteria)){
       echo'<h3>You successfully added the Category: <strong>'.$_POST['name'].'</strong>.</h3><br><br>';
       echo'<h3><a href = "./managecategories.php">Click here to return to the Category List.</a></h3><br>';
     } // end of if(checkCategory() && $stmt->execute($criteria))
     else if(!checkCategory()){
       echo '<h3>The category you specified already exists.</h3> <br>';
       echo'<h3><a href = "./addcategory.php">Click here to add a new category.</a></h3>';
       echo '<br><h3><a href = "./managecategories.php">Click here to return to the Category List.</a></h3>';
     } // end of if(!checkCategory())
    } // end of if(isset($_POST['submit']))
else{
?>

<!-- The form to add a category -->
  <h1>Add a category!</h1>
  <form method = "POST" action = "addcategory.php">
     <label for = "name">Category Name:</label>
     <input type = "text" name = "name" required><br><br>
     <input type = "submit" name = "submit" value = "Add Category">
  </form>
  <br><br>
  <h3><a href = "./managecategories.php">Click here to return to the Category List.</a></h3>
 <?php
} // end of else for if(isset($_POST['submit']))
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
 ?>
