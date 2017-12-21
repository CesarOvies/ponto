<?php
ini_set ( "memory_limit", "128M");
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ("../../class/upimage.class.php");
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_emp = (isset($_POST['inputEditCod'])) ? $_POST['inputEditCod'] : '';
	$name = (isset($_POST['inputEditName'])) ? $_POST['inputEditName'] : '';
	$pass = (isset($_POST['inputEditPass'])) ? $_POST['inputEditPass'] : '';
	$turn = (isset($_POST['inputEditTurn'])) ? $_POST['inputEditTurn'] : '';
	$func = (isset($_POST['inputEditFunc'])) ? $_POST['inputEditFunc'] : '';
	$store = (isset($_POST['inputEditStore'])) ? $_POST['inputEditStore'] : '';
	$foto = (isset($_FILES['inputFotoEdit'])) ? $_FILES['inputFotoEdit'] : '';
	$active = (isset($_POST['isActiveCheck'])) ? '1' : '0';
    $hire = (isset($_POST['inputDateHire'])) ? $_POST['inputDateHire'] : '';
	
	$result['status'] = 'fail';
	$isFotoUp = false;

	if (!empty($name) && !empty($pass) && !empty($turn) && !empty($func) ) {

		$canUsePass = $conn -> numRows("SELECT cd_emp FROM employees WHERE ds_password = '$pass' AND cd_emp <> '$cd_emp' ");
		if ($canUsePass == 0) {
			
			if (!empty($foto) && $foto["error"] == UPLOAD_ERR_OK) {
			
			$upFoto = new Upload($_FILES['inputFotoEdit']);
			
			if ($upFoto -> uploaded) {
				$justFileName = removeAccents(preg_replace('/\s+/', '', strtolower($name)));
				$rand = rand(0, 99999999);
				$File_Name = preg_replace('/\s+/', '', strtolower($_FILES['inputFotoEdit']['name'])); 
				$File_Ext = substr($File_Name, strrpos($File_Name, '.'));
				$nmFoto = $rand.'_'.$justFileName.$File_Ext;
				$upFoto -> image_resize = TRUE;
				$upFoto -> file_new_name_body = $rand.'_'.$justFileName;
				$upFoto -> image_x = 140;
				$upFoto -> image_y = 140;
				$upFoto -> image_ratio_crop = TRUE;
				$upFoto -> file_safe_name = TRUE;
				$upFoto -> image_ratio = TRUE;
				$upFoto -> dir_auto_chmod = TRUE;
				$upFoto -> dir_chmod = 0777;
				$upFoto -> Process('../../pic/');
				$cm_img = $upFoto -> file_dst_name;
				//echo $upFoto->log;											
				if ($upFoto -> processed) {
					$isFotoUp = true;
				}
			}
		}
		if (!$isFotoUp) {
			$sqlFoto = "";
		} else {
			$sqlFoto = ", ds_pic='$nmFoto '";
            echo $sqlFoto;
		}		
			
			$insert = $conn -> sqlQuery("UPDATE employees 
										 SET nm_emp='$name', ds_password='$pass', cd_turno='$turn', 
										 cd_func='$func', cd_store='$store', is_active='$active' ".$sqlFoto.", dt_hire ='$hire' 
										 WHERE cd_emp = '$cd_emp'");

			if ($insert) {
				$result['status'] = 'successEditEmp';
			}
		} else {
			$result['status'] = 'failEditEmp';
		}

	}
}
?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successEditEmp'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Funcionário editado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/editEmp.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Editar outro funcionário.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao editar o funcionário!</label>.
						<a class=\'hrefRepeat\' href=\'../edit/editEmp.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
