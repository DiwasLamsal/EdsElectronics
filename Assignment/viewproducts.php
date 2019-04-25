<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The viewproducts.php file for the customers        *
* This file displays the products in the system      *
******************************************************
 -->

<?php require './Divisions/header.php';
      require './Divisions/displaysorting.php';
?>

<?php
// If a category is selected to view the products
  if(isset($_GET['category'])){
    echo '<br><br><br>';
    global $pdo;

    // If the search select menu is used to sort the products and the sorting type is rating
    if($sorter=='rating'){
      $sorter="product_id";
      $stmt = $pdo->prepare('SELECT *, AVG(rating) rt FROM products
                            INNER JOIN ratings ON
                            ratings.product_id = products.product_id
                            GROUP BY products.product_id
                            HAVING category_id = :category_id
                            ORDER BY rt '.$sorttype);
    }
    // If the search select menu is used to sort the products and the sorting type is not rating
    else{
    $stmt = $pdo->prepare('SELECT * FROM products
                         WHERE category_id = :category_id
                         ORDER BY '.$sorter.' '.$sorttype);
    }
// Get all the products within that category
    $criteria = [
      'category_id'=>$_GET['category']
    ];

    $stmt->execute($criteria);
// If no products were found, a message is displayed
    if($stmt->rowCount()==0){
      echo '<h1>No Products in this Category! 😥';
    }

// The showproduct function is called which displays every products retrieved in a list

    echo '<ul class = "products">';
    while($key=$stmt->fetch()){
      showproduct($key);
    }
    echo '</ul>';
  }// end of if(isset($_GET['category']))

  // If a search term is entered to search for products
  else if(isset($_GET['search'])){

    echo '<h2>Search term: '.$_GET['search'].'</h2>';
    // If the search select menu is used to sort the products and the sorting type is rating
    if($sorter=='rating'){
      $sorter="product_id";
      $stmt = $pdo->prepare('SELECT *, AVG(rating) rt FROM products
                            INNER JOIN ratings ON
                            ratings.product_id = products.product_id
                            GROUP BY products.product_id
                            HAVING COUNT(rating)>0
                            AND title LIKE :title
                            ORDER BY rt '.$sorttype);
    }
    // If the search select menu is used to sort the products and the sorting type is not rating
    else{
    $stmt=$pdo->prepare('SELECT * FROM products WHERE title LIKE :title
                         ORDER BY '.$sorter.' '.$sorttype);
    }
// Get all the products that match the search term using the LIKE keyword
    $arr = ['title'=>'%'.$_GET['search'].'%'];
    $stmt->execute($arr);

    if($stmt->rowCount()==0){
      echo '<h2>No products found that match the search term <b>\''.$_GET['search'].'\'</b> 😥</h2>';
    }
    echo '<ul class = "products">';
// Display the found products in a suitable list by using showproduct function
    while($key = $stmt->fetch()){
        showproduct($key);
    }
    echo '</ul>';
  }// end of else if(isset($_GET['search']))
// If no conditions are used to search for a product, all the products are listed
  else{
?>

<h1>Products:</h1>


<?php
  // If the search select menu is used to sort the products and the sorting type is rating
  if($sorter=='rating'){
    $stmt = $pdo->prepare('SELECT *, AVG(rating) rt FROM products
                          INNER JOIN ratings ON
                          ratings.product_id = products.product_id
                          GROUP BY products.product_id
                          HAVING COUNT(rating)>0
                          ORDER BY rt '.$sorttype);
  }
  // If the search select menu is used to sort the products and the sorting type is not rating
  else{
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY '.$sorter.' '.$sorttype);
  }
  $stmt->execute();

//Get all the products from the database and display them
echo '<ul class = "products">';
  while($key = $stmt->fetch()) {
    showproduct($key);
  }
echo '</ul>';

?>

 <?php
}
   require './Divisions/sidebar.php';
   require './Divisions/footer.php';
 ?>
