
<?php
include_once('/var/www/html/project/hw6-lib.php');
connect($db);

echo "<style type='text/css'>
body 
{
    background: url('https://www20.wellsfargomedia.com/assets/images/contextual/banner/credit-card/617x260/wfcc002_ph_d-securedvisacard2-C_617x260.jpg');
    background-size: 1000px 500px;
    background-repeat: no-repeat;
    background-position: center; 	
}
</style>";

echo "<html><head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
<div align='center'><a href=index.php>Home</a> | <a href=login.php>Secure Login</a></div>	
<hr>
<form method=post action=add.php>
<table border='0' style='text-align:left;margin-left:300px;margin-top:100px;' width='15%'>
<tr><td align='right'>Username:</td><td align='left'><input type='text' name=username></td></tr>
<tr><td align='right'>Password:</td><td align='left'><input type='password' name=pswdtext></td></tr>
<tr><td align='center'><input type='submit' value='Login' name='login'></td></tr>
</table>
</form>
</html>";
      
?>