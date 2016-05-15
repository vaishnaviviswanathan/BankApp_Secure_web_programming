<?php

isset( $_REQUEST['s']   ) ?   $s = strip_tags($_REQUEST['s'])   : $s = "";
isset( $_REQUEST['sid'] ) ? $sid = strip_tags($_REQUEST['sid']) : $sid = "";
isset( $_REQUEST['bid'] ) ? $bid = strip_tags($_REQUEST['bid']) : $bid = "";
isset( $_REQUEST['cid'] ) ? $cid = strip_tags($_REQUEST['cid']) : $cid = "";
isset( $_REQUEST['name'] ) ? $name = strip_tags($_REQUEST['name']) : $name = "";
isset( $_REQUEST['race'] ) ? $race = strip_tags($_REQUEST['race']) : $race = "";
isset( $_REQUEST['side'] ) ? $side = strip_tags($_REQUEST['side']) : $side = "";
isset( $_REQUEST['url'] ) ? $url = strip_tags($_REQUEST['url']) : $url = "";
isset( $_REQUEST['user'] ) ? $user = strip_tags($_REQUEST['user']) : $user = "";
isset( $_REQUEST['pswdtext'] ) ? $pswdtext = strip_tags($_REQUEST['pswdtext']) : $pswdtext = "";
isset( $_REQUEST['emailid'] ) ? $emailid = strip_tags($_REQUEST['emailid']) : $emailid = "";
isset( $_REQUEST['address'] ) ? $address = strip_tags($_REQUEST['address']) : $address = "";
isset( $_REQUEST['mobilenumber'] ) ? $mobilenumber = strip_tags($_REQUEST['mobilenumber']) : $mobilenumber = "";
isset( $_REQUEST['ssnnumber'] ) ? $ssnnumber = strip_tags($_REQUEST['ssnnumber']) : $ssnnumber = "";
isset( $_REQUEST['checking'] ) ? $checking = strip_tags($_REQUEST['checking']) : $checking = "";
isset( $_REQUEST['saving'] ) ? $saving = strip_tags($_REQUEST['saving']) : $saving = "";
isset( $_REQUEST['camount'] ) ? $camount = strip_tags($_REQUEST['camount']) : $camount = "";
isset( $_REQUEST['samount'] ) ? $samount = strip_tags($_REQUEST['samount']) : $samount = "";
isset( $_REQUEST['ssntext'] ) ? $ssntext = strip_tags($_REQUEST['ssntext']) : $ssntext = "";
isset( $_REQUEST['fromacc'] ) ? $fromacc = strip_tags($_REQUEST['fromacc']) : $fromacc = "";
isset( $_REQUEST['toacc'] ) ? $toacc = strip_tags($_REQUEST['toacc']) : $toacc = "";
isset( $_REQUEST['amount'] ) ? $amount = strip_tags($_REQUEST['amount']) : $amount = "";
isset( $_REQUEST['senddate'] ) ? $senddate = strip_tags($_REQUEST['senddate']) : $senddate = "";
isset( $_REQUEST['description'] ) ? $description = strip_tags($_REQUEST['description']) : $description = "";
isset( $_REQUEST['ramount'] ) ? $ramount = strip_tags($_REQUEST['ramount']) : $ramount = "";
isset( $_REQUEST['rname'] ) ? $rname = strip_tags($_REQUEST['rname']) : $rname = "";

isset( $_REQUEST['a'] ) ? $a = strip_tags($_REQUEST['a']) : $a = "";
isset( $_REQUEST['b'] ) ? $b = strip_tags($_REQUEST['b']) : $b = "";
isset( $_REQUEST['c'] ) ? $c = strip_tags($_REQUEST['c']) : $c = "";
isset( $_REQUEST['d'] ) ? $d = strip_tags($_REQUEST['d']) : $d = "";
isset( $_REQUEST['e'] ) ? $e = strip_tags($_REQUEST['e']) : $e = "";
isset( $_REQUEST['f'] ) ? $f = strip_tags($_REQUEST['f']) : $f = "";


function connect(&$db)
{
	$mycnf="/etc/hw5-mysql.conf";
	if(!file_exists($mycnf))
	{
	echo "error file not found: $mycnf";
	exit;
	}

	$mysql_ini_array = parse_ini_file($mycnf);
	$db_host = $mysql_ini_array["host"];
	$db_user = $mysql_ini_array["user"];
	$db_pass = $mysql_ini_array["pass"];
	$db_port = $mysql_ini_array["port"];
	$db_name = $mysql_ini_array["dbName"];

	$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name,$db_port);

	if(!$db)
	{
	print "error connecting to DB:".mysqli_connect_error();
	exit;
	}//if close
}//function close

