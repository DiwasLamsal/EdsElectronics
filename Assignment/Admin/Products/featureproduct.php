<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The featureproduct.php file 						           *
* This file features the specified product           *
******************************************************
 -->

<?php require '../Divisions/adminheader.php';?>


<?php
  $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = :product');
  $arr = ['product'=>$_GET['product']];
  $stmt->execute($arr);
  $product = $stmt->fetch();

// If the user clicks the yes button, feature the product, feature the product.
// Featured products are displayed on the sidebar of customers area.
  if(isset($_GET['response'])&& $_GET['response']=="yes"){
    $stmt = $pdo->prepare('UPDATE products SET featured = :no WHERE featured = :yes');
    $criteria = [
      'no'=>"no",
      'yes'=> "yes"
    ];
    $stmt->execute($criteria);

    $stmt = $pdo->prepare('UPDATE products SET featured = :yes WHERE product_id = :product_id');
    $criteria = [
      'yes'=> "yes",
      'product_id'=>$_GET['product']
    ];

    if($stmt->execute($criteria)){
      echo'<h3>Successfully featured the product.</h3><br>';
      echo '<h3><a href = "./manageproducts.php">Click here to view latest list of products</a>
      <h3><br><br><br><hr>';
    }
  }// end of if(isset($_GET['response'])&& $_GET['response']=="yes")
  else{

?>
<h2>Are you sure you want to feature the product <?php echo $product['title'];?> ?</h2>

<!-- Yes no buttons for confirmation -->
    <a href="./featureproduct.php?product=<?php echo $product['product_id'];?>&response=yes"><button class = "viewButton editButton" style="background: green;  float: left;">
      <img src = "../Images/tick-inside-a-circle.svg" class = "btnImg"><br>Yes</button></a>

    <a href="./viewproducts.php?product=<?php echo $product['product_id'];?>"><button class = "viewButton deleteButton" style="float: left;">
      <img src = "../Images/error.svg" class = "btnImg"><br>No</button></a>

    <br><br><br><br>

 <?php
}// end of else for if(isset($_GET['response'])&& $_GET['response']=="yes")
   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
