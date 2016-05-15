
<?php
session_start();
include_once('/var/www/html/project/hw6-lib.php');
connect($db);

echo "<style type='text/css'>
	body 
	{
    	background: url('https://www.sbicard.com/sbi-card-en/assets/media/images/personal/credit-cards/value-savings/card-flip/sbi-gold-card.png');
    	background-size: 1000px 500px;
    	background-repeat: no-repeat;
    	background-position: center; 	
	}
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
#bgdesign 
	{
    	border-radius: 25px;
    	background: #73AD21;
   	padding: 20px; 
	background-size: 1000px 500px;
    	background-repeat: no-repeat;
    	background-position: center; 	    
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
	$query="select users.userid,users.username,users.email,profile.SSN,profile.checking,profile.saving,profile.address,profile.mobilenumber,csamount.checkingamount,csamount.savingamount from users inner join profile on users.userid=profile.userid inner join csamount on profile.userid=csamount.userid where profile.userid=?";


	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$id);
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
		$total = $samount+$camount;
		$_SESSION['checking']=$checking;
		$_SESSION['saving']=$saving;
		$_SESSION['camount']=$camount;
		$_SESSION['samount']=$samount;
		echo "<html><body><p style='margin-top:60px' align='center'><b>ACCOUNT SUMMARY</b></p>";
		echo "<table id=bgdesign class='profile' border=0 bordercolor=gold align='center' colspan=3 style='align:center;margin-top:20px'>
		<tr><td width=20%><b>CASH ACCOUNTS</b></td><td padding-left:60px></td><td width=20%><b>BALANCE</b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr style='height:10px'><td width=20%><b>CHECKING</td><td style='padding-left:60px'>$checking</td><td width=20%><b>$</b>$camount</td></tr>
		<tr><td width=20%><b>MAIN SAVINGS</td><td style='padding-left:60px'>$saving</td><td width=20%><b>$</b>$samount</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr><td width=20%><b>TOTAL</td><td style='padding-left:60px'></td><td width=20%><b>$$total</b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		</table>
		<p align='center'><b>PERSONAL INFORMATION</b></p>
		<table id=bgdesign align='center' class='profile' colspan='3'>
		<tr><td width=20%><b>USERNAME</b></td><td padding-right:40px>$username</td><td></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr><td width=20%><b>EMAILID</b></td><td padding-right:40px>$email</td><td width=20%></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr><td width=20%><b>ADDRESS</b></td><td padding-right:40px>$address</td><td width=20%></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td></tr>
		<tr><td width=20%><b>PHONE NUMBER</b></td><td padding-right:40px>$mobilenumber</td><td width=20%></td></tr>
		</table>
		</body></html>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);
	break;
}//switch close
?>