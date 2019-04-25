<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The editproduct.php file
* This allows editing the specified product
* It displays a form with pre-existing values of the
* Product or displays a file input depending on the
* Type of edit selected.
* There are two types of edits that can be performed
* On a particular product. Editing its details or only
* Changing the picture of the product.
******************************************************
 -->
 <?php require '../Divisions/adminheader.php';?>

<?php
  if(isset($_GET['product'])){
    // If the product id is provided
    // Get the product from the provided product id
    $stmt = $pdo->prepare('SELECT * FROM products
                            WHERE product_id = :product_id');
    $arr = ['product_id'=>$_GET['product']];
    $stmt->execute($arr);
    $product = $stmt->fetch();

    // If the action to be performed is selected
    if(isset($_GET['action'])){
      // If the selected action is "edit" and to edit the product details
      // Edit all the details except the image
      if($_GET['action']=="edit"){
        if(isset($_POST['submit'])){
          $stmt = $pdo->prepare('UPDATE products SET title=:title,
                                                     manufacturer=:manufacturer,
                                                     price = :price,
                                                     description = :description,
                                                     category_id = :category
                                                  WHERE product_id = :product_id');

          $criteria = [
            'title'=>$_POST['title'],
            'manufacturer'=>$_POST['manufacturer'],
            'price'=>$_POST['price'],
            'description'=>$_POST['description'],
            'category'=>$_POST['category_id'],
            'product_id'=>$product['product_id']
          ];
          // If the updation is successful
          if($stmt->execute($criteria)){
            echo '<h3>Successfully edited the product.</h3><br><br>';
            echo'<h3><a href = "./manageproducts.php">Click here to view all the products.</a></h3><br><br>';
          }
          else{
            echo '<h3>Error in updating the product</h3>';
          }
        }// end of if(isset($_POST['submit']))
        // Display the product form with pre-existing values
        else{
          $title = $product['title'];
          $manufacturer = $product['manufacturer'];
          $price = $product['price'];
          $description = $product['description'];
          $type = "edit";
          $action = './editproduct.php?product='.$_GET['product'].'&action=edit';
          require '../Divisions/productform.php';
        }// end of else for if(isset($_POST['submit']))

?>

<?php
    }// end of if($_GET['action']=="edit")

      if($_GET['action']=="image"){
    // If the selected action is "image" and to change the product image
        if(isset($_POST['submitimage'])){
          // If the image is submitted
          // Get the file as binary to store it in the database
          $binary = file_get_contents($_FILES['image']['tmp_name']);

          $stmt = $pdo->prepare('UPDATE products SET image=:image
                                                  WHERE product_id = :product_id');

          $criteria = [
            'image'=>$binary,
            'product_id'=>$product['product_id']
          ];

          if($stmt->execute($criteria)){
            echo '<h3>Successfully edited the product image.</h3><br><br>';
            echo'<h3><a href = "./manageproducts.php">Click here to view latest list of products.</a></h3><br><br>';
          }
          else{
            echo '<h3>Error in updating the image.</h3>';
          }
        }// end of if(isset($_POST['submitimage']))
        else{
          // Display the form to select an image file. javascript validation is added to the form so that
          // it does not allow the uploads to be file extensions other than jpg, jpeg, png or svg.
          // the checkImage() is a javascript function. Refer to script.js in the root directory
?>
    <form action ="editproduct.php?product=<?php echo $_GET['product'];?>&action=image" method = "POST" enctype='multipart/form-data'>
      <label>Image of the Product: </label>
      <input type="file" name="image" onchange="checkImage()" id = "imageFile" required/ >
      <p id = "imageTest" style="font-size: 15px; color: red; clear: left;"><br></p>
      <input type = "submit" name = "submitimage" value = "Submit" id = "submission">
    </form>
<?php
        }
      }// end of if($_GET['action']=="image")
    }// end of if(isset($_GET['action']))
} // end of if(isset($_GET['product']))
else {
  echo'<h1>Error! you should not be on this page</h1>';
  echo '<h3><a href = "./manageproducts.php">Click here to return to view latest list of products</a>
  <h3><br><br><br><hr>';
}// end of else for if(isset($_GET['product']))
   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
