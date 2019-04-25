<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

*******************************************************
* The managereviews.php file
* This page displays the list of all the reviews
* The admin can approve or delete a review from this
* Area
*******************************************************
 -->


<?php require '../Divisions/adminheader.php';?>
<?php
    $stmt = $pdo->prepare('SELECT * FROM reviews INNER JOIN users ON users.user_id = reviews.user_id
      INNER JOIN products ON reviews.product_id = products.product_id ORDER BY review_id');
    $stmt->execute();
?>


  <h1>Manage Reviews:</h1>
  <h4 style = "float: right; margin-right: 40px; color: coral;"><?php
    if(isset($_GET['message']))
      echo $_GET['message'];
  ?></h4>

<!-- Clicking on the manage link will allow the Admin to approve, unapprove or delete a review  -->
  <br>
    <h3>Click manage to approve or unapprove a review:</h3>
  <br><br>

<!-- The TableGenerator class used to display all the fetched reviews from the database -->

  <?php
    $tableGenerator = new TableGenerator();
    $tableGenerator->setHeadings(['S.N. ', 'Full Name', 'Username', 'Product Title', 'Review Text','Posted Date','Approve State','Manage']);
    $count = 1;
    while ($key = $stmt->fetch()) {
      $edit = '<a href = "./viewreviews.php?edit='.$key['review_id'].'">Manage</a>';
      $review_text = substr($key['review_text'], 0, 100).'...';

      $arr = [$count, $key['fullname'], $key['username'], $key['title'], $review_text, $key['date_posted'],
       $key['approved'],  $edit];
      $tableGenerator->addRow($arr);
      $count++;
    }
    echo $tableGenerator->getHTML();
  ?>


<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
