<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The productform.php file
* This file contains the form for creating or
* Editing a product
******************************************************
 -->

<!-- The form will dynamically grab the product details if the administrator is editing a product -->
<!-- The enctype='multipart/form-data' is included as this form relates to uploading and storing an image -->

<form action = "<?php echo $action;?>" method = "POST" enctype='multipart/form-data'>
  <label>Product Title:</label><input type = "text" name = "title" value = "<?php echo $title; ?>" required>
  <label>Product Manufacturer: </label><input type = "text" name = "manufacturer" value = "<?php echo $manufacturer; ?>" required>
  <label>Product Price(£):</label><input type = "text" name = "price" value = "<?php echo $price; ?>" required>
  <label>Product Description: </label><textarea name = "description" required><?php echo $description; ?></textarea>
  <label>Product Category: </label>

<!-- The select menu dynamically retrieves available categories -->
  <select name = "category_id" style="float: left; margin-top: 15px; width: 46%; height: 50px;">
    <?php
     global $pdo;
     $stmt = $pdo->prepare("SELECT * FROM categories");
     $stmt->execute();
     while($row = $stmt->fetch()){
       echo'<option value = "'.$row['category_id'].'">'.$row['name'].'</option>';
     }
    ?>
  </select>
<!-- The input[type=file] will not appear if the product is being edited, instead, there is a separate
      form for changing only the image of the product. -->
<?php if($type == "add"){?>
  <label>Image of the Product: </label>
  <input type="file" name="image" onchange="checkImage()" id = "imageFile" required/ >
  <p id = "imageTest" style="font-size: 15px; color: red; clear: left;"><br></p>
<?php }?>
  <input type = "submit" name = "submit" value = "Submit" id = "submission">
</form>
