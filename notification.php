<?php
   require "Main.php";

    $mainClass = new page;

    $arrOfInfo = $mainClass->getNotifications($mainClass->user->userID);
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/notification.css"/>
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
       
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5"
           id="notifications">
          
          <div id="container">
              <h2>Notifications</h2>
              
              <table>
                 <?php
                      if(!empty($arrOfInfo)){
                             foreach($arrOfInfo as $x){
                            echo '<tr id="tableR">';
                            if($x['WHAT_HAPPENED'] == "c"){
                               echo '<th><i class="fa fa-comment" id="nIcon"></i></th>'; 
                            }elseif(($x['WHAT_HAPPENED'] == "s")){
                                echo '<th><i class="fa fa-share" id="nIcon"></i></th>'; 
                            }

                             echo '<th><label id="nLabel">'.$x['WHO_COS'].' commented on your post</label></th>';
                             echo '<th><button id="nBtn" onclick="goToThatPost('.$x['POST_ID'].');">View </button></th>';
                             echo ' </tr>';
                        }
                      }
                  ?>
              </table>
              
          </div>
      
        </div>
        
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
         <?php
                  $mainClass->filterTabForNewsFeed('notification'); 
                  $mainClass->filterTabForPoroduct('notification');   
                  $mainClass->filterTabForService('notification');
                  ?>
           </div>
           
    </section>
    
    <?php
        $mainClass->footer();
    ?>
    
</body>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js">
    </script>
     <script type="text/javascript" src="js/main.js"></script>
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