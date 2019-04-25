<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
*******************************************************
* The manageadministrators.php file
* This page is used to add, edit or delete admins
* All the administrator accounts are listed in a table
* Each row contains link to viewadministrators.php
*******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>

<?php
    $stmt = $pdo->prepare('SELECT * FROM users WHERE type = "admin" ORDER BY user_id');
    $stmt->execute();
?>

  <h1>Manage Administrators:</h1>
  <!-- The add button to add a new administrator -->
  <a href = "./addadmin.php"><button class = "addButton">+ Add Another Administrator</button></a>

  <br>
  <h3>&nbsp;&nbsp; Click Manage to edit or delete an administrator:</h3>
  <br><br>

<!-- The TableGenerator class is used to create a $tableGenerator object -->
<!-- This object is used to display the administrator information -->
  <?php
  $tableGenerator = new TableGenerator();
  $tableGenerator->setHeadings(['S.N. ', 'Full Name', 'Username', 'Email', 'Manage']);

    $count = 1;
    while ($key = $stmt->fetch()) {
      $edit = '<a href = "./viewadministrators.php?edit='.$key['user_id'].'">Manage</a>';
      $arr = [$count, $key['fullname'], $key['username'], $key['email'], $edit];
      $tableGenerator->addRow($arr);
      $count++;
    }
    echo $tableGenerator->getHTML();
  ?>

  <br><br>
  <br><br>

<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
