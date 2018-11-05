<!DOCTYPE html>
<html>
<head>
	<?php include '_head.html'; ?>
	<link rel="stylesheet" href="css/reader.css" type="text/css" />
</head>
<body>
	<div id="pageContainer">
		<?php include 'dockread.html'; ?>

		<div id="content">
			<div id="newsBox">
			<?php 
				if( isset($_GET['dzial']) ){
					echo '<script>window.Cathegory = "'.$_GET['dzial'].'";</script>';
					$dzial = $_GET['dzial'];
				} else {
					$dzial = 'hom';
				}
				
		$count = counter( $dzial );
				
				$id = ( isset($_GET['art']) ? $_GET['art'] : $count );
				echo '<script>window.art = ['.$id.','.$count.'];</script>';

				if( file_exists('articles/'.$dzial.'/'.$id.'.txt') ){
					$file = fopen('articles/'.$dzial.'/'.$id.'.txt','r');
					$get = fread($file, 8192);
					$art = load( $get );
					//var_dump($art);

					echo '<ul class="news" id="'.$id.'">
						<li class="date">'.date('Y-m-d',$art['date']).'</li>
						<li class="title">'.$art['title'].'</li>
						<li class="abstract">'.$art['abstract'].'</li>
						<li class="content">'.$art['article'].'</li>
					</ul>';
				} else {
					//echo 'Błąd odczytu!';
				}
				echo '<script>System.setDockColor("'.$dzial.'");</script>';
			?>
			</div>
		</div>
	</div>

<script>
	System.setDockLiColor();

	var btn = $('#backBtn')[0];
	btn.addEventListener('click',function(e){
		window.location = 'index.php?open=hom';
	}.bind(this),false);

	var prev = $('#prevGo')[0];
	if( window.art[0] > 1 ){
		prev.addEventListener('click',function(e){
			window.location = 'reader.php?dzial='+window.Cathegory+'&art='+(window.art[0]-1);
		}.bind(this),false);
	} else {
		prev.className = 'btn off';
	}

	var next = $('#nextGo')[0];
	if( window.art[0] < window.art[1] ){
		next.addEventListener('click',function(e){
			window.location = 'reader.php?dzial='+window.Cathegory+'&art='+(window.art[0]+1);
		}.bind(this),false);
	} else {
		next.className = 'btn off';
	}
</script>

</body>
</html>