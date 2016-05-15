<?php
include_once('/var/www/html/project/hw6-lib.php');
connect($db);
	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a></div>	
		<hr>";
	echo "<table align=center><tr><td width=20%><b>IP_ADDRESS</b></td><td width=20%><b>FAILURE_ATTEMPTS</b></td></tr>";
	
	$query="select ip,count(ip) from login where action='failure'";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$ipaddr,$count);
	while(mysqli_stmt_fetch($stmt))
	{
		echo "<tr><td width=20%>$ipaddr</td><td width=20%>$count</td></tr>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);
	echo "</table></body></html>";
?>