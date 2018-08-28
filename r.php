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
//echo $date;
//return;
$sql = "select b.reg_date,substr(a.off_loc_code,1,3),a.brn_code,a.num_body,b.cc,date(a.tr_date_time)
from cars.CART_HIST a JOIN CARS.CART_HIST_01_REGIST b ON a.CART_HIST_REF = b.CART_HIST_REF and b.REG_CAR_CODE =01
where a.tr_date_time BETWEEN '$date 00:00:01' and '$date 23:59:59' and a.veh_type_code in ('12','17');";
$rs = odbc_exec($conn, $sql);
$y= date('Y')+543;
$md = date("md");
$filName = "D:/xampp/htdocs/db2/dataexportR/R".$y.$md.".dat";
$objWrite = fopen($filName, "w");
$r = odbc_num_rows($rs);

echo $r;

//while($objResult = odbc_fetch_array($rs)){ 
//  echo $objResult["cc"];
//    }
while (odbc_fetch_row($rs)) {
   $strText = odbc_result($rs, 1)."|".odbc_result($rs, 2)."|".odbc_result($rs, 3)."|".odbc_result($rs, 4)."|".odbc_result($rs, 5)."|".odbc_result($rs, 6). "\r\n";
    fwrite($objWrite, $strText);
}
fclose($objWrite);
odbc_close($conn);

echo '<br><br><br><br><br>####################';
echo 'Export'.$filName." Success";
} else {
    echo "Connection failed.";
    odbc_close($conn);
}
?>






