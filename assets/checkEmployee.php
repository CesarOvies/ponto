<?php
include ('../class/cxoi.class.php');
include ('../class/functions.php');
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['pass'])) {

		$pass = $_POST['pass'];
		//$pass = '123';

		$conn = new Cxoi();
		$r['emp'] = $conn -> fetchAssoc("SELECT * FROM employees WHERE ds_password = '$pass'");
		if ($r['emp']) {

			$tm_names = ['tm_entry', 'tm_lunch', 'tm_elunch', 'tm_snack', 'tm_esnack', 'tm_exit'];
			$dof_names = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

			$r['num_late_warning']=0;
			$r['status'] = '';
			$r['just'] = [];
			$r['month_mlate'] = 0;

			$date = date('Y-m-d');
			$t = explode(" ", microtime());
			$now = date("H:i:s", $t[1]) . substr((string)$t[0], 1, 4);
			$date = date('Y-m-d');
			$dof = date('w');

			$r['now'] = $now;
			$r['mnow'] = hourToSec($now);
			$r['date'] = $date;
			$r['dof'] = $dof_names[$dof];

			$r['time'] = $conn -> fetchAssoc("SELECT * FROM times WHERE cd_emp = '" . $r['emp']['cd_emp'] . "' AND dt_time = '$date'");
			$r['turn'] = $conn -> fetchAssoc("SELECT * FROM turns WHERE cd_turn = '" . $r['emp']['cd_turno'] . "'");
            $r['store'] = $conn -> fetchAssoc("SELECT * FROM stores WHERE cd_store = '" . $r['emp']['cd_store'] . "'");

			$data = $conn -> sqlQuery("SELECT * FROM justifications WHERE cd_emp = '" . $r['emp']['cd_emp'] . "' AND  EXTRACT(YEAR_MONTH from dt_just) =  EXTRACT(YEAR_MONTH from '" . $date . "')");
			while ($row = mysqli_fetch_assoc($data)) {
				array_push($r['just'], $row);
				if ($row['tp_just'] == 'late') {
					$r['month_mlate'] = $r['month_mlate'] + $row['sz_late'];
					if($r['month_mlate'] > $GLOBALS['$month_tolerance']){
						$r['num_late_warning']++;
					}
				}
			}

			foreach ($r['turn'] as $key => $turn) {
				if ($key != 'cd_turn' && $key != 'nm_turn' && $key != 'day_off') {
					$r['mturn'][$key] = hourToSec($turn);
				}
			};

			foreach ($tm_names as $name) {
				if (isset($r['time'][$name])) {
					$r['mtime'][$name] = hourToSec($r['time'][$name]);
				}
			};

			// Check which STATUS
			if (is_null($r['time']['tm_exit'])) {// se saida esta vazia
				if (!isset($r['time']['tm_entry'])) {// se entrada nao setada
					if ($r['mnow'] > $r['mturn']['entry_' . $r['dof']] + $GLOBALS['toleration_on_arrival']) {// se NOW > que hora de entrada
						$r['mlate'] = $r['mnow'] - $r['mturn']['entry_' . $r['dof']];
						$r['status'] = 'entryLate';
					} else {// se nao esta atrasado
                        //echo "INSERT INTO times (dt_time, cd_emp, tm_entry, tm_turn_entry) VALUES ('" . $r['date'] . "', '" . $r['emp']['cd_emp'] . "', '" . $r['now'] . "', '".$r['turn']['entry_' . $r['dof']]."')";
                        $insert = $conn -> sqlQuery("INSERT INTO times (dt_time, cd_emp, tm_entry, tm_turn_entry) VALUES ('" . $r['date'] . "', '" . $r['emp']['cd_emp'] . "', '" . $r['now'] . "', '".$r['turn']['entry_' . $r['dof']]."')");
						if ($insert) {
							$r['status'] = 'entry';
							$r['nstatus'] = '0';
						}
					}
                    $r['typeHit'] = 'entry';
				} else {// se entrada setada
					$last_hit = array_keys($r['mtime'], max($r['mtime']));
					$r['last_hit'] = $last_hit[0];
					if (($r['mnow'] - $r['mtime'][$r['last_hit']]) > $GLOBALS['delay_to_hit_again']) {// se ja passou tempo para bater novamente
						if ($r['last_hit'] == 'tm_entry' || $r['last_hit'] == 'tm_elunch' || $r['last_hit'] == 'tm_esnack') {
							if (!is_null($r['time']['tm_esnack']) && !is_null($r['time']['tm_elunch'])) {
                                $insert = $conn -> sqlQuery("UPDATE times SET tm_exit = '" . $r['now'] . "' , tm_turn_exit = '".$r['turn']['exit_' . $r['dof']]."' WHERE dt_time = '" . $r['date'] . "' AND cd_emp = '" . $r['emp']['cd_emp'] . "'");
								if ($insert) {
									$r['status'] = 'exit';
									$r['nstatus'] = '5';
                                    $r['typeHit'] = 'exit';
								}
							} else {
								$r['status'] = 'ask';
							}
						} else if ($r['last_hit'] == 'tm_lunch') {//
                            $insert = $conn -> sqlQuery("UPDATE times SET tm_elunch = '" . $r['now'] . "' , tm_turn_elunch = '".$r['turn']['elunch_' . $r['dof']]."' WHERE dt_time = '" . $r['date'] . "' AND cd_emp = '" . $r['emp']['cd_emp'] . "'");
							if ($insert) {
								$r['status'] = 'elunch';
								$r['nstatus'] = '2';
                                $r['typeHit'] = 'elunch';
							}
						} else if ($r['last_hit'] == 'tm_snack') {
                            $insert = $conn -> sqlQuery("UPDATE times SET tm_esnack = '" . $r['now'] . "' WHERE dt_time = '" . $r['date'] . "' AND cd_emp = '" . $r['emp']['cd_emp'] . "'");
							if ($insert) {
								$r['status'] = 'esnack';
								$r['nstatus'] = '4';
                                $r['typeHit'] = 'esnack';
							}
						}
					} else {
						$r['status'] = 'tooSoon';
					}
				}
			} else {
				$r['status'] = 'alreadyleft';
			}
            
            
            if($r['time'] != null){
                $r['node'] = array_merge($r['emp'],$r['time'],$r['store'],$r['turn']);
            }else{ 
                $r['node'] = array_merge($r['emp'],$r['store'],$r['turn']);
            }
            
            if(isset($r['typeHit'])){
                if($r['status']=='entryLate'){
                    $r['node'] = array_merge($r['emp'],$r['store'],$r['turn']);
                    
                }
               
                $r['node']['tm_'.$r['typeHit']] = $r['now'];
            }
            if($r['just']){
                $key = end($r['just']);
                if($key['dt_just'] == $date){
                    $r['node'] = array_merge($r['node'], $key);
                   
                }
            }
            $r['node']['dt_time'] = $r['date'];
           
		}
		//var_dump($r);
		echo json_encode($r);
	}
}
?>