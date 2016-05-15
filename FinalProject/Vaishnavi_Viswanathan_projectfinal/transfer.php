<?php
session_start();
include_once('/var/www/html/project/hw6-lib.php');
//ini_set('display_errors','On');
connect($db);


icheck($fromacc);
icheck($toacc);
icheck($amount);
scheck($rname);



function icheck($i)
{
	if($i != null)
	{
		if(!is_numeric($i))
		{
			print "<b>ERROR: Check if you had entered alphabets instead of numbers in (TO AND FROM ACCOUNTS/ AMOUNT)</b>";
			exit;
		}//if close

	}//if close
}//function close

function scheck($i)
{
	if($i != null)
	{
		if(is_numeric($i))
		{
			print "<b>ERROR: Check if you had entered numbers instead of alphabets for RECEIVERS NAME </b>";
			exit;
		}//if close

	}//if close
}//function close




function errorfromacc()
{
		$checking=$_SESSION['checking'];
		$saving=$_SESSION['saving'];

		if(!isset($_POST['fromacc']))
		{	
			echo "<font color=white>Enter your checking or savings account number</font>";
			$_SESSION['a']="false";
		}//if close
		else if($_POST['fromacc']=="")
		{
			echo "<font color=red>Enter an account number</font>";
			$_SESSION['a']="false";
		}//else if close
		else if( ($_POST['fromacc']!=$checking) && ($_POST['fromacc']!=$saving) )
		{
			echo "<font color=red>Sry! You can enter only your account number</font>";
				
		}//else close
		else if( ($_POST['fromacc']==$checking) || ($_POST['fromacc']==$saving) )
		{
			//echo "<font color=white>Valid!</font>";
			$fromacc=htmlspecialchars($_POST['fromacc']);
			$_SESSION['a']="true";
		}	
		
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/
}

function errortoacc()
{
		if(!isset($_POST['toacc']))
		{
			echo "<font color=white>Enter either checking or savings account number of customer to transfer amount</font>";
		}//if close
		else if($_POST['toacc']=="")	
		{
			echo "<font color=red>Enter an account number</font>";
		}//else close
		else if($_POST['toacc']!="")	
		{
			$toacc=htmlspecialchars($_POST['toacc']);
			//echo "<font color=white>Valid!</font>";		
		}//else close		
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/	
}

function erroramount()
{
		$checking=$_SESSION['checking'];
		$saving=$_SESSION['saving'];
		$camount=$_SESSION['camount'];
		$samount=$_SESSION['samount'];

		if(!isset($_POST['amount']))
		{
			echo "<font color=white>Enter amount to be sent </font>";
			//$_SESSION['b']="false";
		}//if close
		else if($_POST['amount']=="")	
		{
			echo "<font color=red>Enter amount</font>";
			//$_SESSION['b']="false";
		}
		/*else if( (($_POST['fromacc']==$checking) && ($_POST['amount']<$camount) && ($_POST['amount']>=2000)) || (($_POST['fromacc']==$saving) && ($_POST['amount']<$samount) && ($_POST['amount']>=2000)) )
		{
			echo "<font color=red>Amount range exceeds $2000 <br> Send between $0-2000</font>";
			//$_SESSION['b']="false";
		}*/
		else if( ($_POST['fromacc']==$checking && $_POST['amount']>$camount) || ($_POST['fromacc']==$saving || $_POST['amount']>$samount) )
		{
			echo "<font color=red>Sry! your balance is less!</font>";
			//$_SESSION['b']="false";
		}
		else if( ($_POST['fromacc']==$checking && $_POST['amount']<$camount && $_POST['amount']<=2000) || ($_POST['fromacc']==$saving && $_POST['amount']<$samount && $_POST['amount']<=2000) )
		{
			//echo "<font color=white>Valid!</font>";
			$amount = htmlspecialchars($_POST['amount']);
			//$_SESSION['b']="true";
		}
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/
}


