<?php

$database = "MATULEE2";        # Get these database details from
$hostname = "10.252.5.21";  # the web console
$user     = "apptmea";   #
$password = "apptmea";   #
$port     = 50000;          #
//$ssl_port = 50001;          #

# Build the connection string
#
$driver  = "DRIVER={IBM DB2 ODBC DRIVER};";
$dsn     = "DATABASE=$database; " .
           "HOSTNAME=$hostname;" .
           "PORT=$port; " .
           "PROTOCOL=TCPIP; " .
           "UID=$user;" .
           "PWD=$password;";
$conn_string = $driver . $dsn;    

$conn = odbc_connect( $conn_string, "", "" );
if( $conn )
{
    echo "Connection succeeded.";

    # Disconnect
    #
//    odbc_close( $conn );
}
else
{
    echo "Connection failed.";
}
?>


<?php 
$sql = "select   b.reg_date,substr(a.off_loc_code,1,3),a.brn_code,a.num_body,b.cc,date(a.tr_date_time)
from    cars.cart_hist a
INNER JOIN cars.cart_hist_01_regist b ON a.cart_hist_ref=b.cart_hist_ref
where  date(a.tr_date_time) between '2018-06-15' and '2018-06-15' 
and    a.veh_type_code    in ('12','17')
and    b.reg_car_code = '01';";
//$resultset=odbc_exec($conn,$sql);
$rs=odbc_exec($conn,$sql);
 while(odbc_fetch_row($rs))
{
    //display the data
//    echo odbc_result($rs, "NUM_BODY");
    echo odbc_result($rs, 1).' | '.odbc_result($rs, 2).' | '.odbc_result($rs, 3).' | '.odbc_result($rs, 4);
    
    echo '<br>';
}

//$res = odbc_prepare($conn, $sql);
//foreach ($rs as $s ) {
//    echo $s['0'];
//    
//}
odbc_close( $conn );
?>
