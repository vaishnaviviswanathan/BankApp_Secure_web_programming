<?php
echo "
<html>
<head><title>TLEN5839:hw5:vaishnaviMine:Tolkien</title></head>
 <body> 
  <div align='center'><a href=index.php>Story List</a> | <a href=index.php?s=50>Character List</a> | <a href=login.php>Add Characters</a></div>
  <hr>
  <form method=post action=add.php>
   <table align='center' width='25%' border='0'>
    <tr><td align='right'>Username:</td><td align='left'><input type='text' name='username_text'></td></tr>
    <tr><td align='right' >Password:</td><td align='left'><input type='password' name='pswd_text'></td></tr>"
    <tr><td align='center' ><input type='submit' value='Login' name='login'></td><td></td></tr>
   </table>
  </form>
 </body>
</html>";

?>
