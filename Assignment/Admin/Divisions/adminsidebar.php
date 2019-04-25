<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The adminsidebar.php file													 *
*	Contains the aside content for administrators		   *
* It displays the admin navigation 									 *
******************************************************
 -->
</main>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ End of the main body ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Beginning of sidebar contents ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ The sidebar contains all the Manage ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ links availabe to the administrators ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

		<aside>
      <div class = "adminSidebar">
        <h1>Hello, <?php if(isset($_SESSION['loggedin']))echo $loggedin['fullname'];?>!</h1>

        <div class = "sidebaroption manageAdmin">
          <a href = "../Admins/manageadministrators.php">Manage&nbsp;Admins</a>
        </div>
        <div class = "sidebaroption manageCategories">
          <a href = "../Categories/managecategories.php">Manage&nbsp;Categories</a>
        </div>
        <div class = "sidebaroption manageProducts">
          <a href = "../Products/manageproducts.php">Manage&nbsp;Products</a>
        </div>
        <div class = "sidebaroption manageReviews">
          <a href = "../Reviews/managereviews.php">Manage&nbsp;Reviews</a>
        </div>
				<div class = "sidebaroption manageOrders">
          <a href = "../Orders/manageorders.php">Manage&nbsp;Orders</a>
        </div>

      </div>
		</aside>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ End of sidebar contents and adminSidebar.php ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
