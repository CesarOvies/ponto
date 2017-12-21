<?php
include ('../class/cxoi.class.php');
include ('../class/functions.php');
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$error = 0;
	$r = (isset($_POST['data'])) ? json_decode($_POST['data'], true) : '';
	$rjust = [];

	if (!isset($r['form']['inputPassManager'])) {
		$rjust['status'] = 'noPass';
	} else {
		$conn = new Cxoi;

		$manager = ($r['emp']['cd_func'] == 8) ? '(cd_func = 100)' : '(cd_func = 8 OR cd_func = 100)';
		$permission = $conn -> sqlQuery('SELECT cd_emp FROM employees WHERE ' . $manager . ' AND is_active = 1 AND ds_password = \'' . $r['form']['inputPassManager'] . '\'');
		$permission = mysqli_fetch_assoc($permission);

		if ($permission) {

			if ($r['reason'] == 'late') {
				$justfication_query = "INSERT INTO justifications (cd_emp, dt_just, tp_just, sz_late, cd_manager) VALUES ('" . $r['emp']['cd_emp'] . "', '" . $r['date'] . "', '" . $r['reason'] . "', '" . $r['mlate'] . "', '" . $permission['cd_emp'] . "')";
				$rjust['html'] = justificationTemplate($r);
			}

			if ($r['reason'] == 'latemanager') {
				$justfication_query = "INSERT INTO justifications (cd_emp, dt_just, tp_just, sz_late, cd_manager) VALUES ('" . $r['emp']['cd_emp'] . "', '" . $r['date'] . "', '" . $r['reason'] . "', '" . $r['mlate'] . "', '" . $permission['cd_emp'] . "')";
			}

			if ($r['reason'] == 'other') {
				$justfication_query = "INSERT INTO justifications (cd_emp, dt_just, tp_just, ds_just, sz_late, cd_manager) VALUES ('" . $r['emp']['cd_emp'] . "', '" . $r['date'] . "', '" . $r['reason'] . "', '" . $_POST['inputDescriptJustification'] . "', '" . $r['mlate'] . "', '" . $permission['cd_emp'] . "')";
			}

			if ($r['reason'] == 'medic' || $r['reason'] == 'declaration') {

				$dir = '../justifications/';
				$max_size = 1024 * 1024 * 10;
				$ext = ['jpg', 'png', 'pdf', 'gif'];

				if ($_FILES['inputJustificationFile']['error'] != 0) {
					$error++;
				}

				$extension = explode('.', $_FILES['inputJustificationFile']['name']);
				$extension = strtolower(end($extension));
				if (array_search($extension, $ext) === false) {
					$error++;
				}

				if ($max_size < $_FILES['inputJustificationFile']['size']) {
					$error++;
				}

				$finalname = str_replace(' ', '', strtolower($r['date'] . '_' . $r['emp']['nm_emp'] . '.' . $extension));
				if ($error == 0) {
					if (move_uploaded_file($_FILES['inputJustificationFile']['tmp_name'], $dir . $finalname)) {
						if ($r['reason'] == 'medic') {
							$justfication_query = "INSERT INTO justifications (cd_emp, dt_just, tp_just, ds_file, tm_begin, tm_end, sz_late, cd_manager) VALUES ('" . $r['emp']['cd_emp'] . "', '" . $r['date'] . "', '" . $r['reason'] . "', '" . $finalname . "', '" . $_POST['inputJustificationBegin'] . "', '" . $_POST['inputJustificationEnd'] . "', '" . $r['mlate'] . "', '" . $permission['cd_emp'] . "')";
						} else {
							$justfication_query = "INSERT INTO justifications (cd_emp, dt_just, tp_just, ds_file, sz_late, cd_manager) VALUES ('" . $r['emp']['cd_emp'] . "', '" . $r['date'] . "', '" . $r['reason'] . "', '" . $finalname . "', '" . $r['mlate'] . "', '" . $permission['cd_emp'] . "')";
						}

					} else {
						$error++;
					}
				}

			}

			if ($error == 0) {
				$insertJust = $conn -> sqlQuery($justfication_query);
				if ($insertJust) {
                    $insert = $conn -> sqlQuery("INSERT INTO times (dt_time, cd_emp, tm_entry, tm_turn_entry) VALUES ('" . $r['date'] . "', '" . $r['emp']['cd_emp'] . "', '" . $r['now'] . "', '".$r['turn']['entry_' . $r['dof']]."')");
					if ($insert) {
						$rjust['status'] = 'success';
					}
				}
			}
            $rjust['just'] = array('dt_just' => $r['date'],
                                   'tp_just' =>$r['reason'],
                                   'ds_just' =>(isset($_POST['inputDescriptJustification']))? $_POST['inputDescriptJustification'] : null,
                                   'ds_file' =>(isset($finalname)) ? $finalname : null,
                                   'tm_begin' =>(isset($_POST['inputJustificationBegin']))? $_POST['inputJustificationBegin'] : null,
                                   'tm_end' =>(isset($_POST['inputJustificationEnd']))? $_POST['inputJustificationEnd'] : null,
                                   'sz_late' =>(isset($r['mlate']))? $r['mlate'] : null,
                                   'cd_manager' =>$permission['cd_emp']
                                  );   
            
            
		} else {
			$rjust['status'] = 'noManager';
		}
	}
	echo json_encode($rjust);
}

