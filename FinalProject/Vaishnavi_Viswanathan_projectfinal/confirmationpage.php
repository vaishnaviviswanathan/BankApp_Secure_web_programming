
<?php
session_start();
include_once('/var/www/html/project/hw6-lib.php');
connect($db);

$_SESSION['c']="";
$_SESSION['s']="";
$_SESSION['ca']="";
$_SESSION['sa']="";

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
	$fromacc=$_SESSION['fromacc'];
	$toacc=$_SESSION['toacc'];
	$senddate=$_SESSION['senddate'];
	$amount=$_SESSION['amount'];
	$description=$_SESSION['description'];
	//echo "$fromacc,$toacc,$senddate,$amount,$description";
	$var = "";
	//$id=$_SESSION['userid'];

	if($stmt=mysqli_prepare($db,"select profile.checking,profile.saving from profile"))
	{
	//echo "hi inside";
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$checking,$saving);
	while(mysqli_stmt_fetch($stmt))
	{
		$c = $checking;
		$s = $saving;	
		if( $toacc!=$c && $toacc!=$s )
		{
			$var = "NO MATCH WAS FOUND FOR RECEIPIENTS ACCOUNT NUMBER - <br> (CHECK THE RECEIVER NAME AND THE ACCOUNT NUMBER - NOT MATCHING)";	
		}//if close
		else
		{
			$var = "valid";	
		}//else close			
		//echo "$c,$s";
	}//while close
	}//if close
		if($var!="valid")
		{
		echo "<p align=center style='margin-top:100px'><font color=red>$var</font> <br> <b>PLEASE RESUBMIT THE FORM BY CLICKING ON THE LINK BELOW<b><br></p>";
		echo "<p align=center style='margin-top:105px'><a href=transfer.php>Form Resubmission</a></p>";
		echo "<p align=center style='margin-top:110px'>Sry for the inconvinience!</p>";
		}
		else
		{
		//echo "Great! Amount Tranferred!";
		echo "<html><body><form action=confirmationpage.php method=post><p style='margin-top:60px' align='center'><b>DETAILS FOR CONFIRMATION</b></p>";
		echo "<table id=bgdesign class='profile' border=0 bordercolor=gold align='center' colspan=2 style='align:center;margin-top:20px'>
		<tr class='border_bottom' style='height:5px'><td></td><td></td></tr>
		<tr style='height:10px'><td width=20%><b>FROM ACCOUNT</td><td width=20%><b></b>$fromacc</td></tr>
		<tr><td width=20%><b>TO ACCOUNT</td><td width=20%><b></b>$toacc</td></tr>
		<tr><td width=20%><b>SENDDATE</td><td width=20%><b></b>$senddate</td></tr>
		<tr><td width=20%><b>DESCRIPTION</td><td width=20%><b></b>$description</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td></tr>
		<tr><td width=20%><b>AMOUNT</td><td width=20%><b>$$amount</b></td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td></tr>
		</table>
		<p align='center'><font color=red>*</font>Once submitted cannot be withdrawn</p>";
		echo "<p align='center'><input type=hidden value=1 name=s><a href=transfer.php>BACK</a><input type='submit' value='CONFIRM' name='login'></p>
		</form>
		</body></html>";
		}//else close
	mysqli_stmt_close($stmt);
	break;

	case 1:
	$toacc = $_SESSION['toacc'];

	$fromacc=$_SESSION['fromacc'];
	$senddate=$_SESSION['senddate'];
	$amount=$_SESSION['amount'];
	$description=$_SESSION['description'];
	$userid=$_SESSION['userid'];
	
	$s = mysqli_real_escape_string($db,$s);		
	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=accountstab.php>Accounts</a> | <a href=transfer.php>Transfers</a> | <a href=statements.php>Statements</a> | <a href=add.php?s=92>Logout</a> </div>	
	      <hr>";
	
	echo "<p align=center style='margin-top:100px'><font color=white><b>Success! Amount Tranferred to account number <font color=orange>$toacc</font> !<b></font><br></p>";

	if($stmt=mysqli_prepare($db,"insert into statements set userid=?,fromacc=?,toacc=?,amount=?,description=?,senddate=?"))
	{
		mysqli_stmt_bind_param($stmt,"ssssss",$userid,$fromacc,$toacc,$amount,$description,$senddate);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
	}//if close		
		
		$checking=$_SESSION['checking'];
		$saving=$_SESSION['saving'];
		$camount=$_SESSION['camount'];
		$samount=$_SESSION['samount'];		
		$userid=$_SESSION['userid'];	
		$rname=$_SESSION['rname'];

		//echo "checking--> $checking<br> savings--> $saving<br>checking amount -->$camount<br>savings account-->$samount<br> toacc-> $toacc<br> fromacc --> $fromacc <br> user-->$userid <br> rname-->$rname";

	$query="select users.userid,users.username,users.email,profile.SSN,profile.checking,profile.saving,profile.address,profile.mobilenumber,csamount.checkingamount,csamount.savingamount from users inner join profile on users.userid=profile.userid inner join csamount on profile.userid=csamount.userid where profile.userid=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$userid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$username,$email,$SSN,$checking,$saving,$address,$mobilenumber,$camount,$samount);
	
		echo "<html><body>";
		echo "<table id=bgdesign class='profile' border=0 bordercolor=gold align='center'>";
		echo "<tr><td>USERID</td><td>USERNAME</td><td>CHECKING</td><td>SAVING</td><td>CAMOUNT</td><td>SAMOUNT</td></tr>";
	while(mysqli_stmt_fetch($stmt))
	{
		$userid = $userid;
		$username = $username;
		$checking = $checking;
		$saving = $saving;
		$camount = $camount;
		$samount = $samount;

		if($fromacc == $saving)
		{
			$samount=$samount-$amount;
			$_SESSION['s']=$samount;
		}//if close
		else if($fromacc == $checking)
		{
			$camount=$camount-$amount;
			$_SESSION['c']=$camount;
		}//else if close		

		echo "<tr><td>$userid</td><td>$username</td><td>$checking</td><td>$saving</td><td>$camount</td><td>$samount</td></tr>
		</table>
		</body></html>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);

