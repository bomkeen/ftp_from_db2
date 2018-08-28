<?php

$ftpconn = ftp_connect("27.254.54.183",2021) or die("Could not connect");
ftp_login($ftpconn, "tmea_project", "tmea@2018");
ftp_pasv($ftpconn, true);
$y = date('Y') + 543;
$md = date("md");

$localfileC = "dataexportC/C" . $y . $md . ".dat";
$localfileR = "dataexportR/R" . $y . $md . ".dat";
$destinationC = "C".$y.$md.".dat";
$destinationR = "R".$y.$md.".dat";

/////read file on server 
$file_on_server = ftp_nlist($ftpconn,".");
////////////

/////check file C 
if (in_array($destinationC, $file_on_server)) 
        {
            ftp_delete($ftpconn, $destinationC);
            echo "<br>";
            echo "I found ".$destinationC." in directory : and i delete Them ";
            echo "<br>";
            echo "<br>";
            ftp_put($ftpconn, $destinationC, $localfileC, FTP_BINARY);
            echo "FTP ".$destinationC." To Server Success "; 
            echo "<br>";
            echo '####################';
            echo "<br>";
        }
        else
        {
           ftp_put($ftpconn, $destinationC, $localfileC, FTP_BINARY);
            echo "FTP ".$destinationC." To Server Success ";  
        };

        ///////////// check R
        if (in_array($destinationR, $file_on_server)) 
        {
            ftp_delete($ftpconn, $destinationR);
            echo "<br>";
            echo "I found ".$destinationR." in directory : and i delete Them ";
            echo "<br>";
            echo "<br>";
            ftp_put($ftpconn, $destinationR, $localfileR, FTP_BINARY);
            echo "FTP ".$destinationR." To Server Success "; 
            echo "<br>";
            echo '####################';
            echo "<br>";
        }
        else
        {
           ftp_put($ftpconn, $destinationR, $localfileR, FTP_BINARY);
            echo "FTP ".$destinationR." To Server Success ";  
        };
ftp_close($ftpconn);
?>