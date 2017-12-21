<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_emp = (isset($_POST['inputSelEmp'])) ? $_POST['inputSelEmp'] : '';
};
$emp = $conn -> fetchArray("SELECT * FROM employees WHERE cd_emp  = '$cd_emp' ");
?>
<script>
	$("#switch_check").bootstrapSwitch();
	
	$('#switch_check').on('switchChange.bootstrapSwitch', function (event, state) {
		if(state == false){
    		$('#switch_check').removeAttr('checked');
		}else {
			$('#switch_check').attr('checked',true);
		}
	});
    $(':file').filestyle({
        buttonText : "Escolher Arquivo",
        buttonName : "btn-primary"
    });  
</script>
<form class="form-horizontal" role="form" method="post" id="form-editEmp" action="../action/editEmp.php" enctype="multipart/form-data">
	<input value="<?php echo $emp['cd_emp']?>" type="hidden" class="form-control required" id="inputEditCod" name="inputEditCod">
	<div class="desativarEmp">
		<label class='sitFunc'>Situação do funcionário</label>
		<input name='isActiveCheck' type="checkbox" <?php echo (($emp['is_active'] == 1) ? 'checked=\'true\'':'')?> data-off-text="Desativado" data-on-text='Ativo' id='switch_check' >
	</div>
	<div class="contPic">
		<div id='pictureNewEmp'>
			<div id='pictureinputFotoEdit' <?php echo (!empty($emp['ds_pic'])) ? "style='background-image: url(../../pic/".$emp['ds_pic'].")'" : "style='background-image: url(../../img/misspic.png)'" ?>></div>
		</div>
	</div>
	<?php echo (!empty($emp['ds_pic'])) ? '<div class="removeFoto"><img src="../../img/negative.png" >Remover Foto</div>' : ''
	?>

	<div class="form-group">
		<label for="inputEditName" class="col-sm-4 control-label">Nome</label>
		<div class="col-sm-4">
			<input value="<?php echo $emp['nm_emp']?>" type="name" class="form-control required" id="inputEditName" name="inputEditName" placeholder="Nome">
		</div>
	</div>
    <div class="form-group">
        <label for="inputDateHire" class="col-sm-4 control-label">Data de Admição</label>
        <div class="col-sm-4">
            <input value="<?php echo $emp['dt_hire']?>" type="date" class="form-control required" id="inputDateHire" name="inputDateHire" placeholder="">
        </div>
    </div>
	<div class="form-group">
		<label for="inputEditTurn" class="col-sm-4 control-label">Turno</label>
		<div class="col-sm-4">
			<select class="form-control required" id="inputEditTurn" name="inputEditTurn">
				<option value="" disabled>Turno</option>
				<?php
				$conn = new Cxoi;
				$turns = $conn -> sqlQuery('SELECT * FROM turns');
				while ($eTurn = mysqli_fetch_assoc($turns)) {
					$selected = "";
					if ($emp['cd_turno'] == $eTurn['cd_turn']) { $selected = 'selected';
					};
					echo "<option value='" . $eTurn['cd_turn'] . "' " . $selected . " >" . $eTurn['nm_turn'] . "</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEditFunc" class="col-sm-4 control-label">Função</label>
		<div class="col-sm-4">
			<select class="form-control required" id="inputEditFunc" name="inputEditFunc">
				<option value="" disabled>Função</option>
				<?php
				$functions = $conn -> sqlQuery('SELECT * FROM functions');
				while ($eFunction = mysqli_fetch_assoc($functions)) {
					$selected = "";
					if ($emp['cd_func'] == $eFunction['cd_func']) { $selected = 'selected';
					};
					echo "<option value='" . $eFunction['cd_func'] . "' " . $selected . " >" . $eFunction['nm_func'] . "</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEditPass" class="col-sm-4 control-label">Senha</label>
		<div class="col-sm-4">
			<input value="<?php echo $emp['ds_password']?>" type="text" class="form-control required" id="inputEditPass" name="inputEditPass" placeholder="Senha">
		</div>
	</div>
	<div class="form-group">
		<label for="inputEditStore" class="col-sm-4 control-label">Loja</label>
		<div class="col-sm-4">
			<select class="form-control required" id="inputEditStore" name="inputEditStore">
				<option value="" disabled>Loja</option>
				<?php
				$stores = $conn -> sqlQuery('SELECT * FROM stores');
				while ($eStore = mysqli_fetch_assoc($stores)) {
					$selected = "";
					if ($emp['cd_store'] == $eStore['cd_store']) { $selected = 'selected';
					};
					echo "<option value='" . $eStore['cd_store'] . "' " . $selected . " >" . $eStore['nm_store'] . "</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputFotoEdit" class="col-sm-4 control-label">Foto</label>
		<div class="col-sm-4">
            <input type="file" id="inputFotoEdit" class='filestyle' name="inputFotoEdit">
			<p class="help-block">
				
			</p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-4">
			<button type="submit" class="btn btn-primary">
				Alterar
			</button>
		</div>
	</div>
</form>
