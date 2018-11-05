<!DOCTYPE html>
<html>
<head>
	<?php include '_head.html'; ?>
	<link rel="stylesheet" href="css/journalist.css" type="text/css" />
	<link rel="stylesheet" href="css/login.css" type="text/css" />
</head>
<body>
	<div id="pageContainer">

		<div id="content">
			<?php 

				if( isset($_SESSION['login']) ){ //ZALOGOWANY

					echo 'ZALOGOWANY: '.$_SESSION['login']['login'];
					echo '</br>Ostatnie logowanie: '.$_SESSION['login']['last'];

					if( isset($_GET['logout']) && $_GET['logout']==1 ){
						unset($_SESSION['login']);
						session_destroy();
						header('Location: index.php');
					} else {
						echo '<p><a href="login.php?logout=1">wyloguj</a></br></p>';
						echo '<p><a href="journalist.php">journalist</a></p>';
						echo '<p><a href="index.php">strona główna</a></p>';
					}

				} else { //NIEZALOGOWANY

					if( !isset($_GET['new']) && isset($_POST['login']) && isset($_POST['password']) ) { //AKCJA LOGOWANIA

						$person = $baza->login($_POST['login']);
						$reg = '/'.$person['haslo'].'/';

						preg_match($reg, md5($_POST['password']), $result, PREG_OFFSET_CAPTURE);

						if( isset($result[0]) ){ 
							$_SESSION['login'] = $person;
								unset($_SESSION['login']['haslo']);
							$baza->logVisit( $person['id'] );
							header('Location: login.php');  

						} else { 
							echo 'BŁĘDNE HASŁO LUB LOGIN!'; 
						}

					} else if( isset($_GET['new']) ) { //NOWE KONTO

						if( $_GET['new']=='1' ){

							if( $_GET['error'] ){
								switch( $_GET['error'] ){
									case 'mail':
										echo '<span class="error">Podałeś zły email!</span></br>';
										break;
									case 'pass':
										echo '<span class="error">Hasła się nie zgadzają!</span></br>';
										break;
									case 'empty':
										echo '<span class="error">Wypełnij wszystkie pola!</span></br>';
										break;
									default:
										echo '<span class="error">Nieznany błąd!</span></br>';
										break;
								}
							}

							echo 'NOWY UŻYTKOWNIK ';

							echo '
								<form action="login.php?new=2" method="post">
									<ul>
										<li><div class="label">email:</div><input id="tytul" type="text" name="email" /></li>
										<li><div class="label">imię i nazwisko:</div><input id="tytul" type="text" name="nick" /></li>
										<li><div class="label">login:</div><input id="tytul" type="text" name="login" /></li>
										<li><div class="label">hasło:</div><input id="tytul" type="password" name="password" /></li>
										<li><div class="label">powtórz hasło:</div><input id="tytul" type="password" name="password2" /></li>
									    <li><input id="btnok" type="submit" name="submit" value="OK" /></li>
									</ul>
								</form>
							';

						} else if( $_GET['new']=='2' ){

							$mail = $_POST['email'];
							preg_match('/[a-zA-Z0-9.]+[@]{1}[a-zA-Z0-9]+[.]{1}[a-zA-Z]+/', $mail, $result, PREG_OFFSET_CAPTURE);

							if( $_POST['email']=='' || $_POST['nick']=='' || $_POST['login']=='' || $_POST['password']=='' || $_POST['password2']=='' ){
								header('Location: login.php?new=1&error=empty');
							} else if( $_POST['password']!=$_POST['password2'] ){
								header('Location: login.php?new=1&error=pass');
							} else if( $result[0][0]!=$mail ){
								header('Location: login.php?new=1&error=mail');
							} else {

								$baza->newUser( $_POST['login'], $_POST['password'], $_POST['nick'], $mail );

								$person = $baza->login($_POST['login']);
								$_SESSION['login'] = $person;
									unset($_SESSION['login']['haslo']);
								$baza->logVisit( $person['id'] );
								header('Location: login.php');  
							}
						}

					} else if( isset($_GET['lost']) ){ //PRZYPOMNIENIE HASLA

						if( $_GET['lost']=='1' ){

							echo 'RESET HASŁA';

							echo '
								<form action="login.php?lost=2" method="post">
									<ul>
										<li><div class="label">login:</div><input id="tytul" type="text" name="login" /></li>
									    <li><input id="btnok" type="submit" name="submit" value="OK" /></li>
									</ul>
								</form>
							';

						} else if( $_GET['lost']=='2' ){

							$person = $baza->login($_POST['login']);

							//define the receiver of the email
							$to = $person['email'];
							//define the subject of the email
							$subject = 'Neuronauci - Zmiana hasła'; 
							//define the message to be sent. Each line should be separated with \n
							$message = "<html><body>Witaj ".$person['nick'].",</br></br>W sprawie zmiany hasła zgłoś się do administratora. Automatyczna zmiana hasła jeszcze nie jest dostępna.</body></html>"; 
							//define the headers we want passed. Note that they are separated with \r\n
							$headers = "From: Neuronauci\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							//send the email
							$mail_sent = @mail( $to, $subject, $message, $headers );
							//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
							echo $mail_sent ? "Wysłano mail. Sprawdź skrzynkę pocztową." : "Błąd wysyłania maila.";
						
						}

					} else { //LOGOWANIE

						echo 'LOGOWANIE ';

						echo '
							<form action="login.php" method="post">
								<ul>
									<li><div class="label">login:</div><input id="tytul" type="text" name="login" /></li>
									<li><div class="label">haslo:</div><input id="tytul" type="password" name="password" /></li>
								    <li><input id="btnok" type="submit" name="submit" value="OK" /></li>
								</ul>
							</form>
						';

						echo '</br></br><a href="login.php?lost=1">zapomniałem hasła</a> | <a href="login.php?new=1">NOWE KONTO</a>';
					}				
				}
			?>
		</div>
		
	</div>
</body>
</html>