<?php
   require "Main.php";

    $mainClass = new page;
    $postId = $_SESSION['TEMP_ID_POST'];
    $idOfWhoPosted = $_SESSION['TEMP_OF_WHO_ID_POST'];
    $arrOfResults = $mainClass->commentPage($idOfWhoPosted,$postId);
    $mainClass->comment($postId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/post_comments.css"/>
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
      
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"
           id="post_comments">
           
              <form action="comment.php" method="post" >
               <div id="head">
                <h2>Comments</h2>
                   <?php
                  
                   foreach($arrOfResults as $x){
                       echo '<div id="comments">';
                       $y = explode(",",$x);
                       echo '<label>'.$y[0].' '.$y[1].'</label><br/>';
                    echo '<p>'.$y[2].'</p>';
                       echo '</div>';
                   }
                   ?>
                  </div>
                    <div id="btns">
                        <textarea type="text" id="comment" name="COMMENT" value=""></textarea>
                       <button type="submit" id="btnC" name="SUBMIT_COMMENT">Comment</button>
                   </div>                   
                
              </form>
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