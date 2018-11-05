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
				
				$articles = $baza->getByCateg($dzial);
				if( sizeof($articles) > 0 ){

					$id = ( isset($_GET['id']) ? $_GET['id'] : null );
					$open = false;
					$ids = array();
					for($i=0; $i<sizeof($articles); $i++){
						$ids[] = $articles[$i]['id'];
						if( !$open ){
							$id == $articles[$i]['id'] ? $open=true : $open=false;
						}
					}

					!$open ? $id=$ids[sizeof($ids)-1] : null ;

							$art = $baza->get( $id );
							$author = $baza->getAuth($art['author']);
				
							echo '<ul class="news" dzial="'.$art['category'].'" id="'.$art['category'].$art['id'].'">

									<li class="info"> '.$author['nick'].' | '.date('D Y-m-d H:i',strtotime($art['date'])).'</li>
									<li class="title">'.$art['title'].'</li>
									<li class="abstract">'.$art['short'].'</li>
									<li class="content">'.$art['long'].'</li>';
							
							//echo '<span class="komentarze">KOMENTARZE</span>';
							echo '<ul id="comments"><li>';
								$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							echo '<form id="commentForm" action="'.$url.'" method="post">';

							echo '<textarea style="margin: 0px; width: 100%; height: 70px; resize: none; margin-top: 5px; padding: 3px;" name="komentarz"></textarea>';

								if( isset($_SESSION['login']) ){
									echo '<span>'.$_SESSION['login']['nick'].'</span>';
								} else {
									echo '<span>Nick: </span><input id="com_nick" type="text" name="nick" value="Gość"/>';
								}

							echo '<input id="com_send" type="submit" name="comment" value="dodaj komentarz" /></form></li>';

							if( isset($_POST['comment']) ){
								if( isset($_SESSION['login']) ){
									$baza->addComment( $id, $_SESSION['login']['id'], null, $_POST['komentarz'] );
								} else {
									$baza->addComment( $id, null, $_POST['nick'], $_POST['komentarz'] );
								}
							}

							$comments = $baza->getComments( $art['id'] );
							include 'comments.html';
							
							echo'</ul></ul>';

					foreach( $ids as $index => $val ){
						if( $val==$id ){ echo '<script>window.index = '.$index.';</script>'; }
					}
					$ids = implode(',',$ids);
					echo '<script>window.ids = ['.$ids.'];</script>';
				} else {
					echo '
						<ul class="news">
							<li class="title">Brak artykułów</li>
						</ul>
					';
				}
				echo '<script>System.setDockColor("'.$dzial.'");</script>';
			?>
			</div>
		</div>
	</div>

<script>
	System.setDockLiColor();

	var ids = (window.ids ? window.ids : []);
	var index = (window.index ? window.index : null);

	var btn = $('#backBtn')[0];
	btn.addEventListener('click',function(e){
		window.location = 'index.php?open=hom';
	}.bind(this),false);

	var prev = $('#prevGo')[0];
	if( ids.length > 1 && window.index > 0 ){
		prev.addEventListener('click',function(e){
			window.location = 'reader.php?dzial='+window.Cathegory+'&id='+ids[window.index-1];
		}.bind(this),false);
	} else {
		prev.className = 'btn off';
	}

	var next = $('#nextGo')[0];
	if( ids.length > 1 && window.index < ids.length-1 ){
		next.addEventListener('click',function(e){
			window.location = 'reader.php?dzial='+window.Cathegory+'&id='+ids[window.index+1];
		}.bind(this),false);
	} else {
		next.className = 'btn off';
	}
</script>

</body>
</html>