<?php
ini_set('max_execution_time', 0);
$PDO = new PDO( 'mysql:host=localhost;dbname=ponto', 'root', 'x1ck052k0',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$t = explode(" ",microtime());

while ( true )
{
	$now =  date("H:i:s",$t[1]).substr((string)$t[0],1,4);
    $requestedTime = isset( $_GET['time'] ) ? $_GET['time'] : $now;
	$requestedDate = isset( $_GET['date'] ) ? $_GET['date'] : '2015-04-02';
	$requestedStore = isset( $_GET['store'] ) ? $_GET['store'] : '5';
 
    $stmt = $PDO->prepare( "
    SELECT * FROM times t 
    JOIN employees e 
    ON t.cd_emp = e.cd_emp 
    JOIN stores s 
    ON s.cd_store = e.cd_store AND e.cd_store = $requestedStore
    WHERE t.dt_time = :requestedDate AND (
    t.tm_entry > :requestedTime OR 
    t.tm_lunch > :requestedTime OR 
    t.tm_elunch > :requestedTime OR 
    t.tm_snack > :requestedTime  OR
    t.tm_esnack > :requestedTime OR
    t.tm_exit > :requestedTime
    )" );

    $stmt->bindParam( ':requestedTime', $requestedTime );
	$stmt->bindParam( ':requestedDate', $requestedDate );
    $stmt->execute();
 	
    $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

	

    if ( count( $rows ) > 0 )
    {
       $rows['now'] = $now;
	   
       $json = json_encode( $rows );
 
        echo $json;
        break;
    }
    else
    {

        sleep( 2 );
        continue;
    }
}

?>