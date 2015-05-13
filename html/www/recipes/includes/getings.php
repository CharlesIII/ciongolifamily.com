<?php
        $user = $_GET['user'];
        $client=$_GET['client'];
        require_once('../../dbvars.php');
     
        $connection = pg_connect("dbname=$dbrecipes user=$dbuser password=$dbpass port=$dbport host=$dbhost"); //connect to database
     
        $uid = $_GET['uid'];
        $mask = $_GET['mask'];
        $dbing = pg_query($connection, "SELECT * from query_owner_ingredients($uid, '$mask')");
	
	
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	echo "<complete>";
	while($row = pg_fetch_array($dbing)) {
		echo "<option>".$row[0]."</option>";
	}
	echo '</complete>';
?>