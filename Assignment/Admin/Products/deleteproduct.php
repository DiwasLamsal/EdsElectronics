<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The deleteproduct.php file
* This file prompts to delete a product and deletes it
******************************************************
 -->

<?php require '../Divisions/adminheader.php';?>
<?php
  if(isset($_GET['product'])){
    $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = :product');
    $delete = $pdo->prepare('DELETE FROM products WHERE product_id = :product');

    $arr = ['product'=>$_GET['product']];
    $stmt->execute($arr);
    $product = $stmt->fetch();


    if(isset($_GET['response'])){
      // A featured product is not allowed to be deleted
      if($product['featured']=="yes"){
        echo '<h1>Cannot Delete a featured Product. Please set a different product to featured and then delete this product.</h1>';
      }
      // Otherwise the product is deleted
      else if($product['featured']!="yes"&&$delete->execute($arr)){
        echo '<h3>The product <b>'.$product['title'].'</b> was deleted succesfully.</h3><br><br>';
        echo '<h3><a href = "./manageproducts.php">Click here to view latest list of products</a>
        <h3><br><br><br><hr>';
      }

    }//end of if(isset($_GET['response']))
    else{
?>
<h2>You are about to remove the product <?php echo $product['title'];?>. Are you sure?</h2>

<!-- The buttons that prompt the user to delete the product or not -->
<a href="./deleteproduct.php?product=<?php echo $product['product_id'];?>&response=yes"><button class = "viewButton editButton" style="background: green;  float: left;">
  <img src = "../Images/tick-inside-a-circle.svg" class = "btnImg"><br>Yes</button></a>

<a href="./viewproducts.php?product=<?php echo $product['product_id'];?>"><button class = "viewButton deleteButton" style="float: left;">
  <img src = "../Images/error.svg" class = "btnImg"><br>No</button></a>

<?php
  }// end of else for if(isset($_GET['response']))
}//end of if(isset($_GET['product']))
else{
    ?>

  <h1> Error! You should not be on this page!</h1>

<?php
}// end of else for if(isset($_GET['product']))

?>


<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