function justificationTemplate($r) {
		$date = explode('-', $r['date']);
		$minLate = explode('.',$r['mlate']/60);
		$late_to_today = explode('.',(($r['month_mlate']+$r['mlate'])/60));
		
		
		
		
/*  art 16º da convenção coletiva de trabalho 2014/2015 que estabelece: <b>Assegura-se a tolerância no atrado de até 30(trinta) minutos no início da jornada, por mês, justificado por problemas de mobilidade urbana</b>.  */





	if ($r['month_mlate']+$r['mlate'] > $GLOBALS['$month_tolerance'] ) {
		$html = "
<div class='container' >
	<div class='title'>
		<b>AVISO DE ADVERTÊNCIA AO EMPREGADO</b>
	</div>
	<div class='content'>
		<span style='float:left'><b>" . $r['emp']['nm_emp'] . "</b></span>
		<span style='float:right'><b>$date[2] de " . nameMonth($date[1]) . " de $date[0]</b></span>
		<br>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pelo presente fica V.S. advertido pelo atraso de hoje. O qual somado ao total do mês resulta em $late_to_today[0] minutos. 
		</p>

		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esperamos que V.S. procure não incorrer em novas faltas, pois caso contrário tomaremos medidas mais severas, que nos são facultadas pela CLT.
		</p>

		<div style='overflow:hidden;'>
			<b>
			<center>
				CIENTE
			</center></b>
			<span style='float:left;font-size:10px;'>_______________________________________________
				<br>
				<center>
					EMPREGADO
				</center></span>
			<span style='float:right;font-size:10px;'>_______________________________________________
				<br>
				<center>
					EMPREGADOR
				</center></span>
			<br>
			<br>
			<br>
			<span style='float:left;font-size:10px;'>_______________________________________________
				<br>
				<center>
					TESTEMUNHA
				</center></span>
			<span style='float:right;font-size:10px;'>_______________________________________________
				<br>
				<center>
					TESTEMUNHA
				</center></span>
		</div>
	</div>
</div>";
	} else {
		$saldo_late = 30-$late_to_today[0];
		$html = "
<div class='container' >
	<div class='title'>
		<b> NOTIFICAÇÃO AO EMPREGADO</b>
	</div>
	<div class='content'>
		<span style='float:left'><b>" . $r['emp']['nm_emp'] . "</b></span>
		<span style='float:right'><b>$date[2] de " . nameMonth($date[1]) . " de $date[0]</b></span>
		<br>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pelo presente fica V.S. notificado pelos atrasos discriminadas abaixo:
		</p>
		<p class='justificativa' >
			Chegou atrasado $minLate[0] minutos e ainda tem um saldo de $saldo_late minutos neste mês conforme art 16º da convenção coletiva de trabalho 2014/2015 que estabelece: <b>Assegura-se a tolerância no atraso de até 30(trinta) minutos no início da jornada, por mês, justificado por problemas de mobilidade urbana</b>. <b></b>
		</p>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esperamos que V.S. procure não incorrer em novos atrasos, pois caso contrário tomaremos medidas mais severas, que nos são facultadas pela CLT.
		</p>

		<div style='overflow:hidden;'>
			<b>
			<center>
				CIENTE
			</center></b>
			<span style='float:left;font-size:10px;'>_______________________________________________
				<br>
				<center>
					EMPREGADO
				</center></span>
			<span style='float:right;font-size:10px;'>_______________________________________________
				<br>
				<center>
					EMPREGADOR
				</center></span>
			<br>
			<br>
			<br>
			<span style='float:left;font-size:10px;'>_______________________________________________
				<br>
				<center>
					TESTEMUNHA
				</center></span>
			<span style='float:right;font-size:10px;'>_______________________________________________
				<br>
				<center>
					TESTEMUNHA
				</center></span>
		</div>
	</div>
</div>";
		
	}
	$style = "
<style>
	.container {border:1px solid;padding:5px;width:95%;margin:0 auto;height:386px;}
	.title {border:1px solid;padding:10px;margin:auto;background-color:#FFF;font-size:22px;text-align:center;font-weight:bold}
	.content {border:1px solid;margin:5px auto 0;padding:10px;background-color:#FFF;height:310px;}
	.button {border: 1px solid;	background-color: #428bca;width: 70px;padding: 6px;margin: auto;border-radius: 7px;font-weight: bold;color: #FFF;text-align: center;cursor: pointer;}
	.justificativa {word-break:break-all;overflow:hidden;  word-break: break-word;}
</style>
<style media='print'>
	.button {display:none}
</style>
";
	$button = "<div class='button' onclick='window.print()'>Imprimir</div><br>";
	$hr = "<br><hr style='border:1px dashed' ><br>";
	return  $style . $button . $html . $hr . $html;
}
?>
