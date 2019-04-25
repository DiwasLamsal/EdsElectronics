<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The header.php file							                   *
* This file contains the header contents  	         *
* It includes the navbar, logo and the aisde info    *
******************************************************
 -->

 <?php
 // The $pdo is initiated in the header.php file so that it can be called in every pages
 $server = 'localhost';
 $username = 'root';
 $password = '';
 $schema = 'diwas_assignment';
 $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
 								[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
 ?>

<?php
	session_start();

// If the user is logged in, set the session variable
	if(isset($_SESSION['loggedin'])){
		$user = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $criteria=[
      'user_id'=>$_SESSION['loggedin']
    ];
    $user->execute($criteria);
    $loggedin = $user->fetch();

// If the user that logs in is an administrator, clear the cart or the shopping basket
    if($loggedin['type']=="admin" && isset($_SESSION['cart'])){
      unset($_SESSION['cart']);
    }

  }

// Get all the categories to display on the navigation
  $stmt = $pdo->prepare('SELECT * FROM categories');
  $stmt->execute();
?>

<!doctype html>
<html>
	<head>
		<title>Ed's Electronics</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="./Style/electronics.css" type="text/css"/>
		<script src = "./script.js"></script>
	</head>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ The beginning of the body ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
	<body>
		<header>
			<h1>Ed's Electronics</h1>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ The navigation ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<ul>
				<li><a href="./">Home</a></li>
				<li><a href = "./viewproducts.php">Products</a>
					<ul>
            <!-- Display all the categories in the navigation submenu -->
						<?php
              while($row = $stmt->fetch()){
                echo'<li><a href = "./viewproducts.php?category='.$row['category_id'].'">'.$row['name'].'</a></li>';
              }
            ?>
					</ul>
				</li>
        <li>
          <!-- If the user is logged in, display the link to logout -->
					<?php
						if(isset($_SESSION['loggedin'])){
							echo '<a href = "./logout.php">Logout</a>';
						}
          // Otherwise, display the link to sign in or register.
						else {
							echo '<a href = "./signin.php">Sign in</a><br><a href = "./signup.php">Sign up</a>';
						}
					?>
				</li>

			</ul>

<!-- The address area displays a welcome message and the username of the user who is currently logged in  -->
<!-- If the user has logged in. Else, it displays a contact number and a message. -->
			<address>

				<p>
          <?php
          	if(isset($_SESSION['loggedin'])){
              echo'Welcome '.$loggedin['username'];
            }
            else{
          ?>
          We are open 9-5, 7 days a week. Call us on
					<strong>01604 11111</strong>

<!-- Display the shopping cart if there are products added to the cart -->
          <?php
            }
            if(!empty($_SESSION['cart'])){

              echo '<br><br><a href = "./checkout.php"><img style = "margin-bottom: -25px;" src = "./Images/cart.svg" height="50"></a>';
              echo '<p
                style = "color:white;
                  background: red;
                  display: inline-block;
                  border-radius:50%;">
                  <b>&nbsp;'.sizeof($_SESSION['cart']).'&nbsp;</b>';
            }
          ?>
				</p>
			</address>


<?php
// Function to display products in the viewproducts page
  function showProduct($key){
    echo '<li>';
    echo '<p style = "float: right;"><b>Date Posted: </b>'.date_format(date_create($key['date_posted']), "Y/m/d").'</p><br><br>';
    echo '<h3><a href = "./particularproduct.php?product='.$key['product_id'].'">'.$key['title'].'</a></h3>';
    $productid = $key['product_id'];
    require './Divisions/displayrating.php';
    echo'<br><br>';
    echo '<img src="data:image/jpg; base64,'.base64_encode(($key['image'])).'" height = "200" /><br><br>';
    echo '<p>'.$key['description'].'</p>';
    echo '<div class = "price"> £'.$key['price'].'</div>';
    echo '</li>';
  }


// Get initials of a name for avatar in the reviews
  function getInitials($name){
    $initials = $name[0].$name[strrpos($name, " ") + 1];
    return $initials;
  }

?>

<?php

//This class has been taken from week 10 lecture
class TableGenerator {
  public $headings;
  public $rows = [];

  public function setHeadings($headings) {
    $this->headings = $headings;
  }

  public function addRow($row) {
    $this->rows[] = $row;
  }

  public function getHTML() {
    $result = '<table>';
    $result = $result . '<thead>';
    $result = $result . '<tr>';
    foreach ($this->headings as $heading) {
      $result = $result . '<th>' . $heading . '</th>';
    }
    $result = $result . '</tr>';
    $result = $result . '</thead>';
    $result = $result . '<tbody>';
    foreach ($this->rows as $row) {
      $result = $result . '<tr>';
      foreach ($row as $cell) {
        $result = $result . '<td>' . $cell . '</td>';
      }
      $result = $result . '</tr>';
  }
  $result = $result . '</tbody>';
  $result = $result . '</table>';
  return $result;
  }
}

?>
		</header>
    <section>
<!-- The search box displayed over the images -->
      <div id = "search">
        <br><br>
        <form action = "viewproducts.php" method = "GET">
          <input type = "text" name = "search" id = "searchInput"
          onfocus="searchClicked()" onfocusout = "searchLeft()"><input type = "submit" name = "submit" value = "Search"
          id = "searchButton">
        </form>
      </div>
    </section>
    <main>
