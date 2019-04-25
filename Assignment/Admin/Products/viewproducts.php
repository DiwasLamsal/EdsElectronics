<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The viewproducts.php file
* This file shows the details about the selected
* Product
* It provides available actions to the administrators
* That can be performed on the product
******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>
<?php
  if(isset($_GET['product'])){
    // The page only works if the product id is available
    // Get the product's details and it's category
    $stmt = $pdo->prepare('SELECT *, name FROM products
                            INNER JOIN categories ON
                            categories.category_id = products.category_id
                            WHERE product_id = :product_id');
    $arr = ['product_id'=>$_GET['product']];
    $stmt->execute($arr);
    $product = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT * FROM users
                                INNER JOIN products
                                ON products.user_id = users.user_id
                                WHERE products.product_id = :product_id');

    $array = ['product_id'=>$product['product_id']];
    $stmt->execute($array);
    $admin = $stmt->fetch();
    $posted_by_link = '<a style = "color: black;" href = "../Admins/viewadministrators.php?edit='.$admin['user_id'].'">'.$admin['fullname'].'</a>';

    if(isset($_GET['action'])){
      // If the action is set, redirect the page to respective actions
      if($_GET['action']=="edit" || $_GET['action']=="image" )
        header('Location: ./editproduct.php?product='.$product['product_id'].'&action='.$_GET['action']);
      else if ($_GET['action']=="delete" ){
        header('Location: ./deleteproduct.php?product='.$product['product_id'].'&action='.$_GET['action']);
      }
      else if ($_GET['action']=="feature" ){
        header('Location: ./featureproduct.php?product='.$product['product_id'].'&action='.$_GET['action']);
      }
    }
    else{
      // If any action is not selected, display the product details.
?>
<hr>

<br>
  <h3>Product Details: </h3>
  <br>

<!-- Buttons for performing an action on the product -->
  <a href = "./viewproducts.php?<?php echo 'product='.$product['product_id'].'&action=delete';?>">
    <button class = "viewButton deleteButton" style="margin-top:45px;">
      <img src = "../Images/rubbish-bin.svg" class = "btnImg"><br>Delete</button>
  </a>

  <a href = "./viewproducts.php?<?php echo 'product='.$product['product_id'].'&action=edit';?>">
    <button class = "viewButton editButton" style="margin-top:45px;">
      <img src = "../Images/149307.svg" class = "btnImg"><br>Edit</button>
  </a>

  <a href = "./viewproducts.php?<?php echo 'product='.$product['product_id'].'&action=feature';?>">
    <button class = "viewButton editButton" style="background:#32CD32; margin-top: 5px; clear:both; float: right;">
      <img src = "../Images/browser.svg" class = "btnImg">Feature</button>
  </a>

  <a href = "./viewproducts.php?<?php echo 'product='.$product['product_id'].'&action=image';?>">
    <button class = "viewButton editPasswordButton" style="margin-top: 5px;">
      <img src = "../Images/picture.svg" class = "btnImg"><br>Edit Image</button>
  </a>

  <p>
    <b>Product Image:</b><br><br>
<!-- Display the product image as base64_encode because it is stored in the form of binary BLOB in the database -->
    <?php echo'<img src="data:image/jpg; base64,'.base64_encode(($product['image'])).'"
    style = "border: 5px inset rgba(0,100,255,0.6); width: auto; height: 330px;" /><br><br>';?>

    <b>Product Title: </b><?php echo $product['title'];?><br><br>
    <b>Product Category: </b><?php echo $product['name'];?><br><br>
    <b>Product Manufacturer: </b><?php echo $product['manufacturer'];?><br><br>
    <b>Product Price: </b> £<?php echo $product['price'];?><br><br>
    <b>Product Description: </b><?php echo $product['description'];?><br><br>
    <b>Posted By: </b><?php echo $posted_by_link;?><br><br>
  </p>
<hr>


 <?php
  }
}// end of if(isset($_GET['product']))


else {
  echo'<h1>Error! you should not be on this page</h1>';
  echo '<h3><a href = "./manageproducts.php">Click here to return to view latest list of products</a>
  <h3><br><br><br><hr>';

}// end of else for if(isset($_GET['product']))
   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
