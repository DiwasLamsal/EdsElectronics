<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The user.php file for the customers
* This file displays the selected
* User and lists their reviews
******************************************************
 -->

<?php require './Divisions/header.php';?>

<!-- Get the reviews and user details for the selected user -->
<?php
  $stmt = $pdo->prepare('SELECT * FROM reviews INNER JOIN users ON users.user_id = reviews.user_id WHERE reviews.user_id = :user_id');
  $user = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');
  $arr= ['user_id'=>$_GET['user']];
  $user->execute($arr);
  $reviewer = $user->fetch();

// Get the product for which each review was posted
  $product = $pdo->prepare('SELECT * FROM products INNER JOIN reviews ON products.product_id = reviews.product_id
                            WHERE reviews.product_id = :product_id');

  echo '<h2 style = "text-align: center;">Reviews by '.$reviewer['fullname'].'</h2>';

  echo'<ul class="reviews" style="margin-top:-2px; border-bottom: 5px groove olive;">';


  $stmt->execute($arr);
// Display the reviews in the form of lists

  while($key = $stmt->fetch()){
    if($key['approved']=="yes"){
      $criteria = ['product_id'=>$key['product_id']];
      $product->execute($criteria);
      $reviewed = $product->fetch();
      // If the user is admin, change the color of avatar to tomato
      if($key['type']=="admin"){
        $style = 'style = "background: tomato; border-color: purple;"';
      }
      else {
        $style = " ";
      }
      echo '<li>';
      echo '<b>Product: </b> <a href = "particularproduct.php?product='.$reviewed['product_id'].'">'. $reviewed['title'].'</a>';

      echo'<br><br>';

// The getInitials function returns the initials for a name passed as an argument
// These initials are used to display the avatar for a user

      echo'<a href = "./user.php?user='.$key['user_id'].'">
            <span class = "avatar" '.$style.'>'.getInitials($key['fullname']).'</span>
            </a>';  //Function called at header.php

      echo'<p>'.$key['review_text'].'</p>
          <div class="details">
            <b>Posted on: </b>

            <em>'.$key['date_posted'].'</em>
          </div>
        </li>';

    }
  }
  echo '</ul>';
?>

<?php

   require './Divisions/sidebar.php';
   require './Divisions/footer.php';
 ?>
