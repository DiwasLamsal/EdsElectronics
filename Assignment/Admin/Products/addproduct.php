<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The addproduct.php file 							             *
* This file displays the form to add a product       *
******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>

<?php
    if(isset($_POST['submit'])){
    //Store the uploaded image as binary in $binary variable to store it into the database
      $binary = file_get_contents($_FILES['image']['tmp_name']);

      $stmt = $pdo->prepare("INSERT INTO products(title, manufacturer, user_id, price, description, image, date_posted, category_id)
                            VALUES(:title, :manufacturer, :user_id, :price, :description, :image, :date_posted, :category_id)");
      $criteria = [
        'title'=>$_POST['title'],
        'manufacturer'=>$_POST['manufacturer'],
        'user_id'=>$_SESSION['loggedin'],
        'price'=>$_POST['price'],
        'description'=>$_POST['description'],
        'image'=>$binary,
        'date_posted'=>date('Y-m-d H:i:s'),
        'category_id'=>$_POST['category_id']
      ];
      if($stmt->execute($criteria)){
        echo '<h3>Successfully added the product '.$_POST['title'].'.</h3><br><br>';

// This part of code sends an email to the customers as the new product has just been added
// Select all the customers who have selected the option to be notified by email when a new product is added

            $sendMessage = $pdo->prepare('SELECT * FROM users WHERE notifications = "yes"');
            $sendMessage->execute();

            while($row = $sendMessage->fetch()){
              $to [] = $row['email'];
            }
            $subject = 'New product added to Edelectronics';

            $message = '<h2>A new Product has been added</h2><br>';
            $message.= 'A new product '.$_POST['title'].' has been added. The product costs '.$_POST['price'].' and
            is manufactured by '.$_POST['manufacturer'];
            $message.= '<br><b>Product Description:</b><br>'.$_POST['description'];

            $header = "From:admin@edelectronics.com \r\n";

//Piece of code taken from https://www.tutorialspoint.com/php/php_sending_emails.htm
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
// Send mail to the customers
            if(mail(implode(", ", $to), $subject, $message, $header)){
              echo  count($to).' customers have been mailed about the added product! <br>';
            }
            else{
              echo 'Could not send email';
            }


        echo'<h3><a href = "./manageproducts.php">Click here to view latest list of products.</a></h3><br><br>';
    }//end of if($stmt->execute($criteria))
  }// end of if(isset($_POST['submit']))
else{
?>

<!-- Initialize the variables and display the form product adding form -->
<!-- The variables are used to set the default values to the form -->
<!-- The same form is used for editing a product and it requires the default values -->
   <h1>Add a Product</h1>
  <?php
    $title = "";
    $manufacturer = "";
    $price = "";
    $description = "";
    $type = "add";
    $action = "./addproduct.php";
    require '../Divisions/productform.php';
  ?>
 <?php
} // end of else for if(isset($_POST['submit']))
   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
