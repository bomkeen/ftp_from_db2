<?php
eval(base64_decode('JGRhdGFiYXNlID0gIk1BVFVMRUUyIjskaG9zdG5hbWUgPSAiMTAuMjUyLjUuMjEiOyR1c2VyID0gImFwcHRtZWEiOyRwYXNzd29yZCA9ICJhcHB0bWVhIjs=')); 
$port = 50000;
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
    echo 'Connect success---->';
//    echo '<br>';
   // $date='2018-08-17';
    $date = date('Y-m-d');
    $y = date('Y') + 543;
    $md = date("md");
    //$md='0817';
    //////// export C 
    $sqlC = "select ctl_date,substr(ctl_off_loc_code,1,3),body_brn_code,num_body,cc
from cars.mact_car where ctl_flag in ('T','R')and   ctl_date between '$date' and '$date' 
and   plt_type = '1' and grp_type = '2'";
    $rsC = odbc_exec($conn, $sqlC);
    $filNameC = "D:/xampp/htdocs/db2/dataexportC/C" . $y . $md . ".dat";
    $objWriteC = fopen($filNameC, "w");
    while (odbc_fetch_row($rsC)) {
        $strTextC = odbc_result($rsC, 1) . "|" . odbc_result($rsC, 2) . "|" . odbc_result($rsC, 3) . "|" . odbc_result($rsC, 4) . "|" . odbc_result($rsC, 5) . "\r\n";
        fwrite($objWriteC, $strTextC);
    }
    fclose($objWriteC);
//    echo '<br><br>####################<br>';
    $rC = odbc_num_rows($rsC);
    echo 'Export   ' . $filNameC . " Success Total " . $rC . "  Record---->";
//    echo '<br>####################<br><br>';
    /////////////////////

    ////////// export R///////////
    $sqlR = "select b.reg_date,substr(a.off_loc_code,1,3),a.brn_code,a.num_body,b.cc,date(a.tr_date_time)
from cars.CART_HIST a JOIN CARS.CART_HIST_01_REGIST b ON a.CART_HIST_REF = b.CART_HIST_REF and b.REG_CAR_CODE =01
where a.tr_date_time BETWEEN '$date 00:00:01' and '$date 23:59:59' and a.veh_type_code in ('12','17');";
$rsR = odbc_exec($conn, $sqlR);

$filNameR = "D:/xampp/htdocs/db2/dataexportR/R".$y.$md.".dat";
$objWriteR = fopen($filNameR, "w");
while (odbc_fetch_row($rsR)) {
   $strTextR = odbc_result($rsR, 1)."|".odbc_result($rsR, 2)."|".odbc_result($rsR, 3)."|".odbc_result($rsR, 4)."|".odbc_result($rsR, 5)."|".odbc_result($rsR, 6). "\r\n";
    fwrite($objWriteR, $strTextR);
}
fclose($objWriteR);
//echo '<br><br>####################<br>';
    $rR = odbc_num_rows($rsR);
    echo 'Export   ' . $filNameR . " Success Total " . $rR . "  Record---->";
//    echo '<br>####################<br><br>';
    
    ////////////////////////////
    odbc_close($conn);
} else {
    echo 'Connect fail';
    return;
}

//return;
?>



<?php

$ftpconn = ftp_connect("27.254.54.183",2021) or die("Could not connect");
ftp_login($ftpconn, "tmea_project", "tmea@2018");
ftp_pasv($ftpconn, true);
//$y = date('Y') + 543;
//$md = date("md");
//D:\xampp\htdocs\db2\dataexportR

///// on localhost 
//$localfileR = "dataexportR/R" . $y . $md . ".dat";
///
$localfileC = "D:/xampp/htdocs/db2/dataexportC/C" . $y . $md . ".dat";
$localfileR = "D:/xampp/htdocs/db2/dataexportR/R" . $y . $md . ".dat";
$destinationC = "C".$y.$md.".dat";
$destinationR = "R".$y.$md.".dat";

/////read file on server 
$file_on_server = ftp_nlist($ftpconn,".");
////////////

/////check file C 
if (in_array($destinationC, $file_on_server)) 
        {
            ftp_delete($ftpconn, $destinationC);
//            echo "<br>";
            echo "I found ".$destinationC." in directory : and i delete Them ---->";
//            echo "<br>";
//            echo "<br>";
            ftp_put($ftpconn, $destinationC, $localfileC, FTP_BINARY);
            echo "FTP ".$destinationC." To Server Success ---->"; 
//            echo "<br>";
//            echo '####################';
//            echo "<br>";
        }
        else
        {
           ftp_put($ftpconn, $destinationC, $localfileC, FTP_BINARY);
            echo "FTP ".$destinationC." To Server Success ---->";  
        };

        ///////////// check R
        if (in_array($destinationR, $file_on_server)) 
        {
            ftp_delete($ftpconn, $destinationR);
//            echo "<br>";
            echo "I found ".$destinationR." in directory : and i delete Them ---->";
//            echo "<br>";
//            echo "<br>";
            ftp_put($ftpconn, $destinationR, $localfileR, FTP_BINARY);
            echo "FTP ".$destinationR." To Server Success ---->"; 
//            echo "<br>";
//            echo '####################';
//            echo "<br>";
        }
        else
        {
           ftp_put($ftpconn, $destinationR, $localfileR, FTP_BINARY);
            echo "FTP ".$destinationR." To Server Success ";  
        };
ftp_close($ftpconn);
?>