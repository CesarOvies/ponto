<div class='container_notifications'>
	<div class='select_store'>
		<select name="inputNotificationStore" id='inputNotificationStore'>
			<option value="" disabled selected>Escolha a loja</option>
			<?php
			$store = $conn -> sqlQuery('SELECT * FROM stores ORDER BY nm_store');
			while ($estore = mysqli_fetch_assoc($store)) {
				echo "<option value='" . $estore['cd_store'] . "'>" . $estore['nm_store'] . "</option>";
			}
			?>
		</select>
	</div>
	<div class='container_employees'>
	</div>
</div>
