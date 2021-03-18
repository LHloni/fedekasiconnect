<?php
   require "Main.php";

    $mainClass = new page;
    $mainClass->post->filter();
    $arrOfInfo = $mainClass->newsFeedPage();
    $mainClass->post->postNewsFeed($mainClass->user->userID);
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
               $mainClass->post_div('Any Important News You would like to share today?','homepage');    
            ?>
		 
		 </div>
       
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5"
           id="news_div">
          
            <?php
             
               rsort($arrOfInfo);
                 foreach($arrOfInfo as $x){
                 echo '<form>';

             echo '<div id="container">' ; 
                 echo '<div id="head">'; 
                  echo '<h2>'.$mainClass->getUser($x['USER_ID'])->name.' '.$mainClass->getUser($x['USER_ID'])->surname.'</h2>'; 
                     
                     
                     echo '<div class="row">';
                    echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';  
                            if(!empty($x['PICTURE'])){
                                echo '<img id="cimg" src="data:image;base64,'.$x['PICTURE'].'"/>';
                            }
                          echo '</div>';
               echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                            echo '<p id="cp">'.$x['DESCRIPTION'].'</p>';  
                              echo '</div>';
                     echo '</div>';
        echo '</div>';  
                     
                     /*buttons*/
        echo '<div id="btns">';  
                   
        echo '<button onclick="important('.$x['USER_ID'].','.$x['ID'].','.$mainClass->user->userID.');" type="button" name="impt">';  
        echo '<span id="like" class="'.$x['ID']."like1".'">'.$x['IMPORTANT'].'</span>'; 
        echo 'Important</button>';      
                     
        echo '<button onclick="not_important('.$x['USER_ID'].','.$x['ID'].','.$mainClass->user->userID.');" type="button" name="ntimpt">';
        echo '<span id="like" class="'.$x['ID']."like2".'">'.$x['NOT_IMPORTANT'].'</span>'; 
        echo 'Not Important</button>'; 
                     
                         
        echo '<button type="button"   
        onclick="showSharePost('.$x['ID'].')">';
        echo 'Share to </button>'; 
                     
                     
        echo ' <button onclick="comment('.$x['USER_ID'].','.$x['ID'].');"  type="button" name="cmmt">';  
        echo '<span id="like2">'.$x['NUM_OF_COMMENTS'].'</span>'; 
         echo 'Comment</button>';
                     
                   
        echo '<input type="text" id="NUMBERPHONEorEMAIL" class="SHARE_DIV'.$x['ID'].'"  name="NUMBERPHONEorEMAIL" placeholder="  No. or Email"/>';
        echo '<button type="button" id="SHARE_BTN" class="SHARE_DIV'.$x['ID'].'" onclick="sharePost('.$x['ID'].','.$mainClass->user->userID.');" name="share"><i class="fa fa-share"></i></button>'; 
                     
                      
        echo '</div>';  
        echo '</div>';
                     echo '</form>';
                 }
             ?>
        </div>
        
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
           
       <?php
                  $mainClass->filterTabForNewsFeed('homepage'); 
                  $mainClass->filterTabForPoroduct('homepage');   
                  $mainClass->filterTabForService('homepage');
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
         
          function showSharePost(divShareId){
            
            var xShare = "."+"SHARE_DIV"+divShareId;
            $(xShare).show();
        }
          
        function important(idOfWhoPosted,idOfPost,idOfUser){
           var refId1 = "."+idOfPost+"like1";
            var refId2 = "."+idOfPost+"like2";
              $.post("ajaxGuy.php",
                     {
                  impt:'set1',
                  IOU:idOfUser,
                  IOWP:idOfWhoPosted,
                  IOP:idOfPost
              },
                    function(data,status){
                  var arr = $.parseJSON(data);
                   
                  $(refId1).text(arr['one']);
                  $(refId2).text(arr['two']);
             
              });
          }
          
        function not_important(idOfWhoPosted,idOfPost,idOfUser){
            var refId1 = "."+idOfPost+"like1";
            var refId2 = "."+idOfPost+"like2";
                $.post("ajaxGuy.php",
                     {
                    ntimpt:'set2',
                    IOU:idOfUser,
                    IOWP:idOfWhoPosted,
                    IOP:idOfPost
                },
                    function(data,status){
                 var arr = $.parseJSON(data);
                        $(refId2).text(arr['one']);
                      $(refId1).text(arr['two']);
                    
              });
          }
          
        function comment(idOfWhoPosted,idOfPost){
             $.post("ajaxGuy.php",
                     {
                    cmmt:'set3',
                    IOWP:idOfWhoPosted,
                    ID_POST:idOfPost
                },
                    function(data,status){
                 window.location =  'comment.php';
                    
              });
        }
    
        function sharePost(idOfPost,idOfUser){
            //get id of post via idOfDiv
           var tempIdVar = ".SHARE_DIV"+idOfPost; 
            var numberOrEmail = $(tempIdVar).val();
           
              $.post("helperClasses/AjaxGuy/shareTo.php",
                     {
                    share:'set8',
                   IOU:idOfUser,
                    ID_POST:idOfPost,
                  NUMBERPHONEorEMAIL:numberOrEmail
                },
                    function(data,status){
                    
            $(tempIdVar).hide();
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
           var idOfUser = <?php echo $mainClass->user->userID; ?>;
              $.post("helperClasses/AjaxGuy/logout.php",
                     {
                    logout:'set5',
                  IOU:idOfUser
                },
                    function(data,status){
                window.location = "login.php";  
              });
        });
    </script>
    
</html>