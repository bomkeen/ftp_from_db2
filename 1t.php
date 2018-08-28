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
$sql = "select b.reg_date,b.cc
from cars.cart_hist_01_regist b
where  b.REG_DATE = '$date'

and    b.reg_car_code = '01'";
$rsR = odbc_exec($conn, $sql);
$y= date('Y')+543;
$md = date("md");
$filName = "D:/xampp/htdocs/db2/dataexportR/R".$y.$md.".dat";
//echo $filName;
$objWrite = fopen($filName, "w");
//$row = odbc_num_rows($rsR);
//
//while($row = db2_fetch_array($stmt)) {
//   // echo '<tr>';
//    echo $row['cc'] ;
//    // repeat with your other columns
//   // echo '</tr>';
//}
while (odbc_fetch_row($rsR)) {
    $strText1 = odbc_result($rsR, 1) . "|" . odbc_result($rsR, 2)."\r\n";
    fwrite($objWrite, $strText1);
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






