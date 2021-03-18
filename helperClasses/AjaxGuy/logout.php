<?php

	  if(isset($_POST['logout']) && $_POST['logout'] == 'set5'){
		   session_start();
		   session_unset($_SESSION['USER_ID']);
	   }

?>