//updating the table
	if($_SESSION['c']!="")
	{
	if($stmtone=mysqli_prepare($db,"update csamount set checkingamount=$camount where userid=?"))
	{
		mysqli_stmt_bind_param($stmtone,"s",$userid);
		mysqli_stmt_execute($stmtone);
		mysqli_stmt_close($stmtone);	
	}//if close		
	}
	//updating the table
	else if($_SESSION['s']!="")
	{
	if($stmttwo=mysqli_prepare($db,"update csamount set savingamount=$samount where userid=?"))
	{
		mysqli_stmt_bind_param($stmttwo,"s",$userid);
		mysqli_stmt_execute($stmttwo);
		mysqli_stmt_close($stmttwo);	
	}//if close		
	}	

//username to account transfer

	$query="select users.userid,users.username,users.email,profile.SSN,profile.checking,profile.saving,profile.address,profile.mobilenumber,csamount.checkingamount,csamount.savingamount from users inner join profile on users.userid=profile.userid inner join csamount on profile.userid=csamount.userid where users.username=?";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$rname);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$username,$email,$SSN,$checking,$saving,$address,$mobilenumber,$camount,$samount);
	
		echo "<html><body>";
		echo "<table id=bgdesign class='profile' border=0 bordercolor=gold align='center'>";
		echo "<tr><td>USERID</td><td>USERNAME</td><td>CHECKING</td><td>SAVING</td><td>CAMOUNT</td><td>SAMOUNT</td></tr>";
	while(mysqli_stmt_fetch($stmt))
	{
		$userid = $userid;
		$username = $username;
		$checking = $checking;
		$saving = $saving;
		$camount = $camount;
		$samount = $samount;

		if($toacc == $saving)
		{
			$samount=$samount+$amount;
			$_SESSION['sa']=$samount;
		}//if close
		else if($toacc == $checking)
		{
			$camount=$camount+$amount;
			$_SESSION['ca']=$camount;
		}//else if close		

		echo "<tr><td>$userid</td><td>$username</td><td>$checking</td><td>$saving</td><td>$camount</td><td>$samount</td></tr>
		</table>
		</body></html>";
	}//while close
	}//if close
	mysqli_stmt_close($stmt);

//updating the table
	if($_SESSION['ca']!="")
	{
	if($stmtone=mysqli_prepare($db,"update csamount set checkingamount=$camount where userid=?"))
	{
		mysqli_stmt_bind_param($stmtone,"s",$userid);
		mysqli_stmt_execute($stmtone);
		mysqli_stmt_close($stmtone);	
	}//if close		
	}
	//updating the table
	else if($_SESSION['sa']!="")
	{
	if($stmttwo=mysqli_prepare($db,"update csamount set savingamount=$samount where userid=?"))
	{
		mysqli_stmt_bind_param($stmttwo,"s",$userid);
		mysqli_stmt_execute($stmttwo);
		mysqli_stmt_close($stmttwo);	
	}//if close		
	}	

	//echo "<script>setTimeout(\"location.href = 'accountstab.php';\",2800);</script>";
	break;
}//switch close

?>