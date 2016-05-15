
<?php
include_once('/var/www/html/project/hw6-lib.php');
connect($db);

switch($s)
{
	default:
	case 0:
	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a> | <a href=add.php?s=92>Logout</a> | <a href=add.php>Back</a></div>	
	      <hr>";
	echo "<p align=center><b>SEARCH FOR AN ACCOUNT HOLDER</b></p><form action=fraud.php method=post>
		<table align=center><tr><td>Enter account holder's SSN:</td><td><input type=text name='ssntext'/></td></tr>
		<tr><td><input type=hidden name=s value=1><input type=submit name='submit' value='Submit'/></td><td></td></tr>
		</table></form></html>";
	break;
	
	case 1:
	$s = mysqli_real_escape_string($db,$s);	
	$ssntext = htmlspecialchars($ssntext);	
	$ssnt=hash('sha256',$ssntext);

	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a> | <a href=add.php?s=92>Logout</a></div>	
	      <hr>";
	echo "<p align=center>DETAILS OF ACCOUNT HOLDER WITH SSN NUMBER: $ssntext</p>";
		
	$query="select users.userid,users.username,users.email,profile.SSN,profile.checking,profile.saving,profile.address,profile.mobilenumber,csamount.checkingamount,csamount.savingamount from users inner join profile on users.userid=profile.userid inner join csamount on profile.userid=csamount.userid where profile.SSN=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$ssnt);
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
		echo "<html><body><form action=fraud.php method=post><table bordercolor=gold align='center' colspan=4 border=1 style='align:center'>
		<tr><td width=20%>USERNAME:</td><td width=20%>$username</td></tr>
		<tr><td width=20%>EMAILID:</td><td width=20%>$email</td></tr>
		<tr><td width=20%>USERID:</td><td width=20%>$userid</td></tr>
		<tr><td width=20%>CHECKING ACCNO:</td><td width=20%>$checking</td>
		<td width=20%>CHECKING($):</td><td width=20%>$$camount</tr>
		<tr><td width=20%>SAVING ACCNO:</td><td width=20%>$saving</td>
		<td width=20%>SAVINGS($):</td><td width=20%>$$samount</td></tr>
		<tr><td width=20%>ADDRESS:</td><td width=20%>$address</td></tr>
		<tr><td width=20%>PHONE NUMBER:</td><td width=20%>$mobilenumber</td></tr></table>
		<p align=center>
				<input type=hidden name=ssntext value=$ssntext>
				<input type=hidden name=s value=2>
				<input type=submit name='submit' value='Delete Record'/></p>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);
	echo "</form></body></html>";
	break;
		
	case 2:
	$s = mysqli_real_escape_string($db,$s);
	$ssntext = mysqli_real_escape_string($db,$ssntext);
	$ssntext=hash('sha256',$ssntext);

	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a> | <a href=add.php?s=92>Logout</a> | <a href=add.php>Back</a></div>	
	      <hr>";
	$queryone="select userid from profile where SSN=?";
	if($stmtone=mysqli_prepare($db,$queryone))
	{
	mysqli_stmt_bind_param($stmtone,"s",$ssntext);
	mysqli_stmt_execute($stmtone);
	mysqli_stmt_bind_result($stmtone,$userid);
	while(mysqli_stmt_fetch($stmtone))
	{
		$userid = $userid;
	}
	mysqli_stmt_close($stmtone);
	}

	$query="delete from csamount where userid=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$userid);
	mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	

	$query="delete from profile where userid=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$userid);
	mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);

	$query="delete from users where userid=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$userid);
	mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	echo "<p align=center>Deleted the account ! </p></body></html>";
	break;
	}//switch close

?>