<?php
   require "Main.php";

    $mainClass = new page;

    $idOfChat = $_SESSION['TEMP_CHAT_ID'];

    $arrOfChats = $mainClass->chats->messages($idOfChat);

    $mainClass->chats->sendMessage($idOfChat,$mainClass->user->userID);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/chats.css"/>
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
      
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"
           id="chats">
           
              <form action="chats.php" method="post" >
               <div id="head">
                <h2>Who you talking to</h2>
                  <?php
                   if(!empty($arrOfChats)){
                       foreach($arrOfChats as $x){
                      $r = explode(",",$x);
                      
                      if($r[0] == $mainClass->user->name && $r[1] == $mainClass->user->surname){
                          echo '<div id="chat1">';
                      }else{
                         echo '<div id="chat2">'; 
                      }
                      
                      echo '<label>'.$r[0].' '.$r[1].'</label><br/>';
                      echo '<p>'.$r[2].'</p>';
                      echo '</div>';
                  }
                   }
                  
                  ?>
                  </div>
                    <div id="btns">
                        <textarea type="text" name="MESSAGE"></textarea>
                       <button type="submit" name="SUBMIT_CHAT">Reply</button>
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
          
          function important(idOfWhoPosted,idOfPost,idOfUser){
           var refId = "."+idOfPost+"like1";
              
              $.post("ajaxGuy.php",
                     {
                  impt:'set1',
                  IOU:idOfUser,
                  IOWP:idOfWhoPosted,
                  IOP:idOfPost
              },
                    function(data,status){
                  $(refId).text(data);
              });
          }
          
        function not_important(idOfWhoPosted,idOfPost,idOfUser){
            var refId = "."+idOfPost+"like2";
                $.post("ajaxGuy.php",
                     {
                    ntimpt:'set2',
                    IOU:idOfUser,
                    IOWP:idOfWhoPosted,
                    IOP:idOfPost
                },
                    function(data,status){
                        $(refId).text(data);
                    
              });
          }
		  
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