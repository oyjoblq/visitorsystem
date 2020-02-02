<?php

	//Database Information. Replace them with your own database information
    $dbhost1 = "Yourhost";
	$dbname1 = "Yourdatabase"; 
	$dbuser1 = "Youruser"; 
	$dbpass1 = "Yourpassword"; 	
	
	$conn = mysqli_init();
	
	if (!$conn) {
 		 die("mysqli_init failed");
	}
	
	mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
		
	if (!mysqli_real_connect($conn, $dbhost1, $dbuser1, $dbpass1, $dbname1)){
      die("Connect Error: " . mysqli_connect_error());
   	}
	
 ?>   
