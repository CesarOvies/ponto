<div id="menu">
	<div class='menu_center'>
		<div class="col-sm-11">
			<ul id="tabs" class="nav nav-pills ">
				<li>
					<a href="../main/main.php" >Home</a>
				</li>
				<li class="liSeparator"></li>
				<li class="dropdown">
					<a class="dropdown-toggle"  data-toggle="dropdown"href="#"> Cadastro <span class="caret"></span> </a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="../cad/cadNewEmp.php" >Novo Funcionário</a>
						</li>
						<li>
							<a href="../cad/cadNewFunc.php" >Nova Função</a>
						</li>
						<li>
							<a href="../cad/cadNewTurn.php" >Novo Turno</a>
						</li>
						<li>
							<a href="../cad/cadNewSto.php" >Nova Loja</a>
						</li>
						<li>
							<a href="../cad/cadNewHoli.php" >Novo Feriado</a>
						</li>
					</ul>
				</li>
				<li class="liSeparator"></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Editar <span class="caret"></span> </a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="../edit/editEmp.php" >Editar Funcionário</a>
						</li>
						<li>
							<a href="../edit/editTurn.php" >Editar Turno</a>
						</li>
						<li>
							<a href="../edit/editHoli.php" >Editar Feriado</a>
						</li>
					</ul>
				</li>
				<li class="liSeparator"></li>

				<li>
					<a href="../edit/editTime.php">Editar Horários</a>
				</li>
				
				<!--<li class="liSeparator"></li>
				<li>
                   <a href="../edit/repEmp.php" >Relatório por Funcionário</a>
				</li>
				<li class="liSeparator"></li>-->
				
				</li>

       			<li class="liSeparator"></li>

                <li>

                <a href='#' onclick="reloadClients();"> Refresh </a>

                </li>

				<li class="liSeparator"></li>

                <li>

				<a href="logout.php">Logout</a>

				</li>
                    
                </li>
			</ul>
		</div>
		<div class="windows8" id="loader">
			<?php
			include ('../../loader.php');
			?>
		</div>

		<div id='configButton' class="col-sm-1 dropdown"> <!-- Botão Configurações notificações-->
			<img src="../../img/gear.png" class=" dropdown-toggle"  data-toggle="dropdown" aria-expanded="true"/>
			<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
				<li role="presentation" class="dropdown-header">
					Notificações
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxEntry' type='checkbox' >
						Entradas </label>
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxLate' checked="checked" type='checkbox' >
						Atrasos de Chegada </label>
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxLunch' type='checkbox' >
						Almoço </label>
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxSnack' type='checkbox' >
						Intervalo </label>
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxLateSnack' checked="checked" type='checkbox' >
						Atraso de Intervalo </label>
				</li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxExit' type='checkbox' >
						Saída </label>
				</li>
				<li role="presentation" class="divider"></li>
				<li role="presentation" class="checkbox">
					<label>
						<input class='checkboxs' id='checkboxSound' type='checkbox' >
						Sound </label>
				</li>
			</ul>
		</div>
	</div>
</div>