function authenticate($db,$postUser,$postPass)
{
	if($postUser=="" && postPass=="")
	{
		header("Location: login.php");
		session_destroy();
	}	

	$query="select userid,email,password,salt from users where username=?";
	
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_bind_param($stmt,"s",$postUser);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$userid,$email,$password,$salt);
	while(mysqli_stmt_fetch($stmt))
	{
		$userid=$userid;
		$password=$password;
		$salt=$salt;
		$email=$email;
	}//while close

	mysqli_stmt_close($stmt);
	$epass=hash('sha256',$postPass.$salt);

	if($epass==$password)
	{
		session_regenerate_id();
		$_SESSION['userid']=$userid;
		$_SESSION['email']=$email;
		$_SESSION['authenticated']="yes";
		$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$_SESSION['HTTP_USER_AGENT']=md5($SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		$_SESSION['created']=time();
		$action="success";
		$date = date('Y-m-d H:i:sa');
		//$date = new DateTime("@".$_SERVER['REQUEST_TIME']);
		if($stmt=mysqli_prepare($db,"insert into login set loginid='',ip=?,user=?,date=?,action=?"))
		{
		mysqli_stmt_bind_param($stmt,"ssss",$ip,$userid,$date,$action);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
		}//if close	
	}//inner if
	else
	{
		$_SESSION['userid']=$userid;
		$_SESSION['email']=$email;
		$_SESSION['authenticated']="yes";
		$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$_SESSION['HTTP_USER_AGENT']=md5($SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		$_SESSION['created']=time();
		$action="failure";
		error_log("**error!** Tolkein App has failed login from".$_SERVER['REMOTE_ADDR'],0);
		$date = date('Y-m-d H:i:s');               
		if($stmt=mysqli_prepare($db,"insert into login set loginid='',ip=?,user=?,date=?,action=?"))
		{
		mysqli_stmt_bind_param($stmt,"ssss",$ip,$userid,$date,$action);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
		}//if close	
		checkattempt();	
		session_destroy();
		exit;
	}//else close
	checkAuth();
	}//if close
	}//function close



function checkAuth()
{

	if(isset($_SESSION['ip']))
	{
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])
		{	
		logout();
		}//if close
	}//if close
	else
	{
		logout();
	}//else close

	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		if($_SESSION['HTTP_USER_AGENT'] != md5($SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']))
		{	
		logout();
		}//if close
	}//if close
	else
	{
		logout();
	}//else close
	


	if(isset($_SESSION['created']))
	{
		if( time() - $_SESSION['created'] > 1800)
		{	
		logout();
		}//if close
	}//if close
	else
	{
		logout();
	}//else close

	
	if("POST" == $_SERVER['REQUEST_METHOD'])
	{
		if(isset($_SERVER['HTTP_ORIGIN']))
		{
			if($_SERVER['HTTP_ORIGIN'] != 'https://100.66.1.52')
			{
				logout();
			}//if close				
		}//if close
		else
		{
			logout();
		}//else close
	}//if close
	


}//function close


function logout()
{
	session_destroy();
	header('Location: login.php');
}


function addUser()
{
	echo "<html>
		<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<body>
		<div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a></div>	
		<hr>
		<p style='text-align:center'>CREATING A NEW ACCOUNT</p>
		<form method=post action='add.php'>
		<table align=center border='0' width=50% colspan='4'>
		<tr><td style='text-align:left'>Username:</td><td style='text-align:left'><input type='text' name='user'/></td></tr>
		<tr><td style='text-align:left'>Password:</td><td style='text-align:left'><input type='password' name='pswdtext'/></td></tr>
		<tr><td style='text-align:left'>Email:</td><td style='text-align:left'><input type='email' name='emailid'/></td></tr>
		<tr><td style='text-align:left'>Home Address:</td><td style='text-align:left'><input type='text' name='address'/></td></tr>
		<tr><td style='text-align:left'>Mobile number:</td><td style='text-align:left'><input type='text' name='mobilenumber'/></td></tr>
		<tr><td style='text-align:left'>SSN number</td><td style='text-align:left'><input type='text' name='ssnnumber'/></td></tr>
		<tr><td style='text-align:left'>Checking Account number:</td><td style='text-align:left'><input type='text' name='checking'/></td><td style='text-align:left'>Initial deposit: $</td><td style='text-align:left'><input type='text' name='camount'/></td></tr>
		<tr><td style='text-align:left'>Savings Account number: </td><td style='text-align:left'><input type='text' name='saving'/></td><td style='text-align:left'>Initial deposit: $</td><td style='text-align:left'><input type='text' name='samount'/></td></tr>
		<tr><td><input type=hidden name=s value=91><input type=submit name='submit' value='Submit'/></td><td></td></tr>
		</table>
		</form>
		<br>
		<p style='text-align:center'><a href=add.php?s=93>Check Users</a> | <a href=add.php?s=90>Add New Users</a> | <a href=add.php?s=94> Check login attempts </a> | <a href=fraud.php> Fraud Handling </a> | <a href=add.php?s=92>Logout</a> 
		<br></p></body></html>";
}


function checkattempt()
{
	//echo "Failed to Login";
	connect($db);
	$whitelist = array("198.18.2.90","198.18.1.90");	
	$query="select ip,date,count(ip) from login where action='failure' and date>=date_sub(now(),INTERVAL 1 HOUR)";
	if($stmt=mysqli_prepare($db,$query))
	{
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$useripaddr,$erdate,$usercount);
	while(mysqli_stmt_fetch($stmt))
	{
			if(($usercount>=5) && (in_array($ip,$whitelist)))
			{
			echo "<p align='center'><b> SORRY ! YOU HAVE MORE THAN 5 FAILED ATTEMPTS - YOU HAVE BEEN BLOCKED</b></p>";
			}
			else
			{
			echo "<p align='center'><b>WRONG PASSWORD TRY AGIAN! - WAIT TO REDIRECT </b></p>";
			echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
			}
	}//while close
	}//if close
	//echo "</table>";
	mysqli_stmt_close($stmt);
}//function close
?>

