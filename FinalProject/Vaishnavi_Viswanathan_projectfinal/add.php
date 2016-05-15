<?php
session_start();
session_regenerate_id();
include_once('/var/www/html/project/hw6-lib.php');
connect($db);
$postUser=$_POST['username'];
$postPass=$_POST['pswdtext'];

if(!isset($_SESSION['authenticated']))
{
authenticate($db,$postUser,$postPass);
 	if($_SESSION['userid']!=1)
	{
		session_write_close();
		header("Location: accountstab.php");
		exit();
	}//if close
}

icheck($s);
icheck($sid);
icheck($cid);
icheck($bid);


echo "<style type='text/css'>
	body 
	{
    	background: url('https://www.sbicard.com/sbi-card-en/assets/media/images/personal/credit-cards/value-savings/card-flip/sbi-gold-card.png');
    	background-size: 1000px 500px;
    	background-repeat: no-repeat;
    	background-position: center; 	
	}
	</style>";


switch($s)
{
	default:
	case 4:
	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a></div>	
	      <hr>
	      <p style='text-align:center'><b>About Our Bank</b></p>
	
	<p style='text-align:center;margin-left:200px;margin-right:200px'>
	 Wells Fargo & Company is an American multinational banking and financial services holding company headquartered 
	 in San Francisco, California, with hubquarters throughout the country. It is the third largest bank in the U.S. by
	 assets and the largest bank by market capitalization.Wells Fargo surpassed Citigroup Inc. to become the third-largest U.S.
	 bank by assets at the end of 2015. Wells Fargo is the second largest bank in deposits, home mortgage servicing, and debit cards.
	 Wells Fargo ranked 10th among the Forbes Global 2000 (2015) and the 30th largest company in the United States, according 
	 to Fortune 500 (2015).</p>
	<p style='text-align:center;margin-left:200px;margin-right:200px'>
	 In 2007 it was the only bank in the United States to be rated AAA by S and P, though its rating has since been lowered to AA 
	 in light of the financial crisis of 2007 to 2008. The firm's primary U.S. operating subsidiary is national bank Wells Fargo Bank, N.A., 
	 which designates its main office as Sioux Falls, South Dakota.
	</p>
	<p style='text-align:center;margin-left:200px;margin-right:200px'>
	 Wells Fargo in its present form is a result of a merger between San Francisco based Wells Fargo and Company and Minneapolis-based
	 Norwest Corporation in 1998 and the subsequent 2008 acquisition of Charlotte-based Wachovia. Following the mergers, the company transferred
	 its headquarters to Wells Fargo's headquarters in San Francisco and merged its operating subsidiary with Wells Fargo's operating subsidiary 
	 in Sioux Falls.
	 </p>
	 
	<p style='text-align:center'><a href=add.php?s=90>Add New Users</a> | <a href=add.php?s=93>Check Users</a> | <a href=add.php?s=94>Check loginattempts</a> | <a href=fraud.php>Fraud Handling</a> | <a href=add.php?s=92>Logout</a></p>
	<br></body</html>";
	break;

	case 90:
	if($_SESSION['userid']==1)
	{
	addUser();
	}
	else
	{
		echo "error! Not authenticated to add new users";
		echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
		session_destroy();
	}//else close
	break;

	case 91:
	$s = mysqli_real_escape_string($db,$s);		
	
	$user = htmlspecialchars($user);
	$pswdtext = htmlspecialchars($pswdtext);
	$emailid = htmlspecialchars($emailid);
	
	$salt = hash('sha256',$user);
	$pswd = hash('sha256',$pswdtext.$salt);
	

	$address = htmlspecialchars($address);
	$mobilenumber = htmlspecialchars($mobilenumber);
	$ssnnumber = htmlspecialchars($ssnnumber);

	$ssnnumber=hash('sha256',$ssnnumber);

	$checking = htmlspecialchars($checking);
	$saving = htmlspecialchars($saving);

	$camount = htmlspecialchars($camount);
	$samount = htmlspecialchars($samount);

	if($stmt=mysqli_prepare($db,"insert into users set userid='',username=?,password=?,salt=?,email=?"))
	{
		mysqli_stmt_bind_param($stmt,"ssss",$user,$pswd,$salt,$emailid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
	}//if close		

	if($stmttwo=mysqli_prepare($db,"select userid from users where username=?"))
	{
		mysqli_stmt_bind_param($stmttwo,"s",$user);
		mysqli_stmt_execute($stmttwo);
		mysqli_stmt_bind_result($stmttwo,$userid);
		while(mysqli_stmt_fetch($stmttwo))
		{
		$userid = $userid;
		}
		mysqli_stmt_close($stmttwo);	
	}//if close	

	if($stmtone=mysqli_prepare($db,"insert into profile set SSN=?,userid=?,checking=?,saving=?,address=?,mobilenumber=?"))
	{
		mysqli_stmt_bind_param($stmtone,"ssssss",$ssnnumber,$userid,$checking,$saving,$address,$mobilenumber);
		mysqli_stmt_execute($stmtone);
		mysqli_stmt_close($stmtone);	
	}//if close	

	if($stmtthree=mysqli_prepare($db,"insert into csamount set userid=?,checkingamount=?,savingamount=?"))
	{
		mysqli_stmt_bind_param($stmtthree,"sss",$userid,$camount,$samount);
		mysqli_stmt_execute($stmtthree);
		mysqli_stmt_close($stmtthree);	
	}//if close		

	echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      <body><div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Secure Login</a></div>	
	      <hr>
	      <p style='text-align:center'>Added the user $user into the database</p>
	      <br>
	      <p style='text-align:center'><a href=add.php?s=93>Check Users</a> | <a href=add.php?s=90>Add New Users</a> | <a href=add.php?s=94>Check loginattempts</a> | <a href=fraud.php>Fraud Handling</a> | <a href=add.php?s=92>Logout</a> <br></p></body></html>";	    
	break;

	case 92:
	session_destroy();
	header('Location: login.php');
	break;

	case 93:
	if($_SESSION['userid']==1)
	{
	header('Location: users.php');
	}//if close
	else
	{
	session_destroy();
	echo "error! not an admin";
	echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
	//header("Location: login.php");
	}//else close
	break;

	case 94:
	if($_SESSION['userid']==1)
	{
	header('Location: loginattempt.php');
	}//if close
	else
	{
	session_destroy();
	echo "error! not an admin";
	echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
	//header("Location: login.php");
	}//else close
	break;
}//switch close



function icheck($i)
{
	if($i != null)
	{
		if(!is_numeric($i))
		{
			print "<b>ERROR:</b>";
			exit;
		}//if close
	}//if close
}//function close


?>