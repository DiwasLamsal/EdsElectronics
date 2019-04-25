<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
 * The vieworders.php file
 * This is the page where the admin manages an
 * order placed by customers.
 * The page can be used to mark an order as shipped,
 * pending, or delete the order
*******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>

<?php
if(isset($_GET['order'])){
// If an action is set:
  if(isset($_GET['action'])){
    // Mark the order as shipped
    if($_GET['action']=="shipped"){
      $stmt = $pdo->prepare('UPDATE orders SET status = :status, date_delivered = :date_delivered WHERE order_id = :order_id');
      $date = date('Y-m-d H:i:s');
      $criteria = [
        'status'=>"shipped",
        'date_delivered'=>$date,
        'order_id'=>$_GET['order']
      ];
      if($stmt->execute($criteria)){
        header('Location: ./manageorders.php?message=Order+marked+as+shipped');
      }
    }// end of if($_GET['action']=="shipped")
    else if($_GET['action']=="pending"){
      // Mark the order as pending
      $stmt = $pdo->prepare('UPDATE orders SET status = :status, date_delivered = :date_delivered WHERE order_id = :order_id');
      $date = date('Y-m-d H:i:s');
      $criteria = [
        'status'=>"pending",
        'date_delivered'=>"0000-00-00 00:00:00",
        'order_id'=>$_GET['order']
      ];
      if($stmt->execute($criteria)){
        header('Location: ./manageorders.php?message=Order+marked+as+pending');
      }
    }//end of else if($_GET['action']=="pending")
    else if($_GET['action']=="delete"){
      // Delete the order
      $stmt = $pdo->prepare('DELETE FROM orders WHERE order_id = :order_id');
      $criteria = [
        'order_id'=>$_GET['order']
      ];
      if($stmt->execute($criteria)){
        header('Location: manageorders.php?message=Deleted+Order');
      }
    }// end of else if($_GET['action']=="delete")
  }// end of if(isset($_GET['action']))


  $orderUsers = $pdo->prepare('SELECT *, users.fullname, users.email FROM orders
                                INNER JOIN users ON users.user_id = orders.user_id
                                WHERE orders.order_id ='.$_GET['order']);
  $orderUsers->execute();
  $orderuser = $orderUsers->fetch();

?>

<hr><br><br>

<!-- The buttons as actions that can be performed on the selected order -->

<a href = "./vieworders.php?<?php echo 'order='.$_GET['order'].'&action=delete';?>">
  <button class = "viewButton editButton" style="margin-top:45px; background: black;">
    <img src = "../Images/rubbish-bin.svg" class = "btnImg"><br>Delete</button>
</a>

<a href = "./vieworders.php?<?php echo 'order='.$_GET['order'].'&action=pending';?>">
  <button class = "viewButton deleteButton" style="margin-top:45px;">
    <img src = "../Images/pending.svg" class = "btnImg"><br>Mark Pending</button>
</a>

<a href = "./vieworders.php?<?php echo 'order='.$_GET['order'].'&action=shipped';?>">
  <button class = "viewButton editButton" style="margin-top:45px; background: green;">
    <img src = "../Images/shipped.svg" class = "btnImg"><br>Mark Shipped</button>
</a>


<!-- The details of order and the user that placed the order -->

  <h3>Order Details: </h3>
  <br>

  <p>
    <b>Order By: </b><?php echo $orderuser['fullname'];?><br><br>
    <b>Orderer Email: </b><?php echo $orderuser['email'];?> <br><br>
    <b>Orderer Contact Number: </b><?php echo $orderuser['contact'];?> <br><br>
    <b>Address: </b><?php echo $orderuser['street_address'].', '.$orderuser['city'].', '.$orderuser['country'];?><br><br>
    <b>Order Status: </b><?php echo $orderuser['status'];?> <br><br>
    <b>Date Of Order: </b><?php echo $orderuser['date_purchased'];?><br><br>
    <b>Date Delivered: </b><?php
      if($orderuser['date_delivered']=="0000-00-00 00:00:00") echo'Pending delivery';
      else echo $orderuser['date_delivered'];
      ?><br><br>
  </p>

<hr><br><br>

<?php
  $cartProducts = $pdo->prepare('SELECT cart_items.cart_item_id, cart_items.quantity,
                                 cart_items.price, products.title, products.image, products.price prc
                                 FROM cart_items INNER JOIN products
                                 ON cart_items.product_id = products.product_id
                                 WHERE cart_items.order_id = '.$_GET['order']);

  $cartProducts->execute();
?>

<!-- The table that displays the cart for the specified order -->

  <h3>Order Items: </h3>
<br><br>
<?php
  $tableGenerator = new TableGenerator();
  $tableGenerator->setHeadings(['Cart Item ID', 'Product Title', 'Product Image', 'Price', 'Quantity', 'Total Price']);
  $total = 0;
  while ($key = $cartProducts->fetch()) {
    $image = '<img src="data:image/jpg; base64,'.base64_encode(($key['image'])).'" style = "width: auto; height: 90px;"/>';
    $arr = [$key['cart_item_id'], $key['title'], $image, $key['prc'], $key['quantity'], $key['price']];
    $tableGenerator->addRow($arr);
    $total += $key['price'];
  }
  $total = '<b> '.number_format($total,2).'</b>';
  $arr = [" ", " ", " ", " ", " ", $total];
  $tableGenerator->addRow($arr);
  echo $tableGenerator->getHTML();

?>

<br><br><br>

<?php
}// end of if(isset($_GET['order']))
else{
  header("Location: ./manageorders.php");
}// end of else for if(isset($_GET['order']))

  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
