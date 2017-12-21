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
}