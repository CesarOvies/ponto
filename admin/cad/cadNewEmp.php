<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;
?>


<body>

	<?php include('../main/menu.php')
	?>
	<div id="mainCont">

        <div class="section_title">Novo Funcionário</div>
        <div class="form-group section_select">
        </div>
		<form class="form-horizontal send_form" role="form" method="post" action="../action/cadNewEmp.php" id="form-cadNewEmp" enctype="multipart/form-data">
			<div class="contPic">
				<div id='pictureinputFoto' style='background-image: url(../../img/misspic.png)' ></div>
			</div>
			<div class="form-group">
				<label for="inputName" class="col-sm-4 control-label">Nome</label>
				<div class="col-sm-4">
					<input type="name" class="form-control required" id="inputName" name="inputName" placeholder="Nome">
				</div>

			</div>
			<div class="form-group">
				<label for="inputTurn" class="col-sm-4 control-label">Turno</label>
				<div class="col-sm-4">
					<select class="form-control required" id="inputTurn" name="inputTurn">
						<option value="" selected>Turno</option>
						<?php
						$turns = $conn -> sqlQuery('SELECT * FROM turns');
						while ($eTurn = mysqli_fetch_assoc($turns)) {
							echo "<option value='" . $eTurn['cd_turn'] . "'>" . $eTurn['nm_turn'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="clearfix "></div>
			<div class="form-group">
				<label for="inputFunc" class="col-sm-4 control-label">Função</label>
				<div class="col-sm-4">
					<select class="form-control required" id="inputFunc" name="inputFunc">
						<option value="" selected>Função</option>
						<?php
						$functions = $conn -> sqlQuery('SELECT * FROM functions');
						while ($eFunction = mysqli_fetch_assoc($functions)) {
							echo "<option value='" . $eFunction['cd_func'] . "'>" . $eFunction['nm_func'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputStore" class="col-sm-4 control-label">Loja</label>
				<div class="col-sm-4">
					<select class="form-control required" id="inputStore" name="inputStore">
						<option value="" selected>Loja</option>
						<?php
						$stores = $conn -> sqlQuery('SELECT * FROM stores');
						while ($eStore = mysqli_fetch_assoc($stores)) {
							echo "<option value='" . $eStore['cd_store'] . "' >" . $eStore['nm_store'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPass" class="col-sm-4 control-label">Senha</label>
				<div class="col-sm-4">
					<input type="text" class="form-control required" id="inputPass" name="inputPass" placeholder="Senha">
				</div>
			</div>
			<div class="form-group">
				<label for="inputFoto" class="col-sm-4 control-label">Foto</label>
				<div class="col-sm-4">
                    <input type="file" id="inputFoto" class='filestyle' name="inputFoto">
					<p class="help-block">
						
					</p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-4">
					<button type="submit" class="btn btn-primary">
						Enviar
					</button>
				</div>
			</div>
		</form>

	</div>
</body>
<script>
$(':file').filestyle({
    buttonText : "Escolher Arquivo",
    buttonName : "btn-primary"
});  
</script>
</html>