function errorsenddate()
{
		if(!isset($_POST['senddate']))
		{
			echo "<font color=white>Enter date</font>";
		}//if close
		else if($_POST['senddate']=="")	
		{
			echo "<font color=red>Select date</font>";
		}
		else if($_POST['senddate']!="")
		{
			//echo"<font color=white>Valid!</font>";
			$senddate = htmlspecialchars($_POST['senddate']);
		}
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/			
}
function errorrname()
{
		if(!isset($_POST['rname']))
		{
			echo "<font color=white>Enter the recipients name</font>";
		}//if close
		else if($_POST['rname']=="")	
		{
			echo "<font color=red>Recipients name cannot be empty</font>";
		}
		else if($_POST['rname']!="")
		{
			//echo"<font color=white>Valid!</font>";
			$rname = htmlspecialchars($_POST['rname']);
		}
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/		
}

function errordescription()
{
		if(!isset($_POST['description']))
		{
			echo "<font color=white>For what reason are you sending the money for?</font>";
		}//if close
		else if($_POST['description']=="")	
		{
			echo "<font color=red>Enter a description</font>";
		}
		else if($_POST['description']!="")
		{
			//echo"<font color=white>Valid!</font>";
			$description = htmlspecialchars($_POST['description']);
		}
		/*else if($_POST['fromacc']!="" && $_POST['toacc']!="" && $_POST['amount']!="" && $_POST['senddate']!="" && $_POST['description']!="" )
		{
			$_SESSION['description']=htmlspecialchars($_POST['description']);
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
		}*/
}



function errorcheckall()
{


		if(($_POST['fromacc']!="") && ($_POST['toacc']!="") && ($_POST['amount']!="") && ($_POST['senddate']!="") && ($_POST['description']!="") && ($_POST['rname']!=""))
		{
			if($_SESSION['a']=="true")
			{
			session_write_close();
			header("Location: confirmationpage.php");
			exit();
			}
		}
}//function close




echo "<style type='text/css'>
	body 
	{
    	background: url('https://www.sbicard.com/sbi-card-en/assets/media/images/personal/credit-cards/value-savings/card-flip/sbi-gold-card.png');
    	//background: url('blue.PNG');
	//background: #B8860B;
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

	echo	"<p align='center' style='margin-top:90px'><b>TRANSFER MONEY TO ANOTHER ACCOUNT HOLDER</b></p>
		<form action=transfer.php method=post>
		<table id=bgdesign align='center' style='margin-top:30px' class='profile' colspan='4'>
		<tr><td><b><font color=red>*</font>FROM ACCOUNT</b></td><td padding-right:40px></td><td><b>:</b><input type=text value='$fromacc' name='fromacc'/></td><td>";errorfromacc();$_SESSION['fromacc']=$fromacc;
		echo "</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td><td></td></tr>
		<tr><td><b><font color=red>*</font>RECIPIENT NAME</b></td><td padding-right:40px></td><td><b>:</b><input type=text value='$rname' name='rname'/></td><td>";errorrname();$_SESSION['rname']=$rname;
		echo "</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td><td></td></tr>
		<tr><td><b><font color=red>*</font>TO ACCOUNT</b></td><td padding-right:40px></td><td><b>:</b><input type=text value='$toacc' name='toacc'/></td><td>";errortoacc();$_SESSION['toacc']=$toacc;
		echo "</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td><td></td></tr>
		<tr><td><b><font color=red>*</font>AMOUNT</b></td><td padding-right:40px></td><td><b>$</b><input type=text value='$amount' name='amount'/></td><td>";erroramount();$_SESSION['senddate']=$senddate;
		echo "</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td><td></td></tr>
		<tr><td><b><font color=red>*</font>SEND DATE</b></td><td padding-right:40px></td><td><b>:</b><input type=date value='$senddate' min=date('m/d/Y') name='senddate'/></td><td>";errorsenddate();$_SESSION['amount']=$amount;
		echo "</td></tr>
		<tr class='border_bottom' style='height:5px'><td></td><td></td><td></td><td></td></tr>
		<tr><td><b><font color=red>*</font>DESCRIPTION</b></td><td padding-right:40px></td><td><b>:</b><input type=text value='$description' name='description'/></td><td>";errordescription();$_SESSION['description']=$description;errorcheckall();	
		echo "</td></tr>
		</table>";
		echo "<p align='center'><input type=hidden value=1 name=s><input type='submit' value='Submit' name='login'></p>
		</form>
		</body></html>";
	//mysqli_stmt_close($stmt);
	break;
}//switch close

?>