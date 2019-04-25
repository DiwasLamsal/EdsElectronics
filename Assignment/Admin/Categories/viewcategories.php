<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The viewcategories.php file							           *
* The file displays details about a selected category*
* The file also provides options to delete or edit   *
* the selected category                              *
******************************************************
 -->
 <?php
       require '../Divisions/adminheader.php';
       require '../../Divisions/checkExisting.php';
 ?>
<?php

// If the value of edit is passed as a get variable, this block of code will execute and the selected
// category's details will be displayed
  if(isset($_GET['edit'])){
      $stmt = $pdo->prepare('SELECT category_id, name FROM categories
                              WHERE category_id = :category_id');

      $arr = ['category_id'=>$_GET['edit']];
      $stmt->execute($arr);
      $cat = $stmt->fetch();

      $stmt = $pdo->prepare('SELECT categories.category_id,  COUNT(products.category_id)
                              AS NumberOfProducts FROM categories
                              INNER JOIN products ON
                              products.category_id=categories.category_id
                              GROUP BY products.category_id
                              HAVING products.category_id = :category_id');

      $stmt->execute($arr);
      $proCat = $stmt->fetch();
  }// end of if(isset($_GET['edit']))

// If the value of action is set and the passed value is "edit", this block of code will run
// This block will update the category name if another category with the same name does not exist
// The function checkCategory() will check and return a boolean relaying whether the name is taken
  if(isset($_GET['action']) && $_GET['action']=="edit"){
    if(isset($_POST['submit']) && !(ctype_space($_POST['name']))){
      $stmt = $pdo->prepare('UPDATE categories SET name = :name WHERE category_id = :category_id');
      $criteria = ['name'=>$_POST['name'],'category_id'=>$_GET['edit']];
      if(checkCategory() && $stmt->execute($criteria)){
        echo '<h3>Succesfully edited category name to '.$_POST['name'].'.</h3><br><br>';
        echo '<h3><a href = "./managecategories.php">Click here to return to view latest list of categories.</a>
        <h3><br><br><br><hr>';

      }// end of if(checkCategory() && $stmt->execute($criteria))

      else if(!checkCategory()){
        $cattext = '<p style="font-size: 15px; color: red; clear: left;">Category specified already exists.</p>';
        require '../Divisions/categoryform.php';

      } // end of else if(!checkCategory())
    }// end of if(isset($_POST['submit']))

    // This block of code will not let the category name be a whitespace
    else if(isset($_POST['submit']) && (ctype_space($_POST['name']))){
      $cattext = '<p style="font-size: 15px; color: red; clear: left;">Category name cannot be blank!</p>';
      require '../Divisions/categoryform.php';

    } // end of else if(isset($_POST['submit']) && (ctype_space($_POST['name'])))
    else{
      $cattext = '<p style="font-size: 15px; color: red; clear: left;"></p>';
      require '../Divisions/categoryform.php';

    }//end of else for end of if(isset($_POST['submit']))
  }// end of if(isset($_GET['action']) && $_GET['action']=="edit")
  elseif(isset($_GET['action']) && $_GET['action'] == "delete"){
    header('Location: ./deletecategories.php?edit='.$_GET['edit']);

  }//end of elseif(isset($_GET['action']) && $_GET['action'] == "delete")
  else{
?>
<hr><br>

<!-- The view and edit buttons -->
<a  <?php if($proCat['NumberOfProducts']==0){?>href = "./viewcategories.php?<?php echo 'edit='.$cat['category_id'].'&action=delete';}?>">
  <button class = "viewButton deleteButton"><img src = "../Images/rubbish-bin.svg" class = "btnImg"><br>Delete</button>
</a>


<a href = "./viewcategories.php?<?php echo 'edit='.$cat['category_id'].'&action=edit';?>">
  <button class = "viewButton editButton"><img src = "../Images/149307.svg" class = "btnImg"><br>Edit Name</button>
</a>
<!-- The category details -->
<br>

  <h3>Category Details: </h3><br>

  <p>
    <b>Category ID: </b><?php echo $cat['category_id'];?><br><br>
    <b>Category Name: </b><?php echo $cat['name'];?><br><br>
    <b>Total products in Category: </b><?php if($proCat['NumberOfProducts']=="")echo"0"; else echo$proCat['NumberOfProducts'];?><br><br>
<?php if($proCat['NumberOfProducts']>0){?>
    <b style = "color: red;">*Note: You cannot delete this category because there are products under it.</b>
<?php }
      else{?>
    <b style = "color: green;">Deleting this category will not delete any products.</b>
<?php }?>
  </p>
<hr>


 <?php
} // end of if for if(isset($_GET['action']) && $_GET['action']=="edit")
   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
