<!DOCTYPE html>
<html>
<head>
	<?php include '_head.html'; ?>
	<link rel="stylesheet" href="css/journalist.css" type="text/css" />
</head>
<body>
	<div id="pageContainer">

		<div id="content">
			<?php 
				$art = $baza->get($_GET['id']);

				echo '
					<ul class="news" dzial="'.$art['category'].'" id="'.$art['category'].$art['id'].'">
						<li class="date">'.date('Y-m-d',strtotime($art['date'])).'</li>
						<li class="title">'.$art['title'].'</li>
						<li class="abstract">'.$art['short'].'</li>
						<li class="content">'.$art['long'].'</li>
						<li class="author"><span>'.$art['author'].'</span></li>
					</ul>
				';
			?>
		</div>
		
	</div>
</body>
</html>