<?php
  
    require "Main.php";

    $mainClass = new page;

    $arrOfError = $mainClass->login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/login.css"/>
<link rel="stylesheet" href="css/index.css"/>
<link rel="stylesheet" href="css/font-awesome.css"/>
<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
</head>
<body>
  
   <header class="row center-xs center-sm center-md center-lg">
           <h1 class="col-xs-11 col-sm-11 col-md-11 col-lg-10"><span id="hd">FKC </span> Fede Kasi Connect</h1>
        </header>
  
   <section class="row center-xm center-sm center-md center-lg">      
        
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"
           id="login_div">
              <form action="login.php" method="post">
               <div id="head">
                <h2>Login</h2>
               <?php
                   if(!empty($arrOfError[2])){
                    echo "<span id='error'>".$arrOfError[2]."</span><br/>";
                }?>
               <label for="email/numbers">E-mail/number:
               <?php
                   if(!empty($arrOfError[0])){
                    echo "<span id='error'>".$arrOfError[0]."</span>";
                }?>
               </label><br/>
               <input type="text" name="EMAIL_NUMBER" placeholder="E-mail/number"><br/>
               <label for="password">Password:
                 <?php
                   if(!empty($arrOfError[1])){
                    echo "<span id='error'>".$arrOfError[1]."</span>";
                }?>
                </label><br/>
               <input type="password" name="PASSWORD" placeholder="Password"><br/>
            
           <button type="submit" name="SUBMIT_LOGIN">Login</button>
            <button type="button" onclick="document.location = 'register.php'">SignUp</button> <br/>
             <a> <p  id="forgot_password">forgot password ?</p></a>
              </div>
              </form>
              
        </div>
    </section>
    
   <?php
        $mainClass->footer();
    ?>
</body>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="application/javascript" src="bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
</html>