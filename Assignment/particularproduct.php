<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The particularproduct.php file
* This file displays all the details about a product
* It also allows logged in users to add a review
* Update - It now allows adding items to a cart
*           and editing the cart
* Update - The radio buttons for stars are now
*           as stars
******************************************************
 -->
<?php require './Divisions/header.php';?>
<?php
// The variable holds the message to be displayed if a product has already been added to the cart and is
// attempted to be added again
  $messageAlreadyAdded = "";

// Addition of the shopping basket feature was mostly done with the help of a YouTube video at:
// https://www.youtube.com/watch?v=0wYSviHeRbs


// If the action is set for editing the cart
  if(isset($_GET['action'])){
    if($_GET['action']=="delete"){
      // If user selects to delete an item from the cart
      // Unset the array where the product exists
      foreach($_SESSION['cart'] as $key=>$values){
          if($values['product_id']==$_GET['product']){
            unset($_SESSION['cart'][$key]);
          }
      }
      header('Location: ./particularproduct.php?product='.$_GET['product']);
    }// end of if($_GET['action']=="delete")
    else if($_GET['action']=="empty"){
      // If user selects to empty the cart, unset the whole $_SESSION['cart'] variable
      unset($_SESSION['cart']);
      header('Location: ./particularproduct.php?product='.$_GET['product']);
      $messageAlreadyAdded = "Cart Deleted!";
    }// end of else if($_GET['action']=="empty")

  }// end of if(isset($_GET['action']))

  if(isset($_POST['addtocart'])){
    $stmt = $pdo->prepare('SELECT product_id, title, price, image FROM products WHERE product_id = :product_id');
    $arr = ['product_id'=>$_POST['product']];
    $stmt->execute($arr);
    $product = $stmt->fetch();

    if(isset($_SESSION['cart'])){
      // If the cart already exists, add the item to the cart dynamically
      // The array_column function returns the column product_id from the array
      // It is checked whether the specified item is already in the cart
      $array_number = array_column($_SESSION['cart'], "product_id");
      if(in_array($product['product_id'], $array_number)){
        // If the attempted item is already in the cart, set the message variable to notifying text
        $messageAlreadyAdded = '<h3 style = "color: red;">
                                  *You have already added this product to your cart!
                                </h3>';
      }
      else{
        // If the item does not exist in the array,
        // Add the item to the cart array
        // Array indexes begin from 0, while count gives total size of an array, thus it can be used to
        // Define the next index of an array
        $total = count($_SESSION['cart']);
        $item = [
          'product_id'=>$product['product_id'],
          'title'=>$product['title'],
          'image'=>$product['image'],
          'price'=>$product['price'],
          'number'=>$_POST['number']
        ];
        $_SESSION['cart'][$total]=$item;
      // When the cart is updated, reload the page to display the latest cart details
        header('Location: ./particularproduct.php?product='.$_GET['product']);
      }

    }// end of if(isset($_SESSION['cart']))
    else{
    // If the cart does not exist, create the cart and add the first item to it manually
      $item = [
        'product_id'=>$product['product_id'],
        'title'=>$product['title'],
        'image'=>$product['image'],
        'price'=>$product['price'],
        'number'=>$_POST['number']
      ];
      $_SESSION['cart'][0]=$item;

      header('Location: ./particularproduct.php?product='.$_GET['product']);

    }// end of else for if(isset($_SESSION['cart']))


  }// end of if(isset($_POST['addtocart']))
?>

