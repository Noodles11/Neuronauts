<!DOCTYPE html>
<html>
<head>
	<?php include '_head.html'; ?>
	<link rel="stylesheet" href="css/journalist.css" type="text/css" />
</head>
<body>
	<div id="pageContainer">

		<?php include 'dockedit.html'; ?>

		<div id="content">
			<?php 
				if( isset($_GET['mode']) ){
					switch($_GET['mode']){
						case 'add':
							include 'add.html';
							break;
						case 'delete':
							include 'delete.html';
							break;
						case 'edit':
							include 'edit.html';
							break;
					}
				} else {
					include 'add.html';
				}
			?>
		</div>
		
	</div>
</body>
</html>