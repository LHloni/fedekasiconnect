<?php
   require "Main.php";

    $mainClass = new page;

    $mainClass->post->filter();

    $mainClass->post->editThePost();
    $arrOfPosts = $mainClass->myWall($mainClass->user->userID);

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
       
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5"
           id="news_div">
           
                   <div id="edit_div">
           <form action="myposts.php" method="post" enctype="multipart/form-data">
               
               <div id="head"><h2>Edit Post</h2>
                
                 <table id="table1">    
                    <tr>
                        <th><label id="labels" for="DESCRIPTION">Description/post:</label></th>
                        <th><textarea id="txta" rows="3" name="DESCRIPTION"></textarea></th>
                    </tr>
                    <tr>
                        <th><label id="labels" for="PRICE">Price:</label></th>
                        <th><input id="inpt" class="price" name="PRICE" type="text"/></th>
                    </tr>
                    <tr>
                        <th> <label id="labels" for="LOCATION">Location:</label></th>
                        <th><input id="inpt" class="location" name="LOCATION" type="text"></th>
                    </tr>
                   <tr>
                    <th><label id="labels" >Upload Image:</label></th>
                    <th><input type="file" class="picture" name="UPLOAD_IMAGE" id="upload"/></th>
                </tr>
                <tr>
                    <th><label id="labels">Upload Video:</label></th>
                    <th><input type="file" name="UPLOAD_VIDEO" id="upload"/></th>
                </tr> 
                   <tr>
                       <input type="text" id="idOfPost" name="IOP">
                   </tr>
                    <tr>
                       <input type="text" id="category" name="CATEGORY">
                   </tr>
                    
                </table>    
              
               </div>
            <div id="btns" >
            <button type="submit" id="update" name="UPDATE_POST">Update</button>  
        </div>
               
           </form>
        </div>
                   
           <?php
              rsort($arrOfPosts);
             foreach($arrOfPosts as $x){
                if($x['CATEGORY'] == 'newsfeed'){
                    $arrOfInfo = $mainClass->post->getPost($x['ID']);
                    
                    $mainClass->post->newsFeedTemplate($mainClass,$arrOfInfo);
                }
                if($x['CATEGORY'] == 'product'){
                    $arrOfInfo = $mainClass->post->getPost($x['ID']);
                    
                    $mainClass->post->productTemplate($mainClass,$arrOfInfo);
                }
                if($x['CATEGORY'] == 'services'){
                    $arrOfInfo = $mainClass->post->getPost($x['ID']);
                    
                    $mainClass->post->serviceTemplate($mainClass,$arrOfInfo);
                }
            }
             
             ?>
      
        </div>
        
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-2"
           id="notification_div">
      <?php
                  $mainClass->filterTabForNewsFeed('mypost'); 
                  $mainClass->filterTabForPoroduct('mypost');   
                  $mainClass->filterTabForService('mypost');
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
            $('#edit_div').hide();
            
            $('#update').click(function(){
                $('#edit_div').click();
            });
        });  
          
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
              //    var arr = data.split(" ",2);
                  //alert(arr['one']);
                   
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
          
        function editPost(idOfWhoPosted,idOfPost){
           
            $('#edit_div').show();
            
              $.post("ajaxGuy.php",
                     {
                    edit:'set6',
                    IOP:idOfPost
                },
                    function(data,status){
                  
                 var arr = $.parseJSON(data);
                  $('#txta').val(arr['DESCRIPTION']);
                $('.price').val(arr['PRICE']);
                 $('.location').val(arr['LOCATION']);
               $('#category').val(arr['CATEGORY']);
                 
                  $('#idOfPost').val(idOfPost);
                    
              });
        
        }
          
        function deletePost(idOfWhoPosted,idOfPost){
                $.post("ajaxGuy.php",
                     {
                    del:'set7',
                    IOP:idOfPost
                },
                    function(data,status){       
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