<?php
// The $reviewPost variable holds the message to be displayed when review is posted
  $reviewPost = "";
  if(isset($_GET['product']) && isset($_POST['submit']) && $_GET['product']!=""){

// If the review poster is an administrator, it is not on hold in the reviews section to be manually approved,
// Whereas, by default, the administrator reviews are posted
    if(isset($_SESSION['loggedin'])&& $loggedin['type']=="admin"){
      $stmt=$pdo->prepare('INSERT INTO reviews(user_id, product_id, review_text, date_posted, approved)
                            VALUES(:user_id, :product_id, :review_text, :date_posted, :approved)');
      $criteria = [
        'user_id'=>$_POST['user_id'],
        'product_id'=>$_POST['product_id'],
        'review_text'=>$_POST['review_text'],
        'date_posted'=>date('Y-m-d'),
        'approved'=>"yes"
      ];
      $stmt->execute($criteria);
    }// end of if(isset($_SESSION['loggedin'])&& $loggedin['type']=="admin")
// For a customer, the reviews are placed on hold until an administrator approves it
// The $reviewPost variable stores the message for the customers when they successfully post a review
    else{
      $stmt=$pdo->prepare('INSERT INTO reviews(user_id, product_id, review_text, date_posted)
                            VALUES(:user_id, :product_id, :review_text, :date_posted)');
      $criteria = [
        'user_id'=>$_POST['user_id'],
        'product_id'=>$_POST['product_id'],
        'review_text'=>$_POST['review_text'],
        'date_posted'=>date('Y-m-d')
      ];
      if($stmt->execute($criteria)){
        $reviewPost = "Success! Review queued for approval. The review will appear once our Administrators approve it.";
      }

      if(isset($_POST['rating'])){
        // If the user adds a rating as well, the rating is added to the ratings table for the selected product
        $insertRating = $pdo->prepare('INSERT INTO ratings(user_id, product_id, rating) VALUES(:user_id, :product_id, :rating)');
        $criteria = [
          'user_id'=>$loggedin['user_id'],
          'product_id'=>$_POST['product_id'],
          'rating'=>$_POST['rating']
        ];
        if($insertRating->execute($criteria))
          $reviewPost.='<br><br>You gave the product a rating of '.$_POST['rating'].'</b>';

      }// end of if(isset($_POST['rating']))

    }// end of else for if(isset($_SESSION['loggedin'])&& $loggedin['type']=="admin")
  }// end of if(isset($_GET['product']) && isset($_POST['submit']) && $_GET['product']!="")
  if(isset($_GET['product']) && $_GET['product']!=""){
    global $pdo;
    $stmt = $pdo->prepare('SELECT *, name FROM products
                            INNER JOIN categories ON
                            products.category_id = categories.category_id
                            WHERE product_id = :product_id');
    $criteria = [
      'product_id'=>$_GET['product']
    ];
    $stmt->execute($criteria);
    $row = $stmt->fetch();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Display product ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$productid = $_GET['product'];

// Display the product details beginning with the rating

echo '<b> Product Rating: </b>';
// The displayrating.php file shows the rating of the product in stars
require './Divisions/displayrating.php';

    echo'<div class = "products" style = "text-align: center; background: white; border-bottom: 5px groove olive;">';

    if(isset($_SESSION['loggedin']) && $loggedin['type']=="admin"){
      echo'<h4 style = "float: left; text-decoration: underline;">
            <a target="_blank" href = "./Admin/Products/viewproducts.php?product='.$row['product_id'].'">
              Edit this product
            </a></h4>';
    }

    echo '<br><br><br><h2>'.$row['title'].'</h2><br>';
    echo '<img src="data:image/jpg; base64,'.base64_encode(($row['image'])).'" style = "width: auto; height: 400px;"/>
    <br><br>';

    // The current link of the webpage https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
    // This works for both https or http protocols but not tested in localhost environment
    $actual_link = (isset($_SERVER['HTTPS']))? "https" : "http" . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Share social buttons ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<!-- The facebook share button does not work in localhost environment and requires an online setup -->
<br><br>
<iframe src="https://www.facebook.com/plugins/share_button.php?href=<?php echo $actual_link;?>&layout=button&size=large&mobile_iframe=true&width=73&height=28&appId"
  width="73" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media">
  Facebook Share</iframe>

<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" ></a>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8">Tweet</script>
<br><br><br>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Share social buttons ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->


<?php
    echo '<p><strong>Manufactured By: </strong>'.$row['manufacturer'].'</p><br>';
    echo '<p>'.$row['description'].'</p><br><br>';
    echo '<p><b>Product Category: </b>'.$row['name'].'</p>';


// The add to cart button and input for quantity of products
// An administrator will not see this because they will not be able to add products to cart
    if(!isset($_SESSION['loggedin']) || $loggedin['type']!="admin")
    echo '
    <div class = "cart" style = "float: left;">
      <form action ="particularproduct.php?action=add&product='.$row['product_id'].'" method = "POST" style = "border: none; padding: 0;">
        <input type = "hidden" name = "product" value = "'.$row['product_id'].'">
        <input type = "number" min="1" value ="1" name = "number" >
          <input type = "submit" name = "addtocart" value = "Add to Cart" style = "margin-top: -42px;">
        </a>
        </form>
    </div>';

    echo '<p class = "price"><strong>Price: £</strong>'.$row['price'].'</p><br><br>';

// If there are items added to the cart, they are displayed in a tabular format using the TableGenerator
  if(!empty($_SESSION['cart'])){
    $total = 0;
    echo '<div class = "cartTable" style = "text-align: center;">';
    echo '<h3>Your Cart:</h3><br>';
    $tableGenerator = new TableGenerator();
    $tableGenerator->setHeadings(['Product', 'Quantity', 'Image', 'Price', 'Total', 'Delete']);

      foreach($_SESSION['cart'] as $keys => $values){
        $image = '<img src="data:image/jpg; base64,'.base64_encode(($values['image'])).'" style = "width: auto; height: 90px;"/>';
        $delete = '<a style="text-decoration:underline; color: blue;"
                    href = "./particularproduct.php?action=delete&product='.$values['product_id'].'">
                    Delete</a>';
        $arr = [$values['title'], $values['number'], $image, $values['price'],
               (number_format($values['number']*$values['price'], 2)), $delete];
        $tableGenerator->addRow($arr);
        $total = $total + $values['number']*$values['price'];
      }
      $total = '<b>'.$total.'</b>';
      $checkout = '<a style="text-decoration:underline; color: green;" href  = "./checkout.php">Checkout</a>';
      $arr = [" ", " ", " ", " ", $total, $checkout ];
      $tableGenerator->addRow($arr);
      echo $tableGenerator->getHTML();
      echo '<br>'.$messageAlreadyAdded;

// Link to empty the cart
      echo'<br><a style="text-decoration: underline; color: blue;"
          href = "./particularproduct.php?action=empty&product='.$_GET['product'].'">Empty Cart</a>';

  }

    echo '<br>
    <br>';
?>


<br></div><br>


<!--- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Reviews section starts here ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->


<?php

    echo'</div>';

// Get all the reviews for the particular product
    $review=$pdo->prepare('SELECT reviews.review_id, reviews.user_id, reviews.review_text,
                           reviews.date_posted, reviews.approved, users.fullname, users.type
                           FROM reviews
                           INNER JOIN products ON reviews.product_id = products.product_id
                           INNER JOIN users ON reviews.user_id = users.user_id
                           WHERE reviews.product_id = :product_id
                           AND reviews.approved = :approved
                           ORDER BY reviews.review_id');
    $criteria = [
      'product_id'=>$_GET['product'],
      'approved'=>"yes"
    ];

    $review->execute($criteria);

//If there are reviews added to the product, display them in a list:
    if($review->rowCount()>0){

      echo'<ul class="reviews" style="margin-top:-2px; border-bottom: 5px groove olive; ">';
      echo '<h3 style = "text-align: left; background: rgba(0,100,255,0.1)"><br>&nbsp; Product reviews:</h3>';

      while($key = $review->fetch()){
        if($key['approved']=="yes"){
          if($key['type']=="admin"){
            $style = 'style = "background: tomato;"';
          }
          else {
            $style = " ";
          }
// Display the users' initials in the form of avatars where administrators will have a tomato background color
          echo'<li>';
            echo'<a href = "./user.php?user='.$key['user_id'].'">
                  <span class = "avatar" '.$style.'>'.getInitials($key['fullname']).'</span>
                  </a>';  //Function called at header.php
            echo'<p>'.$key['review_text'].'</p>
              <br><br><br>
              <div class="details">
                -
                <strong><a href = "./user.php?user='.$key['user_id'].'" style ="color: green;">'.$key['fullname'].'</a></strong>
                <strong>'.$key['type'].'</strong>
                <em>'.date_format(date_create($key['date_posted']), "Y/m/d").'</em>
              </div>
            </li>';
        }
      }

    ?>
    </ul>
    <br><br>

<?php
}// end of if($review->rowCount()>0)
// If there are no reviews added to the product, display the message
  else {
    echo '<h4 style = "text-align: left;"> &nbsp;&nbsp;&nbsp;No reviews added to this product yet.</h4>';
  }
?>

<!-- Section to post a review -->
<!-- If a user is not logged in, they cannot post a review and the message to login or register is displayed -->
      <h4 style = "text-align: left;">
<?php if(!isset($_SESSION['loggedin'])){?>
         &nbsp;&nbsp;&nbsp;Want to add a review? Only registered users can add a review. <a href = "./signup.php">Click here to register.</a><br>
         &nbsp;&nbsp;&nbsp;Already have an account?
         <a href = "./signin.php?product=<?php echo $_GET['product'];?>">Click here to log in</a>
<?php
  }
  // If the user posted a review and the message in the $reviewPost variable is to be displayed
  elseif ($reviewPost!="") {
    echo $reviewPost;
  }
  else{
    // If the user is logged in and yet to add a review
?><br>Add a review to the product:</h4>
      <br>
      <form action="./particularproduct.php?product=<?php echo $_GET['product'];?>" method="post">

<?php
// Display the rating option to a customer who has not previously rated the product
  if(isset($_SESSION['loggedin']) && $loggedin['type']=="customer"){

// Check if user already rated the same product.
    $stmt = $pdo->prepare('SELECT * FROM ratings WHERE user_id = :user_id AND product_id = :product_id');
    $criteria = [
      'user_id'=>$loggedin['user_id'],
      'product_id'=>$_GET['product']
    ];
    $stmt->execute($criteria);

    if($stmt->rowCount()==0)
      require './Divisions/ratingform.php';
    else {// If the user has already rated the product, display the message
      echo '<label style = "clear: both; float: left;;"><b>You have already rated this product.</b></label><br><br>';
    }
  }
?>

<!-- The form to submit a review -->
        <input type = "hidden" name = "user_id" value = "<?php echo $_SESSION['loggedin'];?>">
        <input type = "hidden" name = "product_id" value = "<?php echo $_GET['product'];?>">
        <label>Review: </label> <textarea name = "review_text" placeholder="Your review text here..." required></textarea>

        <input type="submit" name="submit" value="Submit" />
      </form>

<?php
    }
} // end of if(isset($_GET['product']) && $_GET['product']!="")
else {
  // If the $_GET['product'] variable is not set, redirect to viewproducts.php
  header("Location: ./viewproducts.php");
}

   require './Divisions/sidebar.php';
   require './Divisions/footer.php';
 ?>
