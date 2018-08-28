
<?php
$ftp_server = "ftp.example.com";

        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
        ftp_login($conn_id,"ftpserver_username","ftpserver_password");

        $path = "/SERVER_FOLDER/"; //the path where the file is located

        $file = "file.html"; //the file you are looking for

        $check_file_exist = $path.$file; //combine string for easy use

        $contents_on_server = ftp_nlist($conn_id, $path); //Returns an array of filenames from the specified directory on success or FALSE on error. 

// Test if file is in the ftp_nlist array
        if (in_array($check_file_exist, $contents_on_server)) 
        {
            echo "<br>";
            echo "I found ".$check_file_exist." in directory : ".$path;
        }
        else
        {
            echo "<br>";
            echo $check_file_exist." not found in directory : ".$path;  
        };

        // output $contents_on_server, shows all the files it found, helps for debugging, you can use print_r() as well
        var_dump($contents_on_server);

// remember to always close your ftp connection
        ftp_close($conn_id);
        ?>