
<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The checkout.php file
* It displays the cart items
* This page displays products only when there are
* Products added to the shopping basket
******************************************************
 -->

<?php require './Divisions/header.php';?>

<?php

if(isset($_GET['checkout'])){
  // Redirect to order.php if checkout link is clicked
  header('Location: ./order.php?user='.$_GET['user']);
}


if(isset($_GET['action'])){
  if($_GET['action']=="delete"){
    // If delete link is clicked next to an item in the cart, the item is removed from the cart.
    foreach($_SESSION['cart'] as $key=>$values){
        if($values['product_id']==$_GET['product']){
          unset($_SESSION['cart'][$key]);
        }
    }
    // After removing the product, return to the same page displaying new cart.
    header('Location: ./checkout.php');
  }// end of if($_GET['action']=="delete")
  else if($_GET['action']=="empty"){
    //If empty link is clicked, empty the cart and show that the cart is empty
    unset($_SESSION['cart']);
    header('Location: ./checkout.php');
  }// end of else if($_GET['action']=="empty")

}

if(!empty($_SESSION['cart'])){
  // If the cart is not empty
  $total = 0;
  echo '<div class = "cartTable" style = "text-align: center;">';
  echo '<h3>Your Cart:</h3><br>';

  // The table generator is used to display the products in the cart.
  $tableGenerator = new TableGenerator();
  $tableGenerator->setHeadings(['Product', 'Quantity', 'Image', 'Price(£)', 'Total', 'Delete']);

    foreach($_SESSION['cart'] as $keys => $values){
      $image = '<img src="data:image/jpg; base64,'.base64_encode(($values['image'])).'" style = "width: auto; height: 90px;"/>';
      $delete = '<a style="text-decoration:underline; color: blue;"
                  href = "./checkout.php?action=delete&product='.$values['product_id'].'">
                  Delete</a>';
      $arr = [$values['title'], $values['number'], $image, $values['price'],
             (number_format($values['number']*$values['price'], 2)), $delete];
      $tableGenerator->addRow($arr);
      $total = $total + $values['number']*$values['price'];
    }
    $_SESSION['totalprice']=$total;
    $total = '<b> '.$total.'</b>';
    $arr = [" ", " ", " ", " ", $total, " "];
    $tableGenerator->addRow($arr);
    echo $tableGenerator->getHTML();
    ?>

<br>
<!-- Link to checkout -->
    <a style = "color: blue;" href = "./checkout.php?action=empty">Empty Cart</a>

<?php
// Display the link to checkout only if the user is logged in, otherwise prompt to register or login
  if(isset($_SESSION['loggedin'])){
?>
<br><br><br>
<a href = "./checkout.php?checkout=true&user=<?php echo $loggedin['user_id'];?>">
  <span class = "checkoutButton">
    <img src = "./Images/checkout.svg" height="70px" style="margin-bottom:-20px;">
    <h1 style = "display:inline-block; color: #933EC5;font-size: 35px; font-family: sans-serif; text-decoration: underline;">
      Checkout
    </h1>
  </span>
</a>

<?php
}// end of if(isset($_SESSION['loggedin']))
  else{
?>

<br><br>
<h1 style = "display:inline-block; font-size: 25px; font-family: sans-serif; ">
  You need to be logged in for checking out.
</h1>
<p><a href = "./signin.php?redirect=checkout">Click here to login.</a></p>
<p><a href = "./signup.php">Click here to register.</a></p>

<?php
 }// end of else for if(isset($_SESSION['loggedin']))
}
else{
  // If cart is empty display the message:
  echo'<h1>Your cart is empty 😥</h1>';

}
?>

<?php
   require './Divisions/sidebar.php';
   require './Divisions/footer.php';
 ?>
