<?php
require_once ('../framework/dbconf_main.php');

$modulo = 'ACAD';
$params = array($modulo);
$sql="{call changelog_view(?)}";
$changelog_view = sqlsrv_query($conn, $sql, $params);  

// 
?> 
<div class="row">
	<div class="flexslider">
		<ul class="slides">
			<li>
				<img src="../imagenes/<? echo $_SESSION['pop_up_repr_img']; ?>" />
				<p class="flex-caption">Adventurer Cheesecake Brownie</p>
			</li>
			<li>
				<img src="../imagenes/<? echo $_SESSION['pop_up_repr_img']; ?>" />
				<p class="flex-caption">Adventurer Lemon</p>
			</li>
			<li>
				<img src="../imagenes/<? echo $_SESSION['pop_up_repr_img']; ?>" />
				<p class="flex-caption">Adventurer Donut</p>
			</li>
			<li>
				<img src="../imagenes/<? echo $_SESSION['pop_up_repr_img']; ?>" />
				<p class="flex-caption">Adventurer Caramel</p>
			</li>
		</ul>
	</div>
</div>