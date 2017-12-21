<?php
require_once ('../class/functions.php');
require_once ('../class/cxoi.class.php');

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

	die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['data']) && isset($_POST['choice'])) {

		$choice = $_POST['choice'];
		$data = $_POST['data'];
		$r = [];
		$conn = new Cxoi();

		switch($choice) {
			case 'btnSnack' :
				$choice = 'snack';
				break;
			case 'btnExit' :
				$choice = 'exit';
				break;
			case 'btnLunch' :
				$choice = 'lunch';
				break;
		}

		if ($choice == 'snack') {
			$empSnacking = $conn -> numRows("SELECT e.cd_emp FROM employees e INNER JOIN times t ON e.cd_emp = t.cd_emp WHERE t.dt_time = '" . $data['date'] . "' AND e.cd_store = '" . $data['emp']['cd_store'] . "' AND e.cd_func = '" . $data['emp']['cd_func'] . "' AND t.tm_snack IS NOT NULL AND t.tm_esnack IS NULL");
			if ($empSnacking > 0) {
				$r['choice'] = 'cantSnack';
			} else {
                $insert = $conn -> sqlQuery("UPDATE times SET tm_snack = '" . $data['now'] . "'  WHERE dt_time = '" . $data['date'] . "' AND cd_emp = '" . $data['emp']['cd_emp'] . "'");
				if ($insert) {
					$r['choice'] = $choice;
					$r['nchoice'] = 3;
                    $r['typeHit'] = 'snack';
				}
			}
		} else if ($choice == 'lunch') {
            $insert = $conn -> sqlQuery("UPDATE times SET tm_lunch = '" . $data['now'] . "' , tm_turn_lunch = '".$data['turn']['lunch_' . $data['dof']]."' WHERE dt_time = '" . $data['date'] . "' AND cd_emp = '" . $data['emp']['cd_emp'] . "'");
			if ($insert) {
				$r['choice'] = $choice;
				$r['nchoice'] = 1;
                $r['typeHit'] = 'lunch';
			}
		} else if ($choice == 'exit') {
            $insert = $conn -> sqlQuery("UPDATE times SET tm_exit = '" . $data['now'] . "' , tm_turn_exit = '".$data['turn']['exit_' . $data['dof']]."' WHERE dt_time = '" . $data['date'] . "' AND cd_emp = '" . $data['emp']['cd_emp'] . "'");
			if ($insert) {
				$r['choice'] = $choice;
				$r['nchoice'] = 5;
                $r['typeHit'] = 'exit';
			}
		}
	}
    
	echo json_encode($r);
}
?>