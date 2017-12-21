<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$date =  (isset($_POST['inputHoliDate'])) ? $_POST['inputHoliDate'] : '';
	$name =  (isset($_POST['inputNmHoli'])) ? $_POST['inputNmHoli'] : '';
	$check = (isset($_POST['check'])) ? $_POST['check'] : '';	

	$result['status'] = 'fail';
	
	if(!empty($date)){
			
		$existHoliday = $conn->numRows("SELECT * FROM holidays WHERE dt_holiday = '$date'");

		if($existHoliday == 0){
			
			foreach($check as $store){
				$insert = $conn->sqlQuery("INSERT INTO holidays (dt_holiday, nm_holiday, cd_store) 
									   VALUES ('$date', '$name', '$store')");				   
			}
								   
			if($insert){
				$result['status'] = 'successNewHoli';	
			}
		}
		else{
			$result['status'] = 'holiUsed';
		}
		
	}

}

?>
<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successNewHoli'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Feriado cadastrado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewHoli.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Cadastrar outro feriado.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao cadastrar o feriado!</label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewHoli.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>