<?php
   require "Main.php";

    $mainClass = new page;
    $mainClass->post->filter();
    $arrOfInfo = $mainClass->productPage();
    $mainClass->post->postProducts($mainClass->user->userID);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/index.css"/>
<link rel="stylesheet" href="css/font-awesome.css"/>
<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
</head>
<body>

    <?php
        $mainClass->head();
      
        $mainClass->navigation();
    ?>
    <section class="row center-xm center-sm center-md center-lg">
      
			<div id="post_div" class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
			  <?php
                $mainClass->post_div('Wanna sell something you wont need anymore?','product');    
            ?>
			</div>
       
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5"
           id="product_div">
     
         <?php
              rsort($arrOfInfo);
              foreach($arrOfInfo as $x){
                    echo '<div id="container">';  
          echo '<div id="head">'; 
              echo '<h2>'.
                   '<span id="userID">'.$x['USER_ID'].'</span>'
                .$mainClass->getUser($x['USER_ID'])->name.' '.$mainClass->getUser($x['USER_ID'])->surname.'</h2>';
                  
                  
       echo '<div class="row">';
                    echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';  
                            if(!empty($x['PICTURE'])){
                                echo '<img id="cimg" src="data:image;base64,'.$x['PICTURE'].'"/>';
                            }
                          echo '</div>';
               echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                            echo '<p id="cp">'.$x['DESCRIPTION'].'</p>';  
                              echo '</div>';
							  echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                            echo '<label id="lbs">Number-Phone : '.$mainClass->getUser($x["USER_ID"])->numberPhone.'</label>'; 
							 echo '<label id="lbs">E-mail : '.$mainClass->getUser($x["USER_ID"])->email.'</label>'; 
							 echo '<label id="lbs">Price : '.$x['PRICE'].'</label>';  
							echo '<label id="lbs">Location : '.$x['LOCATION'].'</label>'; 
						   echo '<label id="lbs">State : '.$x['CURRENT_STATE'].'</label>';
                              echo '</div>';
                     echo '</div>';    
                   
               echo '</div>';
             echo '</div>';
                }
             ?>
        </div>
        
             <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
     <?php
                  $mainClass->filterTabForNewsFeed('product'); 
                  $mainClass->filterTabForPoroduct('product');   
                  $mainClass->filterTabForService('product');
                  ?>
           </div>
      
    </section>
    
  <?php
        $mainClass->footer();
    ?>
</body>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js">
    </script>
    <script type="application/javascript" src="bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
    <script>
	
	    $(document).ready(function(){
            
            $('#filters').click(function(){
                $('#profile_div').hide();
                $('#notification_div').show();
                $('section>div:nth-child(2)').hide();
            });
            $('#profile').click(function(){
                $('#profile_div').show();
                $('#notification_div').hide();
                $('section>div:nth-child(2)').hide();
            });
            $('#notifi_button').click(function(){
                $('#notification_div').hide();
            });
            
        });
	
        $('#logout').click(function(){
           
              $.post("ajaxGuy.php",
                     {
                    logout:'set5'
                },
                    function(data,status){
                 window.location = "login.php";
                    
              });
        });
    </script>
</html>