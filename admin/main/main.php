<?php
include_once ('header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;


$stores = $conn -> sqlQuery("SELECT * FROM stores ORDER BY nm_store");
?>

<body id='base'>
	<?php include_once('menu.php') ?>
	<audio id='notificationSound' hidden>
		<source  src="../../sound/not1.mp3" type="audio/mpeg">
		Your browser does not support the audio element.
	</audio>
    
    <div id='modal_justification' class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">     
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    
	<div id="mainCont">
        <div class='widget_options'>
            <div class='select_store'>
                <select name="inputNotificationStore" id="inputNotificationStore">
                    <option value="0"  >Todas as lojas</option>
                    <?php while ($estore = mysqli_fetch_assoc($stores)) {?>
                    <option value="<?php echo $estore['cd_store']; ?>" ><?php echo $estore['nm_store'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class='checkbox_widget'>
                <input type="checkbox" name="checkbox_widget_ontime" id="checkbox_widget_ontime" class="css-checkbox" >
                <label for="checkbox_widget_ontime" class="css-label">Regulares</label>
            </div>
            <div class='checkbox_widget'>
                <input type="checkbox" name="checkbox_widget_late" id="checkbox_widget_late" class="css-checkbox" >
                <label for="checkbox_widget_late" class="css-label">Atrasados</label>
            </div>
            <div class='checkbox_widget'>
                <input type="checkbox" name="checkbox_widget_miss" id="checkbox_widget_miss" class="css-checkbox" >
                <label for="checkbox_widget_miss" class="css-label">Faltaram</label>
            </div>
            <div class='checkbox_widget'>
                <input type="checkbox" name="checkbox_widget_dayoff" id="checkbox_widget_dayoff" class="css-checkbox" >
                <label for="checkbox_widget_dayoff" class="css-label">Folgas  e Férias</label>
            </div>

        </div>
        <div class='widget_content'>
		
        </div>
	</div>
</body>
</html> 