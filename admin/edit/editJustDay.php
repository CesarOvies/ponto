<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $r = (isset($_POST['data'])) ? $_POST['data'] : '';
    $num_msg = '';
    $msg = '';
    

    if(!empty($r['reason']) && $r['reason'] == 'late'){
        $late_to_today = explode('.',(($r['month_mlate']+$r['mlate'])/60));
        if($r['month_mlate']+$r['mlate'] > $GLOBALS['$month_tolerance'] ){
            $msg = 'Contanto com hoje você já soma '.$late_to_today[0].' minutos de atraso este mês. Será gerada uma <b>advertência</b> pelo atraso de hoje.';
            $num_msg = '<b>'.($r['num_late_warning']+1).'ª</b> advertencia do mês.' ;			
        }else{
            $msg = 'Seus atrasos neste mês somam apenas '.$late_to_today[0].' minutos. Será gerada apenas uma <b>notificação</b>.';
        }
    }
?>


<div class="form-group">
    <div class="col-sm-10 col-sm-offset-1 msg"><?php echo $msg ?></div>
</div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-7"><?php echo $num_msg ?></div>
</div>
<?php        
}

?>