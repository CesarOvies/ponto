<?php
ini_set ( "memory_limit", "128M");
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ("../../class/upimage.class.php");
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = (isset($_POST['inputName'])) ? $_POST['inputName'] : '';
	$pass = (isset($_POST['inputPass'])) ? $_POST['inputPass'] : '';
	$turn = (isset($_POST['inputTurn'])) ? $_POST['inputTurn'] : '';
	$func = (isset($_POST['inputFunc'])) ? $_POST['inputFunc'] : '';
	$store = (isset($_POST['inputStore'])) ? $_POST['inputStore'] : '';
	$foto = (isset($_FILES['inputFoto'])) ? $_FILES['inputFoto'] : '';

	$result['status'] = 'fail';
	$isFotoUp = false;

	if (!empty($name) && !empty($pass) && !empty($turn) && !empty($func)) {

		$canUsePass = $conn -> numRows("SELECT cd_emp FROM employees WHERE ds_password = '$pass'");
		if ($canUsePass == 0) {

			if (!empty($foto) && $foto["error"] == UPLOAD_ERR_OK) {
				
				$upFoto = new Upload($_FILES['inputFoto']);
				
				if ($upFoto -> uploaded) {
					$justFileName = removeAccents(preg_replace('/\s+/', '', strtolower($name)));
					$rand = rand(0, 99999999);
					$File_Name = preg_replace('/\s+/', '', strtolower($_FILES['inputFoto']['name'])); 
    				$File_Ext = substr($File_Name, strrpos($File_Name, '.'));
					$nmFoto = $rand.'_'.$justFileName.$File_Ext;
					$upFoto -> image_resize = true;
					$upFoto -> file_new_name_body = $rand.'_'.$justFileName;
					$upFoto -> image_x = 140;
					$upFoto -> image_y = 140;
					$upFoto -> image_ratio_crop = true;
					$upFoto -> file_safe_name = true;
					$upFoto -> image_ratio = true;
					$upFoto -> dir_auto_chmod = true;
					$upFoto -> dir_chmod = 0777;
					$upFoto -> Process('../../pic/');
					$cm_img = $upFoto -> file_dst_name;
					
					if ($upFoto -> processed) {
						$isFotoUp = true;
					}
				}
			}
			if (!$isFotoUp) {
				$nmFoto = "";
			}
			$insert = $conn -> sqlQuery("INSERT INTO employees (nm_emp, ds_password, cd_turno, cd_func, cd_store, ds_pic, is_active) 
									   VALUES 				 ('$name','$pass','$turn','$func','$store','$nmFoto', '1')");

			if ($insert) {
				$result['status'] = 'successNewEmp';
			}
		} else {
			$result['status'] = 'passUsed';
		}

	}
}
?>


<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successNewEmp'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Funcionário cadastrado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewEmp.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Cadastrar outro funcionário.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao cadastrar o funcionário!</label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewEmp.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
