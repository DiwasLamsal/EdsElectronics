<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The index.php file                                 *
* The home page of Ed's Electronics                  *
* This page is the landing page of the system        *
******************************************************
 -->

<?php require './Divisions/header.php';?>
<?php

// Select the first three products and display them on the homepage

  $stmt=$pdo->prepare('SELECT * FROM products ORDER BY product_id DESC');
  $stmt->execute();
  $row1=$stmt->fetch();
  $row2=$stmt->fetch();
  $row3=$stmt->fetch();
?>
<!-- Description of the Ed's Electronics -->
  <h1>Welcome to Ed's Electronics</h1>

  <p>We stock a large variety of electrical goods including phones, tvs, computers and games. Everything comes with at least a one year guarantee and free next day delivery.</p>


<!-- The selected three products are displayed here -->
  <br><br>
  <h3>View Our Latest Additions:</h3>
  <hr />
  <div class = "recentContainer">
    <div class = "first containerProduct">
      <h2><a href = "./particularproduct.php?product=<?php echo$row1['product_id']?>"><?php echo$row1['title'] ?></h2>
      <?php echo'<img src="data:image/jpg; base64,'.base64_encode(($row1['image'])).'" />'?>
      <p>
        At just £<?php echo $row1['price']?>. Hurry up!</a>
      </p>
    </div>
    <div class = "second containerProduct">
      <h2><a href = "./particularproduct.php?product=<?php echo$row2['product_id']?>"><?php echo$row2['title'] ?></h2>
        <?php echo'<img src="data:image/jpg; base64,'.base64_encode(($row2['image'])).'"/>'?>
      <p>
        At just £<?php echo $row2['price']?>. Hurry up!</a>
      </p>
    </div>
    <div class = "third containerProduct">
      <h2><a href = "./particularproduct.php?product=<?php echo$row3['product_id']?>"><?php echo$row3['title'] ?></h2>
        <?php echo'<img src="data:image/jpg; base64,'.base64_encode(($row3['image'])).'"/>'?>
      <p>
        At just £<?php echo $row3['price']?>. Hurry up!</a>
      </p>
    </div>
  </div>

  <hr />

<?php
  require './Divisions/sidebar.php';
  require './Divisions/footer.php';
?>
