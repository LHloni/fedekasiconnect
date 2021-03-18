<?php

    include "Main.php";

    $mainClass = new page;

    $arrOfErrorAndValues = $mainClass->register();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/register.css"/>
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
           id="register_div">
           
             <?php  
			 
                if($arrOfErrorAndValues === false ){
					 echo '<div id="success">';
                    echo '<div id="head"> 
                  <h2>Register</h2>
                  <label>you have successfully registerd and the passwords is sent to your email.</label></div>';
                    echo '  <div id="btns"><button type="button" onclick="document.location =\'login.php\'">Login</button>
                    </div>';
					echo '</div>';
                  echo '<form action="register.php" method="post" id="register">';
                }else{
                    echo '<form action="register.php" method="post">';
                }
            ?>
             
                <div id="head"> 
                  <h2>Register</h2>
                  
                  <label for="name" >Name
                  <?php if(!empty($arrOfErrorAndValues[0]) && $arrOfErrorAndValues == true){
                 echo "<span id='error'>". $arrOfErrorAndValues[0]."</span>";
                 } ?></label><br/>
                 <input type="text" name="NAME" placeholder="Name" value='<?php if(!empty($arrOfErrorAndValues[10])){
                 echo $arrOfErrorAndValues[10];
                 } ?>'/><br/>
                 
                  <label for="surname" >Surname<?php if(!empty($arrOfErrorAndValues[1])){
                 echo "<span id='error'>". $arrOfErrorAndValues[1]."</span>";
                    } ?></label><br/>
                 <input type="text" name="SURNAME" placeholder="Surname" value='<?php if(!empty($arrOfErrorAndValues[11])){
                 echo $arrOfErrorAndValues[11];
                 } ?>'/><br/>
                 
                  <label for="emial">E-mail<?php if(!empty($arrOfErrorAndValues[2])){
                echo "<span id='error'>". $arrOfErrorAndValues[2]."</span>";
                } ?></label><br/>
                <input type="email" name="EMAIL" placeholder="E-mail" value='<?php if(!empty($arrOfErrorAndValues[12])){
                 echo $arrOfErrorAndValues[12];
                 } ?>'/><br/>
                 
                  <label for="kasi">Kasi<?php if(!empty($arrOfErrorAndValues[3])){
                    echo "<span id='error'>". $arrOfErrorAndValues[3]."</span>";
                    } ?></label><br/>
                    <input type="text" name="KASI" placeholder="Kasi" value='<?php if(!empty($arrOfErrorAndValues[13])){
                 echo $arrOfErrorAndValues[13];
                 } ?>'/><br/>
                    
                  <label for="kasi">Number<?php if(!empty($arrOfErrorAndValues[4])){
                echo "<span id='error'>". $arrOfErrorAndValues[4]."</span>";
                } ?></label><br/>
                 <input type="text" name="NUMBERPHONE" placeholder="Number" value='<?php if(!empty($arrOfErrorAndValues[14])){
                 echo $arrOfErrorAndValues[14];
                 } ?>'/><br/>
                 
                  <?php if(!empty($arrOfErrorAndValues[5])){
                echo "<span id='error'>". $arrOfErrorAndValues[5]."</span>";
                } ?>
                 <input type="radio" name="GENDER" value="male"/><label for="">Male</label><br/>
                  <input type="radio" name="GENDER" value="female"/><label for="">Female</label><br/>
                  <input type="radio" name="GENDER" value="other"/><label for="">Other</label><br/>
                
                    <label for="">Province<?php if(!empty($arrOfErrorAndValues[6])){
                    echo "<span id='error'>". $arrOfErrorAndValues[6]."</span>";
                    } ?></label><br/>
                  <select name="PROVINCE" id="selection">
                     <option value="value='<?php if(!empty($arrOfErrorAndValues[16])){
                 echo $arrOfErrorAndValues[16];
                 } ?>'"></option>
                      <option value="Gauteng">Gauteng</option>
                      <option value="Cape-Town">Cape Town</option>
                      <option value="Limpopo">Limpopo</option>
                      <option value="North-West">North West</option>
                      <option value="Northern-Cape">Northern Cape</option>
                      <option value="Mpumlanga">Mpumlanga</option>
                      <option value="Eastern-Cape">Eastern Cape</option>
                      <option value="Western-Cape">Western Cape</option>
                      <option value="Kwazulu-Natal">Kwazulu Natal</option>
                  </select><br/>
               
            <label for="">Date Of Birth<?php if(!empty($arrOfErrorAndValues[7])){
            echo "<span id='error'>". $arrOfErrorAndValues[7]."</span>";
            } ?></label><br/><input type="date" name="AGE" value='<?php if(!empty($arrOfErrorAndValues[17])){
                 echo $arrOfErrorAndValues[17];
                 } ?>'/><br/>
            
            <label for="">Address<?php if(!empty($arrOfErrorAndValues[8])){
            echo "<span id='error'>". $arrOfErrorAndValues[8]."</span>";
            } ?></label><br/><textarea id="" cols="30" rows="2" name="ADDRESS" placeholder="Address" value='<?php if(!empty($arrOfErrorAndValues[18])){
                 echo $arrOfErrorAndValues[18];
                 } ?>'></textarea><br/>
            
            <label for="">Postal Code<?php if(!empty($arrOfErrorAndValues[9])){
            echo "<span id='error'>". $arrOfErrorAndValues[9]."</span>";
            } ?></label><br/>
            <input type="text" name="POSTALCODE" placeholder="Postal Code" value='<?php if(!empty($arrOfErrorAndValues[19])){
                 echo $arrOfErrorAndValues[19];
                 } ?>'/><br/>
            
            </div>
            <div id="btns"><button type="submit" name="SUBMIT_REGISTER" >Submit</button> <button type="button" onclick="document.location = 'login.php'">Login</button>
            <?php if(!empty($arrOfErrorAndValues[20])){
            echo "<span id='error'>". $arrOfErrorAndValues[20]."</span>";
            } ?>
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