<?php
   require "Main.php";

    $mainClass = new page;
    $mainClass->post->filter();
    $mainClass->aboutPage();

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
      
       <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="profile_div">
       <?php
                 $mainClass->profilePage();
                 ?>
        </div>
       

         <div class="col-xs-12 col-sm-12 col-md-11 col-lg-5"
           id="product_div">
            <div id="container">
           <div id="head"><h2>About</h2>
            <p>Well at this moment i dont have a proper explanation but for now just take this website as platform for kasi people to connect and help each other by sharing important helpful news , and you can use this website to selling your products e.g laptop,tv,iron at a cheaper price for your fellow community members and you can also buy products other people a selling and your can advertise and view service at fellow community members are providing and compare prices etc.
            <br/>
            The website gives you a chance to market your product/services effectively and also get important information and alerts about whats happening around you , you can search around your kasi or any kasi or the whole province even check what other provinces are providing.
            </p></div>
        
            <div id="btns"><button><i class="fa fa-twitter">(@LEXTHEREALMC)</i></button>
            <button><i class="fa fa-facebook"> (Hloni Mphuthi)</i></button>
            <button><i class="fa fa-whatsapp">(0644701482)</i></button>
            <button><i class="fa fa-google">(lmphuthi09@gmail.com)</i></button></div>
             </div>
        </div>
        
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
       <?php
                  $mainClass->filterTabForNewsFeed('about'); 
                  $mainClass->filterTabForPoroduct('about');   
                  $mainClass->filterTabForService('about');
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
		
		       var viewpic = true;
        $('img').click(function(){
            
            if(viewpic){
                $(this).removeAttr('id','none');
            $(this).addClass('cimgModal');
            viewpic = false;
               }else{
                   $(this).attr('id','cimg');
            $(this).removeClass('cimgModal');
                   viewpic = true;
               }
            
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
        

        
         
