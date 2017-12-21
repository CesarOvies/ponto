<?php 
if($_POST){
    if($_POST['emp']){
        $eemp = $_POST['emp'];
    }
}
if(!$_POST){
?>
  <div id='emp_<?php echo $eemp['cd_emp'] ?>'  class='employees_row  <?php echo ($eemp['tm_entry'] === null) ? ' notArrived ' : ''?><?php echo ($grey == 1) ? ' greyrow ' : ''?>'>
<?php 
           }
?>
    <div class='employees_pic' >
        <img class='img-circle' src='pic/<?php echo ($eemp['ds_pic']) ? $eemp['ds_pic'] : '../img/misspicemp.png'?>'/>
    </div>

    <div class='employees_center' >
        <div class='employees_name'>
            <?php echo $eemp['nm_emp']
            ?>
        </div>
        <div class='indicators'>
            <div class='ind ind_entry <?php echo  (isset($eemp['tm_entry'])  && $eemp['tm_entry'] != null) ? 'hit' : ''?>' <?php echo  (isset($eemp['tm_entry']) && $eemp['tm_entry'] != null)  ? 'data-toggle="tooltip" data-placement="top" title="Entrada: '. substr($eemp['tm_entry'], 0, 8) .'"' : ''?>></div>
            <div class='ind ind_lunch <?php echo  (isset($eemp['tm_lunch'])  && $eemp['tm_lunch'] != null) ? 'hit' : ''?>' <?php echo  (isset($eemp['tm_lunch']) && $eemp['tm_lunch'] != null)  ? 'data-toggle="tooltip" data-placement="top" title="Almoço: '. substr($eemp['tm_lunch'], 0, 8) .'"' : ''?>></div>
            <div class='ind ind_elunch <?php echo (isset($eemp['tm_elunch']) && $eemp['tm_elunch'] != null) ? 'hit' : ''?>' <?php echo (isset($eemp['tm_elunch'])&& $eemp['tm_elunch'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Volta do Almoço: '. substr($eemp['tm_elunch'], 0, 8) .'"' : ''?>></div>
            <div class='ind ind_snack <?php echo  (isset($eemp['tm_snack'])  && $eemp['tm_snack'] != null) ? 'hit' : ''?>' <?php echo  (isset($eemp['tm_snack']) && $eemp['tm_snack'] != null)  ? 'data-toggle="tooltip" data-placement="top" title="Intervalo: '. substr($eemp['tm_snack'], 0, 8) .'"' : ''?>></div>
            <div class='ind ind_esnack <?php echo (isset($eemp['tm_esnack']) && $eemp['tm_esnack'] != null) ? 'hit' : ''?>' <?php echo (isset($eemp['tm_esnack'])&& $eemp['tm_esnack'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Volta do Intervalo: '. substr($eemp['tm_esnack'], 0, 8) .'"' : ''?>></div>
            <div class='ind ind_exit <?php echo   (isset($eemp['tm_exit'])   && $eemp['tm_exit'] != null) ? 'hit' : ''?>' <?php echo   (isset($eemp['tm_exit'])  && $eemp['tm_exit'] != null)   ? 'data-toggle="tooltip" data-placement="top" title="Saída: '. substr($eemp['tm_exit'], 0, 8) .'"' : ''?>></div>
        </div>
    </div>
    <div class="employees_options dropdown" id='<?php echo 'option'.$eemp['cd_emp']?>'>
        <div aria-hidden="true" data-toggle="dropdown" >
            <span class="glyphicon glyphicon-plus" ></span>
        </div>
        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="">
            <li role="presentation" class="dropdown-header">
                Ações
            </li>
            <li role="presentation" class="divider"></li>
            <li role="presentation" class="">
                <a role="menuitem" tabindex="-1">Marcar Folga</a>
            </li>
            <li role="presentation" class="">
                <a role="menuitem" tabindex="-1">Adicionar Atestado</a>
            </li>
        </ul>
    </div>
<?php 
if(!$_POST){
?>
    </div>
<?php } ?>