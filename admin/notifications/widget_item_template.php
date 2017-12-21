<?php 
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
if($_POST){
    if($_POST['emp']){
    $eemp = $_POST['emp'];
    
    $conn = new Cxoi;
    $dof = strtolower(date('D'));
    $time = date("H:i:s");
    }
}

$widget_class = '';
$widget_status_class = '';
$last_hit = '';
$arrives_status = '';
$arrives= '';
$num_late_warning = 0;
$month_mlate = 0;
$num_late_notification = 0;
$just = [];

if($eemp['tp_just'] == 'late'){
    $data_just = $conn->sqlQuery('SELECT * FROM justifications WHERE cd_emp = '.$eemp['cd_emp'].' AND EXTRACT(YEAR_MONTH from dt_just) =  EXTRACT(YEAR_MONTH from "' . $eemp['dt_time'] . '")');
    while ($row = mysqli_fetch_assoc($data_just)) {
        array_push($just, $row);
        if ($row['tp_just'] == 'late') {
            $month_mlate = $month_mlate + $row['sz_late'];

            if($month_mlate > $GLOBALS['$month_tolerance']){
                $num_late_warning++;
            }else{
                $num_late_notification++;
            }
        }
    }
}


if($eemp['tm_entry'] == null){
    if($eemp['entry_'.$dof] < $time){
        $widget_class = 'miss';
    }
}else{
    if($eemp['entry_'.$dof] >= $eemp['tm_entry']){
        $widget_class = 'ontime nomiss';
        $arrives = 'Chegou no horário';
        $arrives_status = 'ontime';
    }else{
        $widget_class = 'late nomiss';
        $arrives = 'Chegou atrasado';
        $arrives_status = 'late';
    }
}
if($eemp['tm_entry'] != null){
    if(($eemp['tm_lunch'] != null && $eemp['tm_elunch'] == null) || ($eemp['tm_snack'] != null && $eemp['tm_esnack'] == null) || ($eemp['tm_exit'] != null)){
        $widget_status_class = 'onduty';
    }else{
        $widget_status_class = 'offduty';
    }
}
$lastHit = lastHit($eemp);

$last_hit = ($lastHit['time']) ? $lastHit['shortname'].': '.uf($lastHit['time'],8) :  '' ;
if(!$_POST){
    echo "<div id='item_".$eemp['cd_emp']. "' class='widget_item ".$widget_class."' >";
}
?>

<div class='widget_holder'>
    <div class="widget_name"> 
        <?php echo $eemp['nm_emp'] . '<br/>'; ?>
    </div>
    <div class='widget_left'>
        <div class='widget_foto'>
            <img class='img-circle' src='../../<?php echo ($eemp['ds_pic'] != null) ? 'pic/'.$eemp['ds_pic'] : 'img/misspicemp.png'?>' />
        </div>
        <div class='widget_status <?php echo $widget_status_class ?>'></div>
        <div class='button_glyphicon' >
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </div>
        <div class='button_glyphicon' >
            <a href='../reports/singleEmpReport.php'><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a>
        </div>
        <!-- <div class='last_hit'><?php //echo $last_hit ?></div> -->
    </div>
    <div class='widget_right'>
        <div class='indicators'>
            <div class='ind ind_entry <?php echo ($eemp['tm_entry'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_entry'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Entrada: '. uf($eemp['tm_entry'],8) .'"' : ''?>></div>
            <div class='ind ind_lunch <?php echo ($eemp['tm_lunch'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_lunch'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Almoço: '.  uf($eemp['tm_lunch'],8) .'"' : ''?>></div>
            <div class='ind ind_elunch <?php echo ($eemp['tm_elunch'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_elunch'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Volta do Almoço: '.  uf($eemp['tm_elunch'],8) .'"' : ''?>></div>
            <div class='ind ind_snack <?php echo ($eemp['tm_snack'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_snack'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Intervalo: '.  uf($eemp['tm_snack'],8) .'"' : ''?>></div>
            <div class='ind ind_esnack <?php echo ($eemp['tm_esnack'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_esnack'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Volta do Intervalo: '.  uf($eemp['tm_esnack'],8) .'"' : ''?>></div>
            <div class='ind ind_exit <?php echo ($eemp['tm_exit'] != null) ? 'hit' : ''?>' <?php echo ($eemp['tm_exit'] != null) ? 'data-toggle="tooltip" data-placement="top" title="Saída: '.  uf($eemp['tm_exit'],8) .'"' : ''?>></div>
        </div>
        <div class='widget_late <?php echo $arrives_status ?>'>
            <div class='widget_late_status'>
                <?php echo $arrives ?>
            </div>
            <div class='widget_late_time'>
                <?php echo '<span style=\'opacity:0.5\'>' . $eemp['entry_' . $dof] . ' - </span> ' . uf($eemp['tm_entry'],8); ?>
            </div>
        </div>
        <?php if($eemp['tp_just']){?>
        <div class='widget_late_justification'>
            <?php if($eemp['tp_just'] == 'medic' || $eemp['tp_just'] == 'declaration'){ ?>
            <div class="widget_late_justification_ds">
                <?php echo justificationName($eemp['tp_just']) . '<br/>'; ?>
                <?php echo ($eemp['tp_just'] == 'medic') ? $eemp['tm_begin'].' - '.$eemp['tm_end'] : ''?>
            </div>
            <div data-nameemp="<?php echo $eemp['nm_emp'] ?>" data-dsfile="<?php echo $eemp['ds_file'] ?>" class='button_glyphicon glyphicon_justification'>
                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
            </div>
            <?php } elseif($eemp['tp_just'] == 'late') { 
echo justificationName($eemp['tp_just']) . '<br/>';                          
if($month_mlate < $GLOBALS['$month_tolerance'] ){
    $late_to_today = explode('.',($month_mlate/60));
    echo 'Total do mês: ' . $late_to_today[0] . ' min<br/>';
    echo $num_late_notification . 'ª notificação mês';
}else{
    $late_to_today = explode('.',($month_mlate/60));
    echo 'Total do mês: ' . $late_to_today[0] . ' min<br/>';
    echo $num_late_warning . 'ª advertência do mês';
}
} elseif($eemp['tp_just'] == 'latemanager') { 
echo justificationName($eemp['tp_just']) . '<br/>'; 
} elseif($eemp['tp_just'] == 'other') { 
echo justificationName($eemp['tp_just']) . '<br/>'; 
echo $eemp['ds_just'];
}
            ?> 
        </div>
        <?php } ?>
    </div>
</div>
<?php 
if(!$_POST){
    echo '</div>';
}
?>