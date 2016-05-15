

<?php
/* 
Name    : hw5.php 
Purpose : A php page that helps us display,add characters,pictures to the books 
Author  : vaishnavi vaishnavi.viswanathan@colorado.edu 
Version : 1.0 
Date    : 2016/24/02
*/

include_once('/var/www/html/hw9/hw6-lib.php');
connect($db);
icheck($s);
icheck($sid);
icheck($cid);
icheck($bid);


switch($s)
{

	case 0;

	default:
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
	      	<div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a></div>	
		<hr>
 		<p align='center'>Welcome!!!</p>";
	
	break;

	case 1:
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
		<hr>
		<table style='text-align:center' width='100%' border='0'><tr><td><b>BOOKS</b></td></tr>\n";
	$sid = mysqli_real_escape_string($db,$sid);
	if($stmt=mysqli_prepare($db,"select bookid,title from books where storyid=?"))
	{
		mysqli_stmt_bind_param($stmt,"s",$sid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$bid,$title);
		
		while(mysqli_stmt_fetch($stmt))
		{
			$bid = htmlspecialchars($bid);
			$title = htmlspecialchars($title);
			echo "<tr><td><a href=index.php?s=2&bid=$bid>$title</a></td></tr>";
		}//while close
		mysqli_stmt_close($stmt);
	}//if close
	echo "</table>";
	break;

	
	case 2:
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
		<hr>
		<table style='text-align:center' width='100%' border='0'><tr><td><b>CHARACTERS</b></td></tr>\n";
	$bid = mysqli_real_escape_string($db,$bid);
	if($stmt=mysqli_prepare($db,"select a.characterid,c.name from characters c,appears a where a.characterid=c.characterid and a.bookid=?"))
	{
		mysqli_stmt_bind_param($stmt,"s",$bid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$cid,$name);
		
		while(mysqli_stmt_fetch($stmt))
		{
			$cid = htmlspecialchars($cid);
			$title = htmlspecialchars($name);
			echo "<tr><td><a href=index.php?s=3&cid=$cid>$name</a></td></tr>";
		}//while close
		
		mysqli_stmt_close($stmt);
	}//if close
	echo "</table>";
	break;


	case 3:
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
		<hr>
		<table style='text-align:center' width='100%' border='0'><tr><td><b>CHARACTERS</b></td><td><b>BOOK</b></td><td><b>STORY</b></td></tr>\n";
	$cid = mysqli_real_escape_string($db,$cid);
	if($stmt=mysqli_prepare($db,"select c.name,b.title,s.story from characters c,appears a,stories s,books b where (s.storyid=b.storyid) and (b.bookid=a.bookid) and (c.characterid=a.characterid) and (c.characterid=?)"))
	{
		mysqli_stmt_bind_param($stmt,"s",$cid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$name,$book,$story);
		
		while(mysqli_stmt_fetch($stmt))
		{
			$name = htmlspecialchars($name);
			$book = htmlspecialchars($book);
			$story = htmlspecialchars($story);
			echo "<tr><td><a href=index.php>$name</a></td><td><a href=index.php>$book</a></td><td><a href=index.php>$story</a></td></tr>";
		}//while close		
		mysqli_stmt_close($stmt);
	}//if close
	echo "</table>";
	break;
	
	case 5:
	$name = mysqli_real_escape_string($db,$name);
	$race = mysqli_real_escape_string($db,$race);
	$side = mysqli_real_escape_string($db,$side);
	//echo "<p>$name,$race$side</p>";
	if($stmt=mysqli_prepare($db,"insert into characters set characterid='',name=?,race=?,side=?"))
	{
		mysqli_stmt_bind_param($stmt,"sss",$name,$race,$side);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
	}//if close
	
	if($stmt=mysqli_prepare($db,"select characterid from characters where name=? and race=? and side=?"))
	{
		mysqli_stmt_bind_param($stmt,"sss",$name,$race,$side);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$cid);
		while(mysqli_stmt_fetch($stmt))
		{
			$cid=$cid;
		}//while close
		mysqli_stmt_close($stmt);				
	}//if close
	else
	{
		echo "Error with Query";
	}//else close
	
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Secure Login</a></div>
		<hr>
		<p style='text-align:center'>Add picture to the Character <b><i>$name</i></b></p>
		<form method=post action=index.php?s=6&url=$url&cid=$cid&name=$name>
		<table align=center border='0' width=25%>
		<tr><td style='text-align:right'>Character picture URL</td><td style='text-align:left'><input type='text' name='url'/></td></tr>
		<tr><td><input type=submit name=submit value=submit></td><td></td></tr>
		</table>
		</form>";	
	break;


	case 6:
	$url = mysqli_real_escape_string($db,$url);
	$cid = mysqli_real_escape_string($db,$cid);
	$name = mysqli_real_escape_string($db,$name);
	
	if($stmt=mysqli_prepare($db,"insert into pictures set pictureid='',url=?,characterid=?"))
	{
		mysqli_stmt_bind_param($stmt,"ss",$url,$cid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}//if close

	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
		<hr>
		<p style='text-align:center'>Added picture for the Character <b><i>$name</i></b></p>
		<form method=post action=index.php?s=7&cid=$cid&name=$name>
		<p style='text-align:center'><input type=submit name=submit value='Add character to Books'></p>
		</form>";	
	break;	


	case 7:
	echo "<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>	
		<hr>";
	$cid = mysqli_real_escape_string($db,$cid);
	$name = mysqli_real_escape_string($db,$name);
	echo "<p style='text-align:center'>Add $name to Books</p>
		<form method=post action=index.php?s=8&bid=$bid&cid=$cid&name=$name>
		<table align=center border=0 width=25%><tr><td style='text-align:right'>Select Book</td></p>";	
	
	if($stmt=mysqli_prepare($db,"select distinct(a.bookid),b.title from books b, appears a where a.bookid not in (select bookid from appears where characterid=?) and b.bookid=a.bookid"))
	{
		mysqli_stmt_bind_param($stmt,"s",$cid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$bookid,$title);
		
		
		echo "<td style='text-align:left'><select name='bid'><option value=''>Select ..</option>";
		while(mysqli_stmt_fetch($stmt))
		{
			echo "<option value=$bookid>$title</option>";
		}//while close
		echo "</select></td></tr>";
		mysqli_stmt_close($stmt);
	}//if close
	
	echo "<tr><td style='text-align:right'><input type=submit name=submit value='Add to Book'></td><td></td></tr>
		</table>
		</form>";		
	break;

	case 8:
	echo "<head><title>Mine:Tolkien</title></head>";
	echo "<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>";	
	echo "<hr>";
	$cid = mysqli_real_escape_string($db,$cid);
	$bid = mysqli_real_escape_string($db,$bid);
	$name = mysqli_real_escape_string($db,$name);
	
	if($stmt=mysqli_prepare($db,"insert into appears set appearsid='',bookid=?,characterid=?"))
	{
		mysqli_stmt_bind_param($stmt,"ss",$bid,$cid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);	
	}//if close
	
	echo "<p style='text-align:center'>Added $name to Books $bid</p>";
	echo "<form method=post action=index.php?s=8&bid=$bid&cid=$cid&name=$name>";
	echo "<table align=center border=0 width=25%><tr><td style='text-align:right'>Select Book</td></p>";	

	if($stmt=mysqli_prepare($db,"select distinct(a.bookid),b.title from books b, appears a where a.bookid not in (select bookid from appears where characterid=?) and b.bookid=a.bookid"))
	{
		mysqli_stmt_bind_param($stmt,"s",$cid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$bookid,$title);
		
		
		echo "<td style='text-align:left'><select name='bid'><option value=''>Select ..</option>";
		while(mysqli_stmt_fetch($stmt))
		{
			echo "<option value=$bookid>$title</option>";
		}//while close
		echo "</select></td></tr>";
		mysqli_stmt_close($stmt);
	}//if close
	echo "<tr><td style='text-align:right'><input type=submit name=submit value='Add to Book'></td><td><a href='index.php?s=3&cid=$cid'>Done</a></td></tr>
		</table>
		</form>";		
	break;

	case 50:
	echo "<head><title>Mine:Tolkien</title></head>
		<div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
		<hr>
		<table style='text-align:center' width='100%' border='0'><tr><td><b>CHARACTERS</b></td><td><b>PICTURES</b></td></tr>\n";
	if($stmt=mysqli_prepare($db,"select c.characterid,c.name,p.url from characters c,pictures p where c.characterid=p.characterid"))
	{
		
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$cid,$name,$url);
		
		while(mysqli_stmt_fetch($stmt))
		{
			$cid = htmlspecialchars($cid);
			$name = htmlspecialchars($name);
			$url = htmlspecialchars($url);
			echo "<tr><td><a href=index.php?cid=$cid&s=3>$name</a></td><td><img src='$url'></img></td></tr>";
		}//while close
		
	mysqli_stmt_close($stmt);
	}
	echo "</table>";	
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

