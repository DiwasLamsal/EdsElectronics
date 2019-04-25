
<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON
******************************************************
* The managecategories.php file
* This file displays a list of categories in a table
* These categories can be edited by clicking on the
* Manage anchor
******************************************************
 -->
<?php require '../Divisions/adminheader.php';?>
<?php
    $stmt = $pdo->prepare('SELECT * FROM categories ORDER BY category_id');
    $stmt->execute();
?>

  <h1>Manage Categories:</h1>
<!-- The add category button which takes to addcategory.php -->
  <a href = "./addcategory.php"><button class = "addButton">+ Add Another Category</button></a>

  <br>
  <h3>&nbsp;&nbsp; Click Manage to edit or delete a category:</h3>
  <br><br>

  <?php
    $tableGenerator = new TableGenerator();
    $tableGenerator->setHeadings(['S.N. ', 'Category Name', 'Manage']);
    $count = 1;
    while ($key = $stmt->fetch()) {
// The $edit is a link for each category to its respective viewcategories.php section
      $edit = '<a href = "./viewcategories.php?edit='.$key['category_id'].'">Manage</a>';
      $arr = [$count, $key['name'], $edit];
      $tableGenerator->addRow($arr);
      $count++;
    }//end of  while ($key = $stmt->fetch())
    echo $tableGenerator->getHTML();

  ?>

<?php
  require '../Divisions/adminsidebar.php';
  require '../../Divisions/footer.php';
?>
