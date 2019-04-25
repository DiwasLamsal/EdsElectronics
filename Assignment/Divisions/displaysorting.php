<!--

-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

This file is used to display the products in a sorted order according to the speciied conditions
It displays the select menu in the viewproducts.php page.

It is used for displaying the products in sorted order, and works when searching for Products
in a particular category, with a search term, or simply listing all the products.

 -->
<style>
  .sortingdiv{
    width: 50%;
    text-align: right;
  }

  .sortingdiv form{
    padding: 0;
  }

</style>

<?php

  $asc = 'Oldest First';
  $desc = 'Newest First';
  $hrf = 'Highest rated first';
  $hpf = 'Price - Highest first.';
  $lpf = 'Price - Lowest price first.';

  if(isset($_GET['sortby'])){
    echo '<h3 style = "display: inline;">Sorted by: ';
    if($_GET['sortby']=="ascending"){
      echo $asc;
    }
    if($_GET['sortby']=="descending"){
      echo $desc;
    }
    if($_GET['sortby']=="rating"){
      echo $hrf . '<br><h4>Note: Only Rated Products are displayed.</h4>';
    }
    if($_GET['sortby']=="pricedescending"){
      echo $hpf;
    }
    if($_GET['sortby']=="priceascending"){
      echo $lpf;
    }
    echo '</h3>';
  }

  if(isset($_GET['category'])){
    $action = 'viewproducts.php?category='.$_GET['category'];
  }
  else if(isset($_GET['search'])){
    $action = "viewproducts.php?search=".$_GET['search'];
  }
  else{
    $action = 'viewproducts.php';
  }

?>

<div class = "sortingdiv" style = "float: right;">
  <form action = "viewproducts.php" method = "GET" style = "border: none;">

<!-- If category or search term have been defined -->
    <?php
    if(isset($_GET['category'])){
      echo '<input type = "hidden" name = "category" value = "'.$_GET['category'].'">';
    }
    else if(isset($_GET['search'])){
      echo '<input type = "hidden" name = "search" value = "'.$_GET['search'].'">';
    }
    ?>


    Sort by: <select name = "sortby" onchange="this.form.submit()">
      <option value = "descending" <?php if(isset($_GET['sortby']) and $_GET['sortby']=="descending") echo 'selected';?>><?php echo $desc;?></option>
      <option value = "ascending" <?php if(isset($_GET['sortby']) and $_GET['sortby']=="ascending") echo 'selected';?>><?php echo $asc;?></option>
      <option value = "rating" <?php if(isset($_GET['sortby']) and $_GET['sortby']=="rating") echo 'selected';?>><?php echo $hrf;?></option>
      <option value = "pricedescending" <?php if(isset($_GET['sortby']) and $_GET['sortby']=="pricedescending") echo 'selected';?>><?php echo $hpf;?></option>
      <option value = "priceascending" <?php if(isset($_GET['sortby']) and $_GET['sortby']=="priceascending") echo 'selected';?>><?php echo $lpf;?></option>
    </select>

  </form>
</div>
<br><br>

<?php
// Check sorting

  if(isset($_GET['sortby'])){
    if(isset($_GET['sortby'])){
      if($_GET['sortby']=="ascending"){
        $sorter = 'date_posted';
        $sorttype = 'ASC';
      }
      if($_GET['sortby']=="descending"){
        $sorter = 'date_posted';
        $sorttype = 'DESC';
      }
      if($_GET['sortby']=="rating"){
        $sorter = 'rating';
        $sorttype = 'DESC';
      }
      if($_GET['sortby']=="pricedescending"){
        $sorter = 'price';
        $sorttype = 'DESC';
      }
      if($_GET['sortby']=="priceascending"){
        $sorter = 'price';
        $sorttype = 'ASC';
      }
    }
  }
  else {
    $sorter = 'date_posted';
    $sorttype = 'DESC';
  }

?>
