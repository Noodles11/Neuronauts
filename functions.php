<?php

function load( $get){
	preg_match('/::DATE::/', $get, $d, PREG_OFFSET_CAPTURE);
	preg_match('/::TITLE::/', $get, $t, PREG_OFFSET_CAPTURE);
	preg_match('/::ABSTRACT::/', $get, $a, PREG_OFFSET_CAPTURE);
	preg_match('/::CONTENT::/', $get, $c, PREG_OFFSET_CAPTURE);

	$data = substr( $get, $d[0][1]+strlen($d[0][0]), $t[0][1]-($d[0][1]+strlen($d[0][0])) );
	$tytul = substr( $get, $t[0][1]+strlen($t[0][0]), $a[0][1]-($t[0][1]+strlen($t[0][0])) );
	$abstrakt = substr( $get, $a[0][1]+strlen($a[0][0]), $c[0][1]-($a[0][1]+strlen($a[0][0])) );
		$abstrakt = preg_replace('/^"$/',"'",$abstrakt);
	$artykul = substr( $get, $c[0][1]+strlen($c[0][0]) );
		$artykul = preg_replace('/^"$/',"'",$artykul);

	return array('date' => $data, 'title' => $tytul, 'abstract' => $abstrakt, 'article' => $artykul);
}

function counter( $dzial ){
	$open = opendir('articles/'.$dzial);
	$count=0;
	while( $el = readdir($open) ){
		if( substr($el,0,1) != '.' ){ $count++; }
	}
	closedir($open);

	return $count;
}

?>