<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

*******************************************************
* The manageorders.php file
* This page displays the list of all the orders made by
* the customers
*******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>
<!-- The orders as well as details of shipment are displayed in a tabular format -->
<?php
    $stmt = $pdo->prepare('SELECT * FROM orders');
    $stmt->execute();

    $posted_by = $pdo->prepare('SELECT * FROM users
                                INNER JOIN orders
                                ON orders.user_id = users.user_id
                                WHERE orders.order_id = :order_id');


?>

  <h4 style = "float: right; margin-right: 40px; color: coral;"><?php
    if(isset($_GET['message']))
      echo $_GET['message'];
  ?></h4>

  <h1>Manage Orders:</h1>

  <br>
  <h3>&nbsp;&nbsp; Click Manage to view details about an order or to mark it as pending or delivered:</h3>
  <br><br>

<!-- The TableGenerator class is used to display the Information from the database -->
  <?php
    $tableGenerator = new TableGenerator();
    $tableGenerator->setHeadings(['S.N. ', 'Buyer', 'Street Address', 'City', 'Country', 'Contact', 'Status','Date Purchased', 'Date Shipped'
                                  , 'Manage']);
    $count = 1;
    while ($key = $stmt->fetch()) {
      $array = ['order_id'=>$key['order_id']];
      $posted_by->execute($array);
      $customer = $posted_by->fetch();

// For a user friendly approach, when an order is pending, it is displayed as Pending with a red font and
// when it is shipped, a green font displays Shipped as the status.

      if($key['status']=="pending"){
        $status = '<font color = "red">Pending</font>';
      }else{
          $status = '<font color = "green">Shipped</font>';
      }
// Similarly for the date delivered, if the order is delivered, the date of delivery is posted whereas if
// it is pending, a text that says 'Pending Delivery!' is displayed instead of the blank date and time
      if($key['date_delivered']=="0000-00-00 00:00:00"){
        $date_delivered = "Pending Delivery!";
      }
      else {
        $date_delivered = $key['date_delivered'];
      }

      $link = '<a href = "./vieworders.php?order='.$key['order_id'].'">Manage</a>';
      $arr = [$count, $customer['fullname'], $key['street_address'], $key['city'], $key['country'],
      $key['contact'], $status, $key['date_purchased'], $date_delivered, $link];
      $tableGenerator->addRow($arr);
      $count++;
    }//end of while loop
    echo $tableGenerator->getHTML();
  ?>
<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
