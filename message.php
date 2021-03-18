<?php
   require "Main.php";

    $mainClass = new page;
    $mainClass->post->filter();
    $mainClass->messagePage();

    $mainClass->chats->startConversation($mainClass->user->userID);
    $arrOfContacts = $mainClass->chats->myContacts($mainClass->user->userID);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HomePage</title>
<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/main2.css"/>
<link rel="stylesheet" href="css/msg_container.css"/>
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
           id="product_div">
            
            
               <div id="post_div">
           <form action="message.php" method="post" >
               
                <div id="head"><h2>Send Message To:</h2>
                
                <table id="table1">
                <tr>
                    <th><label id="labels">Enter number-phone or email:</label></th>
                </tr>
                <tr>
                    <th><input id="inpt" type="text" placeholder="Enter number-phone or email" name="SEND_TO"/></th>
                </tr>
                <tr>
                    <th><label id="labels" for="MESSAGE">Message:</label> </th>
                </tr>
                <tr>
                    <th> <textarea id="txta" placeholder="Message" name="MESSAGE"></textarea></th>
                </tr>
                </table>
            
               </div>
            <div id="btns" >
            <button type="submit" name="SUBMIT_POST">Send Message</button>  
        </div>
               
           </form>
        </div>
            
            
             <div id="msg_container">
           <div id="head">
           <h2>Chats</h2>
             
             <table>
             <?php
                 if(!empty($arrOfContacts)){
                      foreach($arrOfContacts as $x){
                 $y = explode(",",$x);
              echo '<tr>';
             if(!empty($y[3])){
                 echo '<th><img id="msgimg" src="profile_pic/'.$y[3].'" /></th>';
                }else{
                  echo '<th><img id="msgimg" src="profile_pic/defaultpp.png" /></th>';
             }  
            echo '<th><button name="cht" id="msgbutton" type="button" onclick="chatWithUser('.$y[0].')">Chat with</button></th>';
            echo ' <th> <label id="msglabel">'.$y[1].' '. $y[2].'</label> </th>';
            echo '<th><p id="msgp">(no new messages)</p>';
            echo '</th>';
               echo '</tr>';
                }
                 }
            
                 ?>         
             </table>
               
            </div>
        
           </div> 
        </div>
        
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
          <?php
                  $mainClass->filterTabForNewsFeed('messsage'); 
                  $mainClass->filterTabForPoroduct('messsage');   
                  $mainClass->filterTabForService('messsage');
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
         function chatWithUser(idOfChat){
             $.post("ajaxGuy.php",
                     {
                    cht:'set4',
                    ID_CHAT:idOfChat
                },
                function(data,status){
                 window.location =  'chats.php';
                    
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
        
      
