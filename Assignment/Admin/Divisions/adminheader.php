<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The adminheader.php file							             *
* This file contains the header contents for admin   *
* It includes the navbar, logo and the aisde info    *
******************************************************
 -->
<?php

// The pdo is defined in the adminheader.php file so that it can be accessed from all the admin pages
// The xampp localhost environment is used for the project
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $schema = 'diwas_assignment';
  $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
								  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

session_start();

// By including the adminheader.php file, all the other pages can access the login information from this part of the code
  if(isset($_SESSION['loggedin'])){
		$user = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');

//Set the $_SESSION['loggedin'] variable as the logged in user's user_id.
    $criteria=[
      'user_id'=>$_SESSION['loggedin']
    ];
    $user->execute($criteria);
    $loggedin = $user->fetch();
    if($loggedin['type']!="admin"){
      header("Location: ../../logout.php?restricted=true");
    } // end of if($loggedin['type']!="admin"){
  } // end of if(isset($_SESSION['loggedin']))

  if(!isset($_SESSION['loggedin'])){
    header("Location: ../../logout.php?restricted=true");
  } // end of if(!isset($_SESSION['loggedin']))
?>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Beginning of the HTML ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!doctype html>
<html>
	<head>
		<title>Ed's Electronics</title>
		<meta charset="utf-8" />

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ CSS Call for all the admin pages ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ An extra stylesheet file adminstyle.css ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ is used for styling administrator area ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

		<link rel="stylesheet" href="../../Style/electronics.css" type="text/css"/>
    <link rel="stylesheet" href="../Divisions/adminstyle.css" type="text/css"/>
		<script src = "../../script.js"></script>
	</head>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Beginning of the BODY ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
	<body>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Beginning of the Header navigation ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
		<header>
			<h1>Ed's Electronics</h1>

			<ul>
				<li><a href="../Dashboard">Home</a></li>

        <li> <a href = "../../logout.php">Logout</a></li>

        <li><a href = "../../" target= "_blank">Users Area</a></li>
			</ul>

			<address>
        <!-- Display administrator's username in the address -->
				<p><?php
          if(isset($_SESSION['loggedin'])){
            echo'<b>Logged in as:</b> '.$loggedin['username'];
          }?>
			</address>
		</header>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ End of navigation ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Beginning of the MAIN body ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <main>


<?php
// TableGenerator class for generating tables with dynamic structures
// This class has been taken from the week 10 lecture
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
}//End of TableGenerator class

?>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ End of adminheader.php ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
