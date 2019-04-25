<!--
-Diwas Lamsal
-18406547
-CSY2038 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The admin index.php file                            *
* This is the landing page after an admin logs in     *
*******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>

<!-- The list of available features for an Administrator -->
  <h1>Administrator Dashboard</h1>
  <h3>Please select what you would like to do from the sidebar at the left. <br>From the admin panel, you will be able to:</h3>
  <br>
  <ul style = "float:left;">
    <li>Add an Administrator account</li><br>
    <li>Add a Product</li><br>
    <li>Add a Category</li><br>
    <li>View Products</li><br>
    <li>View Categories</li><br>
    <li>View Administrators</li><br>
    <li>View Reviews</li><br>
  </ul>
  <ul style = "float:left; margin-left: 120px;">
    <li>View Orders</li><br>
    <li>Edit Administrator Accounts</li><br>
    <li>Edit Categories</li><br>
    <li>Edit Products</li><br>
    <li>Delete Administrators</li><br>
    <li>Delete Products</li><br>
    <li>Delete Categories</li><br>

  </ul>
  <ul style = "float:left; margin-left: 120px;">
    <li>Delete Orders</li><br>
    <li>Delete Reviews</li><br>
    <li>Feature a Product</li><br>
    <li>Mark Reviews as Approved</li><br>
    <li>Mark Orders As Shipped/ Pending</li><br>

  </ul>

<!-- The sidebar contains a list of menus from which the listed actions can be performed -->

<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
