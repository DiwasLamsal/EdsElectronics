<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

******************************************************
* The sidebar.php file															 *
*	Contains the aside content											   *
* It displays the featured product									 *
******************************************************
 -->
</main>

		<aside>
			<?php
				global $pdo;
				$stmt = $pdo->prepare('SELECT * FROM products WHERE featured=:yes');
				$criteria = [
					'yes'=>"yes"
				];
				$stmt->execute($criteria);
				$row = $stmt->fetch();
			?>
			<h1><a href="./particularproduct.php?product=<?php echo$row['product_id']?>">Featured Product</a></h1>
			<p>
				<?php
					echo '<h3>'.$row['title'].'</h3><br>';
					echo '<div style = "float: left; display: inline; margin-right: 30px;">
			            <img src="data:image/jpg; base64,'.base64_encode(($row['image'])).'" height = "200" width = "200"/>
			          </div><br><br>';
					echo $row['description'];
				?>
			</p>
		</aside>
