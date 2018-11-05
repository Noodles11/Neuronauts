<!DOCTYPE html>
<html>
<head>
	<?php include '_head.html'; ?>
	<link rel="stylesheet" href="css/journalist.css" type="text/css" />
</head>
<body>
<?php include 'dockedit.html'; ?>
<div id="content">
<?php
	$katalog = 'articles';
	
	if( $_GET['mode']=='delete' ){

		echo 'usuwanie';

	} else {
		if( $_GET['mode']=='edit' ){
			
			$success = $baza->edit($_GET['id'],$_SESSION['login']['id'],$_POST['dzial'],$_POST['arttitle'],nl2br($_POST['abstract']),nl2br($_POST['content']));
			if($success){
				echo '</br>Zmieniono artykuł.';
			} else {
				echo '</br>Musisz być zalogowany!
				</br><a href="login.php">Zaloguj</a>';
			}

		} else if( $_GET['mode']=='add' ) {

			$dzial = $_POST['dzial'];
			$success = $baza->add($_SESSION['login']['id'],$_POST['dzial'],$_POST['arttitle'],nl2br($_POST['abstract']),nl2br($_POST['content']));
			
			if($success){
				$id = $baza->getLast($_POST['dzial']);
				echo '</br><a href="reader.php?dzial='.$_POST['dzial'].'&id='.$id.'">Przejdź do artykułu</a>';
			} else {
				echo '</br>Musisz być zalogowany!
				</br><a href="login.php">Zaloguj</a>';
			}

		}

		//var_dump($_SESSION['login']['id'],$_POST['dzial'],$_POST['arttitle'],nl2br($_POST['abstract']),nl2br($_POST['content']));
	}
?>
</div>

</body>
</html>