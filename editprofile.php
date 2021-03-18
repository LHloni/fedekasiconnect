<?php
   require "Main.php";

    $mainClass = new page;
    $mainClass->editProfile($mainClass->user->userID);

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
      
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"
           id="profile_edit">
           
              <form action="editprofile.php" method="post" enctype="multipart/form-data">
               <div id="head">
                <h2>Edit Profile</h2>
                
                 <img src='<?php  if(!empty($mainClass->user->profilePic)){
                echo "profile_pic/".$mainClass->user->profilePic;
                }else{
                echo "profile_pic/defaultpp.png";
                }?>'/>
                <table>
                   <tr>
                       <th><label id="pLabel">Profile Pic</label></th>
                       <th><input type="file" name="PROFILEPIC" id="pbInput"></th>
                   </tr>
                    <tr>
                        <th><label id="pLabel">Name:</label></th>
                        <th><input type="text" name="NAME" id="pInput" value="<?php 
                   echo $mainClass->user->name;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Surname:</label></th>
                        <th><input type="text" name="SURNAME" id="pInput" value="<?php 
                   echo $mainClass->user->surname;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Phone No. :</label></th>
                        <th><input type="text" name="NUMBERPHONE" id="pInput" value="<?php 
                   echo $mainClass->user->numberPhone;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Email:</label></th>
                        <th><input type="text" name="EMAIL" id="pInput" value="<?php 
                   echo $mainClass->user->email;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Province:</label></th>
                        <th><input type="text" name="PROVINCE" id="pInput" value="<?php 
                   echo $mainClass->user->province;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th> <label id="pLabel">Kasi:</label></th>
                        <th><input type="text" name="KASI" id="pInput" value="<?php 
                   echo $mainClass->user->kasi;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th> <label id="pLabel">Gender:</label></th>
                        <th> <input type="text" name="GENDER" id="pInput" value="<?php 
                   if($mainClass->user->gender == 'm'){
                       echo 'Male';
                   }elseif($mainClass->user->gender == 'f'){
                       echo 'Female';
                   }else{
                       echo 'Other';
                   }
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Address:</label></th>
                        <th><input type="text" name="ADDRESS" id="pInput" value="<?php 
                   echo $mainClass->user->address;
                   ?>"></th>
                    </tr>
                    <tr>
                        <th><label id="pLabel">Age:</label></th>
                        <th><input type="text" name="AGE" id="pInput" value="<?php 
                   echo $mainClass->user->age;
                   ?>"></th>
                    </tr>
                     <tr>
                        <th><label id="pLabel">Postal Code:</label></th>
                        <th><input type="text" name="POSTAL_CODE" id="pInput" value="<?php 
                   echo $mainClass->user->postalCode;
                   ?>"></th>
                    </tr>
                   </table>
                  </div>
            <div id="btns">
           <button type="submit" name="DONE_EDITING">Done</button><br/>
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