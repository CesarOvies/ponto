<?php

class eMonth{
    var $month;
    var $year;
    var $day = array();
    var $daysInMonth;
    var $lateInMonth = 0;
    var $nAdv = 0;
    var $nNoti = 0;
    var $teste;
    
    public function __construct($month, $year, $data, $cd_emp){
        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $this->day = $data;
        $this->month = $month;
        $this->year = $year;
        $this->cd = $cd_emp;
    }
    
    function exibe(){
        var_dump($this);
    }
    
    function cast_line($day){       
        $dayOfWeek = nameDayWeek($this->month, $day , $this->year);
        $name_times = ['tm_entry','tm_lunch','tm_elunch','tm_snack','tm_esnack','tm_exit'];
        $greyRow = ($day % 2 == 0)? 'greyRow' : '';
        
        echo "<div id='line$day' class='form-group editTimeRow ".$greyRow." ' >";
        echo "<div class='col-sm-1 labelTimeEdit'>". $dayOfWeek.' - '.$day ."</div>";        
        for($i=0;$i <= 5;$i++){
            echo "<div class='col-sm-1'>";
           
            
            
            
            
            
            if(isset($this->day[$day][$name_times[$i]])){
                echo "<div class='editTimeNoInput' ><div name='input[".$day."][".$name_times[$i]."]'>".uf($this->day[$day][$name_times[$i]], 5)."</div></div>";
                echo "<input type='hidden' value='".uf($this->day[$day][$name_times[$i]], 5)."' name='before[".$day."][".$name_times[$i]."]' />";
            }else{
                if($i == 3 || $i == 4){
                    echo "<div class='editTimeNoInput' name='input[".$day."][".$name_times[$i]."]'><div name='input[".$day."][".$name_times[$i]."]'></div></div>";
                    echo "<input type='hidden' value='' name='before[".$day."][".$name_times[$i]."]' />";
                }else{
                    echo "<input class='uf5 editTimeNew' type='text' value='' name='input[".$day."][".$name_times[$i]."]' />";
                    echo "<input type='hidden' value='' name='before[".$day."][".$name_times[$i]."]' />";
                } 
            }
            
            
            
            
            
            
            
            echo "</div>";
        }   
        if(isset($this->day[$day]['tp_just'])){
            echo "<div class='col-sm-1 edit_just'><span class='glyphicon glyphicon-remove' aria-hidden='true' data-cd='".$this->cd."' data-date='".$this->year."-".$this->month."-".$day."'></span><span class='glyphicon glyphicon-pencil' data-cd='".$this->cd."' data-date='".$this->year."-".$this->month."-".$day."' aria-hidden='true'></span></div>"; 
        }else{
            echo "<div class='col-sm-1 edit_just'><span class='glyphicon glyphicon-plus' data-cd='".$this->cd."' data-date='".$this->year."-".$this->month."-".$day."' aria-hidden='true'></span></div>";
        }
        echo "<div class='col-sm-4'><div class='editTimeJust'>";
        $this->cast_justification($day);
        echo "</div></div>";
         
        echo "</div>";
        echo ($dayOfWeek  == 'Dom')? "<div class= 'sundayRow'> </div>" : '';
    }
    
    function cast_justification($day){
        if(isset($this->day[$day]['tp_just'])){
            if($this->day[$day]['tp_just'] == 'medic'){
                echo "<div class='just_label just_medic'>Atestado médico</div> ".$this->day[$day]['tm_begin'].' - '.$this->day[$day]['tm_end']. '<span class="glyphicon glyphicon-file glyphicon_justification" data-dsfile="'.$this->day[$day]['ds_file'].'" data-nameemp="' . $day .'/'. $this->month .'/'. $this->year. '" aria-hidden="true"></span>';
            }elseif($this->day[$day]['tp_just'] == 'late'){
                if($this->day[$day]['tm_entry'] <= $this->day[$day]['tm_turn_entry']){
                    echo "<div class='just_label just_noti'>CHECAR HORÁRIO</div>";
                }else{
                    $this->lateInMonth = $this->lateInMonth + hourToSec(subTime($this->day[$day]['tm_entry'],$this->day[$day]['tm_turn_entry']));

                    if($this->lateInMonth > $GLOBALS['$month_tolerance']){
                        $this->nAdv++;
                        echo "<div class='just_label just_adv'>". $this->nAdv ."ª Advertência</div>".subTime($this->day[$day]['tm_entry'],$this->day[$day]['tm_turn_entry']);

                    }else{
                        $this->nNoti++;
                        echo "<div class='just_label just_noti'>". $this->nNoti ."ª Notificação</div>".subTime($this->day[$day]['tm_entry'],$this->day[$day]['tm_turn_entry']);
                    }
                }
            }elseif($this->day[$day]['tp_just'] == 'declaration'){
                echo "<div class='just_label just_decl'>Declaração</div><span class='glyphicon glyphicon-file glyphicon_justification' data-dsfile='".$this->day[$day]['ds_file']."' data-nameemp='" . $day ."/". $this->month ."/". $this->year. "' aria-hidden='true'></span>";
            }elseif($this->day[$day]['tp_just'] == 'latemanager'){
                echo "<div class='just_label just_latemanater'>Gerente Atrasado</div>";
            }elseif($this->day[$day]['tp_just'] == 'other'){
                echo "<div class='just_label just_other'>Outros</div> ".$this->day[$day]['ds_just'];
            }else{
                echo $this->day[$day]['tp_just'];
            }
        }
    }
}


?>