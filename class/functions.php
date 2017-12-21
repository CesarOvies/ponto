<?php 
session_start();

$GLOBALS['$month_tolerance'] = 1800;
$GLOBALS['delay_to_hit_again'] = 0;
$GLOBALS['toleration_on_arrival'] = 60;
$GLOBALS['manager_codes'] = [8, 100];

function nameYearMonth ( $num ) {
    $year = substr($num,0,4);
    $month = substr($num,4,5);
    switch ($month) {
        case '01':
        return 'Janeiro/'.$year;
        break;
        case '02':
        return 'Fevereiro/'.$year;
        break;
        case '03':
        return 'Março/'.$year;
        break;
        case '04':
        return 'Abril/'.$year;
        break;
        case '05':
        return 'Maio/'.$year;
        break;
        case '06':
        return 'Junho/'.$year;
        break;
        case '07':
        return 'Julho/'.$year;
        break;
        case '08':
        return 'Agosto/'.$year;
        break;
        case '09':
        return 'Setembro/'.$year;
        break;
        case '10':
        return 'Outubro/'.$year;
        break;
        case '11':
        return 'Novembro/'.$year;
        break;
        case '12':
        return 'Dezembro/'.$year;
        break;
    }
};


function nameDayWeek($month, $day, $year){
    $weekDay = jddayofweek (cal_to_jd(CAL_GREGORIAN, $month, $day, $year), 1);
    switch ($weekDay) {
        case 'Sunday':
        return 'Dom';
        break;
        case 'Monday':
        return 'Seg';
        break;
        case 'Tuesday':
        return 'Ter';
        break;
        case 'Wednesday':
        return 'Qua';
        break;
        case 'Thursday':
        return 'Qui';
        break;
        case 'Friday':
        return 'Sex';
        break;
        case 'Saturday':
        return 'Sáb';
        break;
    }
};

function nameMonth ( $num ) {
	switch ($num) {
		case '01':
			return 'Janeiro';
			break;
		case '02':
			return 'Fevereiro';
			break;
		case '03':
			return 'Março';
			break;
		case '04':
			return 'Abril';
			break;
		case '05':
			return 'Maio';
			break;
		case '06':
			return 'Junho';
			break;
		case '07':
			return 'Julho';
			break;
		case '08':
			return 'Agosto';
			break;
		case '09':
			return 'Setembro';
			break;
		case '10':
			return 'Outubro';
			break;
		case '11':
			return 'Novembro';
			break;
		case '12':
			return 'Dezembro';
			break;
	}
};
function nameCidade ( $cidade ) {
	switch ($cidade) {
		case 'santos':
			return 'Santos';
			break;
		case 'saovicente':
			return 'São Vicente';
			break;
		case 'praiagrande':
			return 'Praia Grande';
			break;
		case 'saopaulo':
			return 'São Paulo';
			break;
		case 'cubatao':
			return 'Cubatão';
			break;
		case 'guaruja':
			return 'Guarujá';
			break;
	}
};
function hourToMin($time){
	list($h, $m, $s) = explode(':', $time); 
	return ($h*60)+$m;
}
function hourToSec($time){
	list($h, $m, $s) = explode(':', $time); 
	return ((($h*60)+$m)*60)+$s;
}
function addZ($n) {
    if(strlen ($n) < 2){
        return '0'.$n;
    }
    else{
        return $n;
    }
}
function addTime($a,$b){
    $c = hourToSec($a) + hourToSec($b);
    return secToTime($c);
}
function subTime($a,$b){
    $c = hourToSec($a) - hourToSec($b);
    return secToTime($c);
}
function secToTime($s){
    $a = explode('.',$s);
    $s = $a[0];
    $secs = $s % 60;
    $s = ($s - $secs) / 60;
    $mins = $s % 60;
    $hrs = ($s - $mins) / 60;
    return addZ($hrs) . ':' . addZ($mins) .':' . addZ($secs);
}
function removeAccents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
  return str_replace($a, $b, $str);
}

function validaUsuario($user, $pass) {
	$conn = new Cxoi();

	$nuser = addslashes($user);
	$npass = addslashes($pass);
	
	//$query = $conn->sqlQuery("SELECT `cd_user`, `nm_user`  FROM `users` WHERE `nm_user` = '".$nuser."' AND `ds_pass` = '".$npass."' LIMIT 1");
	$query = $conn->sqlQuery("SELECT `cd_user`, `nm_user`  FROM `users` WHERE nm_user = '".$nuser."' AND ds_pass = '".$npass."' LIMIT 1");
	$result = mysqli_fetch_assoc($query);
	
	if (empty($result)) {
		return false;
		 
	} 
	else {
		$_SESSION['cd_user'] = $result['cd_user']; 
		$_SESSION['nm_user'] = $result['nm_user']; 
	
		$_SESSION['userLogin'] = $user;
		$_SESSION['passLogin'] = $pass;
		
		return true;
	}
}

function protegePagina() {
	if (!isset($_SESSION['cd_user']) OR !isset($_SESSION['nm_user'])) {
		expulsaVisitante();
	} 
	else if (!isset($_SESSION['cd_user']) OR !isset($_SESSION['nm_user'])) {
		if (!validaUsuario($_SESSION['userLogin'], $_SESSION['passLogin'])) {
			expulsaVisitante();
		}
	}
}

function expulsaVisitante() {
	unset($_SESSION['cd_user'], $_SESSION['nm_user'], $_SESSION['userLogin'], $_SESSION['passLogin']);
	header("Location: index.php");
}


function lastHit($emp) {
	if ($emp['tm_exit']) {
		return array(
			'type' => 'exit',
			'time' => $emp['tm_exit'],
			'name' => 'Saída',
			'shortname' => 'Saída'
		);
	}
	if ($emp['tm_esnack']) {
		return array(
			'type' => 'esnack',
			'time' => $emp['tm_esnack'],
			'name' => 'Volta do Intervalo',
			'shortname' => 'R Intervalo'
		);
	}
	if ($emp['tm_snack']) {
		return array(
			'type' => 'snack',
			'time' => $emp['tm_snack'],
			'name' => 'Intervalo',
			'shortname' => 'Intervalo'
		);
	}
	if ($emp['tm_elunch']) {
		return array(
			'type' => 'elunch',
			'time' => $emp['tm_elunch'],
			'name' => 'Volta do Almoço',
			'shortname' => 'R Almoço'
		);
	}
	if ($emp['tm_lunch']) {
		return array(
			'type' => 'lunch',
			'time' => $emp['tm_lunch'],
			'name' => 'Almoço',
			'shortname' => 'Almoço'
		);
	}
	if ($emp['tm_entry']) {
		return array(
			'type' => 'entry',
			'time' => $emp['tm_entry'],
			'name' => 'Entrada',
			'shortname' => 'Entrada'
		);
	}
}

function dateBr($date){
    $date = new datetime($date);
    return $date->format('d-m-Y');
}

function justificationName($str){
	switch ($str) {
		case 'late':
			return 'Sem justificativa';
		break;
		case 'medic':
			return 'Atestado Médico';
		break;
		case 'declaration':
			return 'Declaração sem abono';
		break;
		case 'latemanager':
			return 'Gerente atrasado';
		break;
		case 'other':
			return 'Outros';
		break;
	}
}

function uf($str, $a){
    if($a){
        return substr($str, 0,$a);
    }else{
        return substr($str, 0,8);
    }
	
}
?>