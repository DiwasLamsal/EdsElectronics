<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The viewreviews.php file
* This file shows the details of selected review
* It can be used to approve, delete or unapprove a
* Review
******************************************************
 -->

 <?php require '../Divisions/adminheader.php';?>

<?php
// Get all the reviews, reviewed product's title and the user's name who posted the review from the database
  if(isset($_GET['edit'])){
      $stmt = $pdo->prepare('SELECT *, users.fullname, products.title FROM reviews
                              INNER JOIN users ON reviews.user_id = users.user_id
                              INNER JOIN products ON products.product_id = reviews.product_id
                              WHERE review_id = :review_id');

      $arr = ['review_id'=>$_GET['edit']];
      $stmt->execute($arr);
      $review = $stmt->fetch();
  }
  if(isset($_GET['action'])){
    // Approve the review and allow it to appear for everyone
    if($_GET['action']=="approve"){
      $stmt = $pdo->prepare('UPDATE reviews SET approved = :approved WHERE review_id = :review_id');
      $criteria = [
        'approved'=>"yes",
        'review_id'=>$review['review_id']
      ];
      if($stmt->execute($criteria)){
        header('Location: managereviews.php?message=Approve+Successful');
      }
    }// end of if($_GET['action']=="approve")
    // Unapprove the review and make it dissapear for other customers.
    // The administrators will still be able to view the review from the managereviews section
    if($_GET['action']=="unapprove"){
      $stmt = $pdo->prepare('UPDATE reviews SET approved = :approved WHERE review_id = :review_id');
      $criteria = [
        'approved'=>"no",
        'review_id'=>$review['review_id']
      ];
      if($stmt->execute($criteria)){
        header('Location: managereviews.php?message=Unapprove+Successful');
      }
    }// end of if($_GET['action']=="unapprove")
    // Delete the review from the database
    if($_GET['action']=="delete"){
      $stmt = $pdo->prepare('DELETE FROM reviews WHERE review_id = :review_id');
      $criteria = [
        'review_id'=>$review['review_id']
      ];
      if($stmt->execute($criteria)){
        header('Location: managereviews.php?message=Delete+Successful');
      }
    }// end of if($_GET['action']=="delete")
  }// end of if(isset($_GET['action']))
?>
<hr>

<!-- The buttons as available actions to be performed on the selected review -->

<a href = "./viewreviews.php?<?php echo 'edit='.$review['review_id'].'&action=delete';?>">
  <button class = "viewButton editButton" style="margin-top:45px; background: black;">
    <img src = "../Images/rubbish-bin.svg" class = "btnImg"><br>Delete</button>
</a>

<a href = "./viewreviews.php?<?php echo 'edit='.$review['review_id'].'&action=unapprove';?>">
  <button class = "viewButton deleteButton" style="margin-top:45px;">
    <img src = "../Images/error.svg" class = "btnImg"><br>Unapprove</button>
</a>

<a href = "./viewreviews.php?<?php echo 'edit='.$review['review_id'].'&action=approve';?>">
  <button class = "viewButton editButton" style="margin-top:45px; background: green;">
    <img src = "../Images/tick-inside-a-circle.svg" class = "btnImg"><br>Approve</button>
</a>


<br>
<br>
<!-- The review details displayed -->
  <h3>Review Details: </h3>
  <br>

  <p>

    <b>Posted By: </b><?php echo$review['fullname'];?><br><br>
    <b>Review Product: </b><?php echo$review['title'];?><br><br>
    <b>Approval State: </b><?php if($review['approved']=="yes")echo "Approved"; else echo"Not Approved"; ?><br><br>
    <b>Date Posted: </b><?php echo$review['date_posted'];?><br><br>
    <b>Review Text: </b><?php echo$review['review_text'];?><br><br>

  </p>
<hr>


 <?php

   require '../Divisions/adminsidebar.php';
   require '../../Divisions/footer.php';
 ?>
