<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The deletecategories.php file 						         *
******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>
<?php
  if(isset($_GET['edit'])){
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE category_id = :category_id');
    $delete = $pdo->prepare('DELETE FROM categories WHERE category_id = :category_id');

    $arr = ['category_id'=>$_GET['edit']];
    $stmt->execute($arr);
    $category = $stmt->fetch();

// The page displays a confirmation on whether or not to actually delete the category.
// If response is set, in essence, if the yes button is clicked, the category will be deleted.
    if(isset($_GET['response'])){
      if($delete->execute($arr)){
        echo '<h3>The category <b>'.$category['name'].'</b> was deleted succesfully.</h3><br><br>';
        echo '<h3><a href = "./managecategories.php">Click here to return to view latest list of categories</a>
        <h3><br><br><br><hr>';
      }// end of if($delete->execute($arr))

    }// end of   if(isset($_GET['response']))
    else{
?>
<h2>You are about to remove the category <?php echo $category['name'];?>. Are you sure?</h2>

<a href="./deletecategories.php?edit=<?php echo $category['category_id'];?>&response=yes"><button class = "viewButton editButton" style="background: green;  float: left;">
  <img src = "../Images/tick-inside-a-circle.svg" class = "btnImg"><br>Yes</button></a>

<a href="./viewcategories.php?edit=<?php echo $category['category_id'];?>"><button class = "viewButton deleteButton" style="float: left;">
  <img src = "../Images/error.svg" class = "btnImg"><br>No</button></a>

<?php
  } // end of else for if(isset($_GET['response']))
}// end of   if(isset($_GET['edit']))
else{
    ?>
  <h1> Error! You should not be on this page!</h1>
<?php
} // end of else for if(isset($_GET['edit']))
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
