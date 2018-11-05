<?php
class baza {

	var $handle;

	function __construct( $dbuser, $dbpass, $dbname, $dbhost ){
		$this->handle = mysql_connect( $dbhost, $dbuser, $dbpass ) or die('error! dane logowania do bazy!');
		$tmp = mysql_select_db( $dbname, $this->handle ) or die('error! błędne dane bazy!');
	}

	function add( $author, $cat, $t, $a, $cont ){
		if( $author!=null ){
			mysql_query("
				insert into 
					`artykuly`
				set 
					`author`=".$author.", 
					`category`='".$cat."',
					`title`='".$t."', 
					`short`='".$a."', 
					`long`='".$cont."'
				;");		
			return true;
		} else {
			return false;
		}
	}
	function edit( $id, $author, $cat, $t, $a, $cont ){
		if( $author!=null ){
			mysql_query("
				update
					`artykuly`
				set 
					`author`=".$author.", 
					`category`='".$cat."',
					`title`='".$t."', 
					`short`='".$a."', 
					`long`='".$cont."'
				where
					`id`=".intval($id)."
				;");	
			return true;	
		} else {
			return false;
		}
	}
	function delete( $id ){
		mysql_query("
			delete from
				`artykuly`
			where
				`id`=".intval($id)."
			;");		
	}

	function get( $id ){
		$q = mysql_query('select * from artykuly where id='.intval($id).' limit 1;');
		while( $txt = mysql_fetch_assoc($q) ){
			$all = $txt;
		}
		return $all;
	}

	function getLast( $cat ){
		$rs = mysql_query('select id from artykuly where category="'.$cat.'" ORDER BY id DESC limit 1;');
		while( $row = mysql_fetch_assoc($rs) ){
			$id = $row['id'];
		}
		return $id;
	}

	function login( $login ){
		$q = mysql_query('select * from auth where login="'.$login.'" limit 1;');
		while( $txt = mysql_fetch_assoc($q) ){
			$all = $txt;
		}
		return $all;
	}

	function newUser( $login, $pass, $nick, $email ){
		mysql_query('insert into auth set login="'.$login.'", haslo="'.md5($pass).'", nick="'.$nick.'", email="'.$email.'", user="user";');
	}


	function logVisit( $id ){
		mysql_query('update auth set last="'.date('Y-m-d H:i:s').'" where id='.$id.' limit 1;');
	}

	function getAuth( $id ){
		$q = mysql_query("
			select
				*
			from 
				`auth`
			where
				`id`=".intval($id)."
			;");	
		while( $txt = mysql_fetch_assoc($q) ){
			$all = $txt;
		}
		return $all;	
	}

	function countComments( $id ){
		$q = mysql_query("
			select
				count(*) as count
			from 
				`comments`
			where
				`artykul`=".intval($id)."
			;");	
		while( $txt = mysql_fetch_assoc($q) ){
			$all = $txt['count'];
		}
		return $all;	
	}
	function getComments( $id ){
		$q = mysql_query("
			select
				*
			from 
				`comments`
			where
				`artykul`=".intval($id)."
			;");	
		while( $txt = mysql_fetch_assoc($q) ){
			$all[] = $txt;
		}
		return $all;	
	}
	function addComment( $art, $authid, $nick, $comm ){
		mysql_query("
			insert into
				`comments`
			set
				artykul=".(int)$art.",
				koment='".$comm."',
				userid=".(int)$authid.",
				nick='".$nick."'
			;");
	}

	function getByCateg( $cat ){
		$q = mysql_query('select * from artykuly where category="'.$cat.'";');
		while( $txt = mysql_fetch_assoc($q) ){
			$all[] = $txt;
		}
		return $all;
	}
}
?>