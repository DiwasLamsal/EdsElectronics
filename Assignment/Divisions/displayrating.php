<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

This file is used to display the ratings of products.
The ratings are displayed as full star, half star or an empty star.
-->

<?php
  global $pdo;
  $stmt = $pdo->prepare('SELECT * FROM ratings WHERE product_id = :product_id');
  $arr = ['product_id'=>$productid];
  $stmt->execute($arr);
// Get the total ratings of a particular product
  $totalRatings = $stmt->rowCount();
  if($totalRatings>0){
    $total = 0;

    while($ratings = $stmt->fetch()){
      $total += $ratings['rating'];
    }
    $average = $total / $totalRatings;
    $average = number_format($average, 1,".",".");
    $count = 0;

// If the stars are full
    for($i = 1; $i<=$average; $i++){
      echo '<img src = "./Images/star.svg" height = "20" width = "20" style = "margin-top: 10px;">';
      $rem = $average - $i;
      $count++;
    }

// For the decimal portion of the rating
    if($rem>0 && $rem < 1){
      echo '<img src = "./Images/half.svg" height = "20" width = "20" style = "margin-top: 10px;">';
      $count++;
    }

// For the empty stars
    while($count < 5){
      echo '<img src = "./Images/empty.svg" height = "20" width = "20" style = "margin-top: 10px;">';
      $count++;
    }

  }
  else{
    $count = 0;
// If the product contains no rating, 5 empty stars are shown
    while($count < 5){
      echo '<img src = "./Images/empty.svg" height = "20" width = "20">';
      $count++;
    }
  }
?>
