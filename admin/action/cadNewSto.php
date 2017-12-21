<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nmStore = (isset($_POST['inputNmSto'])) ? $_POST['inputNmSto'] : '';
	$insc = (isset($_POST['inputInsc'])) ? $_POST['inputInsc'] : '';
	$cnpj = (isset($_POST['inputCNPJ'])) ? $_POST['inputCNPJ'] : '';
	$cidade = (isset($_POST['inputCidade'])) ? $_POST['inputCidade'] : '';
	
	$result['status'] = 'fail';
	
	if(!empty($nmStore) && !empty($insc) && !empty($cnpj) && !empty($cidade)){
				
		$canUseStore = $conn->numRows("SELECT cd_cnpj FROM stores WHERE cd_cnpj = '$cnpj'");
		if($canUseStore == 0){
			
			$insert = $conn->sqlQuery("INSERT INTO stores (nm_store, ds_inscricao, cd_cnpj, nm_cidade) 
									   VALUES 			     ('$nmStore', '$insc', '$cnpj', '$cidade')");
								   
			if($insert){
				$result['status'] = 'successNewSto';	
			}
		}
		else{
			$result['status'] = 'stoUsed';
		}
	}

}

?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successNewSto'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Loja cadastrada com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewSto.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Cadastrar outra loja.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao cadastrar a loja!</label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewSto.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
