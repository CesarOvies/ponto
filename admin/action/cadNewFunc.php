<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nmFunc = (isset($_POST['inputNmFunc'])) ? $_POST['inputNmFunc'] : '';
	
	$result['status'] = 'fail';
	
	if(!empty($nmFunc)){
				
		$canUseName = $conn->numRows("SELECT cd_func FROM functions WHERE nm_func = '$nmFunc'");
		if($canUseName == 0){
			
			$insert = $conn->sqlQuery("INSERT INTO functions (nm_func) 
									   VALUES 				 ('$nmFunc')");
								   
			if($insert){
				
				$result['status'] = 'successNewFunc';	
			}
		}
		else{
			$result['status'] = 'funcUsed';
		}
	}
}

?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successNewFunc'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Função cadastrada com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewFunc.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Cadastrar outra função.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao cadastrar a função!</label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewFunc.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
