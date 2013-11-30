<?php

function emit_authenticate() {
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
  <html>
  <head>
  </head>
  <body>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table width="300" cellpadding="4" cellspacing="1" border="0">
      <tr>
        <td>
          nome utente: 
        </td>
        <td>
          <input type="text" name="userid">
        </td>
      </tr>
      <tr>
        <td>
          password: 
        </td>
        <td>
          <input type="password" name="passwd">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" name="invio" value="invio">
          <input type="reset" name="cancella" value="cancella">
        </td>
      </tr>
    </table>
    <br>
  </form>
  </body>
  </html>
<?

}


// -------------		MAIN
$nomeutente 	= "prova2";
$password 	= "prova2";
  
  
session_start();

if (isset($_POST["invio"])) {

  
  if ($_POST["passwd"] == trim($password)) {
    $_SESSION["autorizzato"] = 1;
    
	echo "authorized";
  } else {
		
	$_SESSION = array();
	session_destroy();
	echo "NOT Authorized";
  }
  
} else {
	emit_authenticate();
}
?>