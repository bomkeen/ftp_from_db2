<?php

$database = "MATULEE2";        # Get these database details from
$hostname = "10.252.5.21";  # the web console
$user = "apptmea";   #
$password = "apptmea";   #
$port = 50000;          #
//$ssl_port = 50001;          #
# Build the connection string
#
$driver = "DRIVER={IBM DB2 ODBC DRIVER};";
$dsn = "DATABASE=$database; " .
        "HOSTNAME=$hostname;" .
        "PORT=$port; " .
        "PROTOCOL=TCPIP; " .
        "UID=$user;" .
        "PWD=$password;";
$conn_string = $driver . $dsn;

$conn = odbc_connect($conn_string, "", "");
if ($conn) {
    echo "Connection succeeded.";
$date= date('Y-m-d');
$sql = "select ctl_date,substr(ctl_off_loc_code,1,3),body_brn_code,num_body,cc
from cars.mact_car
where ctl_flag in ('T','R')
and   ctl_date between '$date' and '$date' 
and   plt_type = '1'
and   grp_type = '2'";
$rs = odbc_exec($conn, $sql);
$y= date('Y')+543;
$md = date("md");
$filName = "D:/xampp/htdocs/db2/dataexportC/C".$y.$md.".dat";
//echo $filName;
$objWrite = fopen($filName, "w");
$r = odbc_num_rows($rs);


while (odbc_fetch_row($rs)) {
    $strText1 = odbc_result($rs, 1) . "|" . odbc_result($rs, 2) . "|" . odbc_result($rs, 3) . "|" . odbc_result($rs, 4) . "|" . odbc_result($rs, 5). "\r\n";
    fwrite($objWrite, $strText1);
}
fclose($objWrite);
odbc_close($conn);
echo '<br><br><br><br><br>####################';
echo 'Export'.$filName." Success Total ".$r."  Record" ;
} else {
    echo "Connection failed.";
    odbc_close($conn);
}
?>


<?php

?>

