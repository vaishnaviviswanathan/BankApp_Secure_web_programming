
<?php
session_start();
include_once('/var/www/html/project/hw6-lib.php');
connect($db);

echo "<style type='text/css'>
	
	tr.border_bottom td 
	{
 	border-bottom:1pt solid gold;
	}

	table.profile 
	{
	margin-top : 20px;
    	border-radius: 25px;
    	border: 2px solid gold;
    	padding: 20px; 
    	width: 800px;
    	height: 100px;    
	}
	</style>";

switch($s)
{
	default:
	case 0:
	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=accountstab.php>Accounts</a> | <a href=transfer.php>Transfers</a> | <a href=statements.php>Statements</a> | <a href=add.php?s=92>Logout</a> </div>	
	      <hr>";
	$id=$_SESSION['userid'];
	//$id = 88;
	$query="select userid,fromacc,toacc,amount,description,senddate from statements where userid=?";
	
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$fromacc,$toacc,$amount,$description,$senddate);
	while(mysqli_stmt_fetch($stmt))
	{
		$userid = $userid;
		$fromacc = $fromacc;
		$toacc = $toacc;
		$amount = $amount;
		$description = $description;
		$senddate = $senddate;
		echo "<html><body><p style='margin-top:60px' align='center'><b></p>";
		echo "<table border=0 bordercolor=gold align='center' colspan=3 style='align:center;margin-top:20px'>
		<tr style='height:10px'><td width=20%><b>TO ACCOUNT</td><td style='padding-left:60px'>$toacc</td><td width=20%><b></b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr style='height:10px'><td width=20%><b>AMOUNT</td><td style='padding-left:60px'>$$amount</td><td width=20%><b></b></td></tr>
		<tr><td width=20%><b>SENDDATE</td><td style='padding-left:60px'>$senddate</td><td width=20%><b></b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr><td width=20%><b>DESCRIPTION</td><td style='padding-left:60px'></td><td width=20%><b>$description</b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		</table>
		</body></html>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);
	break;
}//switch close

?>