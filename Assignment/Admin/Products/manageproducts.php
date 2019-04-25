<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The manageproducts.php file
* This page displays all the products in the system
* The administrators can choose to interact with the
* Products available in the system or add a new product
* Through this file
*******************************************************
 -->

<?php require '../Divisions/adminheader.php';?>

<?php
// Get all the products along with their categories
    $stmt = $pdo->prepare('SELECT * FROM products
                          LEFT JOIN categories ON
                          categories.category_id = products.category_id');
    $stmt->execute();

// Get the administrators who have posted the products
    $posted_by = $pdo->prepare('SELECT * FROM users
                                INNER JOIN products
                                ON products.user_id = users.user_id
                                WHERE products.product_id = :product_id');

?>

  <h1>Manage Products:</h1>
<!-- Link to add a new product -->
  <a href = "./addproduct.php"><button class = "addButton">+ Add Another Product</button></a>

  <br>
<!-- Clicking the manage anchor will bring up the viewproducts.php file which allows editing, featuring or deleting a product -->
  <h3>&nbsp;&nbsp; Click Manage to edit or delete a product:</h3>
  <br><br>

  <?php

// The TableGenerator used to display the products in a table
    $tableGenerator = new TableGenerator();
    $tableGenerator->setHeadings(['S.N. ', 'Title', 'Posted By', 'Manufacturer', 'Category', 'Price(£)', 'Image','Date Posted', 'Manage']);
    $count = 1;
    $featured = "";
    while ($key = $stmt->fetch()) {
      $array = ['product_id'=>$key['product_id']];
      $posted_by->execute($array);
      $admin = $posted_by->fetch();
      $posted_by_link = '<a href = "../Admins/viewadministrators.php?edit='.$admin['user_id'].'">'.$admin['fullname'].'</a>';
      if($key['featured']=="yes"){
        $featured = $key['title'];
      }
      $edit = '<a href = "./viewproducts.php?product='.$key['product_id'].'">Manage</a>';
      $img = '<img src="data:image/jpg; base64,'.base64_encode(($key['image'])).'" height = "100" width = "100"/><br><br>';

      $arr = [$count, $key['title'], $posted_by_link, $key['manufacturer'], $key['name'],
      $key['price'], $img, $key['date_posted'], $edit];
      $tableGenerator->addRow($arr);
      $count++;
    }
    echo $tableGenerator->getHTML();
    echo '<br><br><b>Featured Product:</b> '.$featured;
  ?>

<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
