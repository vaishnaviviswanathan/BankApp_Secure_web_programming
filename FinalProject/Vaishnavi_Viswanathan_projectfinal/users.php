
<?php
include_once('/var/www/html/project/hw6-lib.php');
connect($db);


	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a>  | <a href=add.php?s=92>Logout</a> | <a href=add.php>Back</a></div>	
	      <hr>";

	echo "<table bordercolor=gold align='center' border=1 style='align:center' colspan=10 width=100%><tr align='center'><td align='center'><b>USERID</b></td><td><b>USERNAME</b></td><td><b>EMAILID</b></td><td><b>CHECKING ACCNO</b></td><td><b>SAVING ACCNO</b></td><td><b>ADDRESS</b></td><td><b>PHONE NUMBER</b></td><td><b>CHECKING($)</b></td><td><b>SAVINGS($)</b></td></tr>";
	
	$query="select users.userid,users.username,users.email,profile.SSN,profile.checking,profile.saving,profile.address,profile.mobilenumber,csamount.checkingamount,csamount.savingamount from users inner join profile on users.userid=profile.userid inner join csamount on profile.userid=csamount.userid";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$username,$email,$SSN,$checking,$saving,$address,$mobilenumber,$camount,$samount);
	while(mysqli_stmt_fetch($stmt))
	{
		$userid = $userid;
		$username = $username;
		$email = $email;
		$SSN = $SSN;
		$checking = $checking;
		$saving = $saving;
		$address = $address;
		$mobilenumber = $mobilenumber;
		$camount = $camount;
		$samount = $samount;
		//echo "$userid,$username,$email,$SSN,$checking";
		echo "<tr align='center'><td>$userid</td><td>$username</td><td>$email</td><td>$checking</td><td>$saving</td><td>$address</td><td>$mobilenumber</td><td>$camount</td><td>$samount</td></tr>";
		//echo "$userid";
		
	}//while close
	}//if close
	mysqli_stmt_close($stmt);
	echo "</table></body></html>";

?>