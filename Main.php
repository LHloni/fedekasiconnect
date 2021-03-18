<?php

    require "helperClasses/postClass.php";

    require "helperClasses/chatsClass.php";

    require "helperClasses/securityClass.php";

    require "helperClasses/helperClass.php";

    require "helperClasses/userClass.php";

    class page extends security{
        
        public $user;
        public $post;
        public $chats;
        public $theHelperClass;
        private $connection;
        
        public function __construct(){
             $this->connectToServer();
            $this->initClass();
            $this->startSession();
            
             //get user
           $this->initializeUser();
         }
        
        private function initializeUser(){
             if(!empty($_SESSION['USER_ID'])){
                $userID = $_SESSION['USER_ID'];
               $this->user->init($userID);
            }
        }
        
        public function getUser($x){
            if(!empty($x)){
                $tempClass = new user;
                $tempClass->init($x); 
                return $tempClass;
            }
        }
        
        private function initClass(){
            $this->user = new user;
            $this->post = new post;
            $this->chats = new chats;
            $this->theHelperClass = new theHelperClass;
        }
        
        private function connectToServer(){
         $this->connection = mysqli_connect('localhost','root','');

            mysqli_select_db($this->connection,'fedekasiconnect');
        }

        private function startSession(){
            session_start();
        }
		
        private function clearClasses(){
             $this->user = null;
            $this->post = null;
            $this->chats = null;
            $this->setTheHelperClass = null;
        }
		
        public function userisloginOrNot(){
           
            if(!empty($_SESSION['USER_ID'])){
                   if($_SESSION['USER_ID'] != "" && $_SESSION['USER_ID'] != 0 && $_SESSION['USER_ID'] != null){
               $this->user->userID = $_SESSION['USER_ID']; 
                return true;
            }else{
                return false;
            }
            }else{
                  return false;
            }
         
            
        }
        public function register(){
            //populate array with errors
            $errorMessagesAndValues = array();
    
            $addUser = true;
            
            if(isset($_POST['SUBMIT_REGISTER'])){
                if(empty($_POST['NAME'])){
                    $errorMessagesAndValues[0] = "enter name";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[10] = $_POST['NAME'];
                }
                if(empty($_POST['SURNAME'])){
                    $errorMessagesAndValues[1] = "enter surname";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[11] = $_POST['SURNAME'];
                }
                if(empty($_POST['EMAIL'])){
                    $errorMessagesAndValues[2] = "enter email";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[12] = $_POST['EMAIL'];
                }
                if(empty($_POST['KASI'])){
                    $errorMessagesAndValues[3] = "enter kasi";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[13] = $_POST['KASI'];
                }
                if(empty($_POST['NUMBERPHONE'])){
                    $errorMessagesAndValues[4] = "enter number-phone";
                    $addUser = false;
                }
                else{
                    $errorMessagesAndValues[14] = $_POST['NUMBERPHONE'];
                }
                if(empty($_POST['GENDER'])){
                    $errorMessagesAndValues[5] = "enter gender";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[15] = $_POST['GENDER'];
                }
                if(empty($_POST['PROVINCE'])){
                    $errorMessagesAndValues[6] = "enter province";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[16] = $_POST['PROVINCE'];
                }
                if(empty($_POST['AGE'])){
                    $errorMessagesAndValues[7] = "enter age";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[17] = $_POST['AGE'];
                }
                if(empty($_POST['ADDRESS'])){
                    $errorMessagesAndValues[8] = "enter address";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[18] = $_POST['ADDRESS'];
                }
                if(empty($_POST['POSTALCODE'])){
                    $errorMessagesAndValues[9] = "enter postal-code";
                    $addUser = false;
                }else{
                    $errorMessagesAndValues[19] = $_POST['POSTALCODE'];
                }
   
                //add user if all fields aint empty
                if($addUser){
                    
                    $name = htmlentities($_POST['NAME']);
                    $surname =htmlentities($_POST['SURNAME']);
                    $email =htmlentities($_POST['EMAIL']);
                    $kasi = htmlentities($_POST['KASI']);
                    $numberphone =htmlentities($_POST['NUMBERPHONE']);
                    $gender = htmlentities($_POST['GENDER']);
                    $province =htmlentities($_POST['PROVINCE']);
                    $age =htmlentities($_POST['AGE']);
                    $address =htmlentities($_POST['ADDRESS']);
                    $postalcode =htmlentities($_POST['POSTALCODE']);
                    
                    //send random password to user who just registered
                    $password = $this->theHelperClass->randomPassword();
                    
                    $msg = $name." ".$surname." your password is ".$password;
                    $headers = "From: http://fedekasiconnect.000webhostapp.com";
                    mail($email,"My Subject",$msg,$headers);
                    
                    $sql = "INSERT INTO `user`(`ID`, `NAME`, `SURNAME`, `EMAIL`, `KASI`, `NUMBERPHONE`, `GENDER`, `PROVINCE`, `AGE`, `ADDRESS`, `POSTALCODE`,`PASSWORD`,`MYFRIENDSIDS`, `POSTIDYOUCANVIEW`, `NOTIFICATIONIDS`) VALUES (null,'$name','$surname','$email','$kasi','$numberphone','$gender','$province','$age','$address','$postalcode','$password','','','')";
                    
                    mysqli_query($this->connection,$sql) or die("couldnt send query");
                  
                    return false;
                }else{
					if(sizeof($errorMessagesAndValues) < 9){
						return true;
					}else{
						return $errorMessagesAndValues;
					}
                    
                }
            }
        }
        public function login(){
            if(isset($_POST['SUBMIT_LOGIN'])){
                $errorMessages = array();
                $loginUser = true;
              if(empty($_POST['EMAIL_NUMBER'])){
                  $errorMessages[0] = "enter email/number";
                  $loginUser = false;
              }
              if(empty($_POST['PASSWORD'])){
                  $errorMessages[1] = "enter password";
                  $loginUser = false;
              } 
              if($loginUser){
                  //when user enters a number the first zero gets cut of fix that
                  $email_number = $_POST['EMAIL_NUMBER'];
                  $password = $_POST['PASSWORD'];
                  $sql = "SELECT * FROM `user` WHERE `EMAIL` LIKE '$email_number' AND `PASSWORD` LIKE '$password'";
                  $sql2 = "SELECT * FROM `user` WHERE `NUMBERPHONE` LIKE '$email_number' AND `PASSWORD` LIKE '$password'";
                  
                  $result1 = mysqli_query($this->connection,$sql) or die("couldnt send query line 1269");
                 $result2 =  mysqli_query($this->connection,$sql2) or die("couldnt send query 1270");
                  
                  if(mysqli_num_rows($result1) == 1 ){
                     //login user
                      $assArr = mysqli_fetch_assoc($result1);
                     // session_start();
                      $_SESSION['USER_ID'] = $assArr['ID'];
                      $this->user->init($assArr['ID']);
                      //redirect user
                      header('Location: homepage.php');
                      
                  }elseif(mysqli_num_rows($result2) == 1){
                     //login user
                     $assArr =  mysqli_fetch_assoc($result2);
                      $_SESSION['USER_ID'] = $assArr['ID'];
                      $this->user->init($assArr['ID']);
                          //redirect user
                      header('Location: homepage.php');
                  }else{
                      $errorMessages[2] = "invalid email/password";
                     return $errorMessages;
                  }
                  
              }else{
                  return $errorMessages;
              }
                
            }
            
        }
        
        public function headerIncludes(){
            echo '<meta charset="UTF-8">
                <title>HomePage</title>
                <link rel="stylesheet" href="css/main.css"/>
                <link rel="stylesheet" href="css/main2.css"/>
                <link rel="stylesheet" href="css/index.css"/>
                <link rel="stylesheet" href="css/font-awesome.css"/>
                <link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">';
        }
        public function head(){
            
            echo '<header class="row center-xs center-sm center-md center-lg">
           <h1 class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><span id="hd">FKC </span> Fede Kasi Connect</h1>
           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2">

            <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i></button>
            <ul class="dropdown-menu" labelledby="dropdownMenu1" id="listMenu">
			<li><a href="">Profile</a></li>
            <li><a href="">Search Filters</a></li>
                <li><a href="myposts.php">My Posts</a></li>
                <li><a id="logout">Logout</a></li>
            </ul>
            </div>

           </div>
        </header>';
            
        }
        public function navigation(){
            echo '<nav class="row center-xs center-sm center-md center-lg">

            <ul class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <li><a href="homepage.php">Home</a></li>
               <li><a href="product.php">Products</a></li>
               <li><a href="service.php">Services</a></li>
               <li><a href="notification.php">Notification</a></li>
               <li><a href="message.php">Messages</a></li>
               <li><a href="about.php">About</a></li>
            </ul>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <input type="text" placeholder="Search">
            </div>

        </nav>';
        }
        public function newsFeedPage(){
            if($this->userisloginOrNot()){
                 return $this->post->newsFeed($this->user->userID);
            }else{
                header('Location: login.php');  
            }
           
        }
        public function productPage(){
              if($this->userisloginOrNot()){
                 return $this->post->products($this->user->userID);
            }else{
                header('Location: login.php');  
            }
        }        
        public function servicesPage(){
              if($this->userisloginOrNot()){
                 return $this->post->services($this->user->userID);
            }else{
                header('Location: login.php');  
            }
        }
        public function profilePage(){
            $pp = "";
              if(!empty($this->user->profilePic)){
                $pp =  "profile_pic/".$this->user->profilePic;
                }else{
                $pp =  "profile_pic/defaultpp.png";
                }
            
            $gender = "";
             if($this->user->gender == 'm'){
                       $gender = "Male";
                   }elseif($this->user->gender == 'f'){
                       $gender = "Female";
                   }else{
                       $gender = "Other";
                   }
            //just take user information and post it on the page
            echo ' <div id="head">
                <h2>Profile</h2>
               <img src="'.$pp.'"/>
               <br/>';
               echo '<label id="editment1">'.$this->user->name." ".$this->user->surname.
               '</label><br id="editment1"/>';
              echo '<label id="editment1">'.$this->user->numberPhone.'</label><br id="editment1"/>';
              echo '<label id="editment1">'.$this->user->email.'</label><br id="editment1"/>';
              echo '<label id="editment1">'.$this->user->province.'</label><br id="editment1"/>';
              echo '<label id="editment1">'.$this->user->kasi.'</label><br id="editment1"/>';
              echo' <label  id="editment1">'.$gender.'</label><br id="editment1"/>';
             echo  '<label  id="editment1">'.$this->user->address.'</label><br id="editment1"/>';
             echo  '<label id="editment1">'.$this->user->age.'</label><br id="editment1"/>';
               echo  '</div><div id="btns">
               <button onclick="document.location = \'editprofile.php\'" >Edit Profile</button><br/>
              </div>';
              
        }
        public function notificationPage(){ 
              if(!empty($this->user->userID)){
            $sql = "SELECT `NOTIFICATIONIDS` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfNumbers = explode(",",$assArr['NOTIFICATIONIDS']);
            
        foreach($arrOfNumbers as $x){
           $sql = "SELECT * FROM `posts` WHERE `ID` LIKE '$x'";

          $results = mysqli_query($this->connection,$sql) or die("couldnt send query 1418");

          $assArr = mysqli_fetch_assoc($results);

           //post to html the information
            if(!empty($assArr)){
                if($assArr['CATEGORY'] == "newsfeed"){
                    //create panel for this notification
                    echo $assArr['CATEGORY'];
                }
                if($assArr['CATEGORY'] == "product"){
                    //create panel for this notification
                    echo $assArr['CATEGORY'];
                }
                if($assArr['CATEGORY'] == "services"){
                    //create panel for this notification
                    echo $assArr['CATEGORY'];
                }
            }
           
            }  
          }
        }
        public function messagePage(){
             if($this->userisloginOrNot()){
                 return $this->chats->messages($this->user->userID);
            }else{
                header('Location: login.php');  
            }
            
        }
        public function aboutPage(){
             if($this->userisloginOrNot()){
               
            }else{
                header('Location: login.php');  
            }
        }
        public function post_div($header,$page){
            echo '<form action="'.$page.'.php" method="post" enctype="multipart/form-data">
               
                <div id="head"><h2 id="doit">'.$header.'</h2>
                
                <table id="table1">
                <tr>
                    <th> <textarea id="txta" rows="3"  name="DESCRIPTION" placeholder="Description/post"></textarea></th>
                </tr>
                <tr>
                    <th><input id="inpt" type="text" name="LOCATION" placeholder="Location"></th>
                </tr>
                <tr>
                    <th><i id="camera" class="fa fa-camera"></i><input type="file" name="UPLOAD_IMAGE" id="upload"/></th>
                </tr>
                <tr>
                    <th><i id="camera" class="fa fa-video-camera"></i><input type="file" name="UPLOAD_VIDEO" id="upload"/></th>
                </tr>    
                    
                </table>
            
               </div>
            <div id="btns" >
            <button type="submit" name="SUBMIT_POST">Post</button>  
        </div>
               
           </form>';
        }
        public function filterTabForNewsFeed($page){
            $allPost = "";
            $kasiPost = "";
            if($this->post->allPosts){
                 $allPost =  "checked";
            }elseif($this->post->kasiPost){
               $kasiPost = "checked";
           }
            
            echo ' <form action="'.$page.'.php" method="post">
          <div id="notifi">
               <div id="head"><h2 id="notifi_h2">Posts Filters</h2>
               
                <table>
                <tr>
                    <th><label id="notifi_label">View all post</label>
                    </th>
                    <th><input type="radio" name="NEWSFEED" value="ALL_POST" id="notifi_input" '.$allPost.'/>
                    </th>
                </tr>
                <tr>
                    <th><label id="notifi_label">View post from my kasi</label></th>
                    <th><input type="radio" name="NEWSFEED" value="KASI_POST" id="notifi_input" '.$kasiPost.' /></th>
                </tr>
            
            </table>
            </div>
            <div id="btns">
            <button type="submit" id="notifi_button" name="UPDATE_POST_FILTER">Update</button>
       
        </div>
          </div>
          </form>';
            
            
        }
        public function filterTabForPoroduct($page){
            $allPost = "";
            $kasiPost = "";
            if($this->post->allProducts){
                 $allPost =  "checked";
            }elseif($this->post->kasiProducts){
               $kasiPost = "checked";
           }
            
            echo '<form action="'.$page.'.php" method="post">
          <div id="notifi" class="notifi_div">
               <div id="head"><h2 id="notifi_h2">Product Filters</h2>
               
                <table>
                <tr>
                    <th><label id="notifi_label">View all products</label>
                    </th>
                    <th><input type="radio" name="PRODUCT" value="ALL_PRODUCTS" id="notifi_input" '.$allPost.'/>
                    </th>
                </tr>
                <tr>
                    <th><label id="notifi_label">View products from my kasi</label></th>
                    <th><input type="radio" name="PRODUCT" value="KASI_PRODUCTS" id="notifi_input" '.$kasiPost.'/></th>
                </tr>
            </table>
               
            </div>
            <div id="btns">
            <button type="submit" id="notifi_button" name="UPDATE_PRODUCTS_FILTER">Update</button>
       
        </div>
          </div>
          </form>';
            
            
        }
        public function filterTabForService($page){
            $allPost = "";
            $kasiPost = "";
            if($this->post->allServices){
                 $allPost =  "checked";
            }elseif($this->post->kasiServices){
               $kasiPost = "checked";
           }
            
            echo ' <form action="'.$page.'.php" method="post">
          <div id="notifi" class="notifi_div">
               <div id="head"><h2 id="notifi_h2">Services Filters</h2>
               
                <table>
                <tr>
                    <th><label id="notifi_label">View all services</label>
                    </th>
                    <th><input type="radio" name="SERVICE" value="ALL_SERVICES" id="notifi_input" '.$allPost.'/>
                    </th>
                </tr>
                <tr>
                    <th><label id="notifi_label">View services from my kasi</label></th>
                    <th><input type="radio" name="SERVICE" value="KASI_SERVICES" id="notifi_input" '.$kasiPost.'/></th>
                </tr>
            </table>
               
            </div>
            <div id="btns">
            <button type="submit" id="notifi_button" name="UPDATE_SERVICES_FILTER">Update</button>
       
        </div>
          </div>
          </form>
      ';
            
            
        }

        public function editProfile($userId){
            if($this->userisloginOrNot()){
                if(isset($_POST['DONE_EDITING'])){
                    
                    $sql1 = "SELECT `NAME`, `SURNAME`, `EMAIL`, `KASI`, `NUMBERPHONE`, `GENDER`, `PROVINCE`, `AGE`, `ADDRESS`, `POSTALCODE`, `PROFILEPIC` FROM `user` WHERE `ID` LIKE '$userId'";
                    
                    $results = mysqli_query($this->connection,$sql1) or die("couldnt send query 1463");
                    
                    $assArr = mysqli_fetch_assoc($results);
                    
                    $image = '';
                    $name = '';
                    $surname = '';
                    $numberPhone = '';
                    $email = '';
                    $province = '';
                    $kasi = '';
                    $gender = '';
                    $address = '';
                    $age = '';
                    $postalCode = '';
          
                    if(!empty($_FILES['PROFILEPIC'])){
                          $file = $_FILES['PROFILEPIC'];
                        $fileName = $file['name'];
                        $fileTmpName = $file['tmp_name'];
                        $fileSize = $file['size'];
                        $fileError = $file['error'];
                        $tempVar = explode('.',$fileName);
                       $filExt = strtolower(end($tempVar));
                        
                        if($fileError == 0 && $fileSize <= 500000 && $fileSize > 0){
                            $newName = uniqid('',true).'.'.$filExt;
                            $destination = 'profile_pic/'.$newName;
                            move_uploaded_file($fileTmpName,$destination) or die("couldnt upload file 1491");

                             $image = $newName;
                        }else{
                       $image = $assArr['PROFILEPIC'];
                    }
                    }
                     if(!empty($_POST['NAME'])){
                        $name = $_POST['NAME'];
                    
                     }else{
                           $name = $assArr['NAME'];
                     }
                     if(!empty($_POST['SURNAME'])){
                        $surname = $_POST['SURNAME'];
                    
                     
                     }else{
                           $surname = $assArr['SURNAME'];
                     }
                     if(!empty($_POST['NUMBERPHONE'])){
                         $numberPhone = $_POST['NUMBERPHONE'];
                         
                    
                     }else{
                           $numberPhone = $assArr['NUMBERPHONE'];
                     }
                     if(!empty($_POST['EMAIL'])){
                        $email = $_POST['EMAIL'];
                    
                     }else{
                           $email = $assArr['EMAIL'];
                     }
                     if(!empty($_POST['PROVINCE'])){
                        $province = $_POST['PROVINCE'];
                    
                     }else{
                           $province = $assArr['PROVINCE'];
                     }
                     if(!empty($_POST['KASI'])){
                        $kasi = $_POST['KASI'];
                    }else{
                          $kasi = $assArr['KASI'];
                     }
                     if(!empty($_POST['GENDER'])){ 
                         if(strtolower($_POST['GENDER']) == 'male'){
                           $gender = 'm';  
                         }elseif(strtolower($_POST['GENDER']) == 'female'){
                             $gender = 'f';
                         }
                    }else{
                          $gender  = $assArr['GENDER'];
                     }
                     if(!empty($_POST['ADDRESS'])){
                        $address = $_POST['ADDRESS'];
                    }else{
                          $address  = $assArr['ADDRESS'];
                     }
                     if(!empty($_POST['AGE'])){
                        $age = $_POST['AGE'];
                    }else{
                           $age = $assArr['AGE'];
                     }
                     if(!empty($_POST['POSTAL_CODE'])){
                        $postalCode = $_POST['POSTAL_CODE'];
                    }else{
                          $postalCode  = $assArr['POSTALCODE'];
                     }
                    
                    
                    $sql = "UPDATE `user` SET `NAME`='$name',`SURNAME`='$surname',`EMAIL`='$email',`KASI`='$kasi',`NUMBERPHONE`='$numberPhone',`GENDER`='$gender',`PROVINCE`='$province',`AGE`='$age',`ADDRESS`='$address',`POSTALCODE`='$postalCode',`PROFILEPIC`='$image' WHERE `ID` LIKE '$userId'";
                    
                    
                    mysqli_query($this->connection,$sql) or die("couldnt send query 1564");
                    
                    header("Location:homepage.php");
                    
                }
            }else{
                header('Location: login.php');  
            }
        }
        public function commentPage($idOfWhoPosted,$postId){
            
            $sql = "SELECT `USER_ID`, `CATEGORY`, `NUM_OF_COMMENTS`, `COMMENT` FROM `posts` WHERE `ID` LIKE '$postId'";

            $results = mysqli_query($this->connection,$sql);

            $assArr = mysqli_fetch_assoc($results);

            $arrOfComments = explode(",",$assArr['COMMENT']);
            
            //array of results
            $i = 0;
            $arrOfResults = array();
            
            foreach($arrOfComments as $x){
                if(!empty($x)){
                       $arrIdAndComment = explode(".",$x);
              //remove  this ->" before in and after the string/comment
                $sql1 = "SELECT `NAME`, `SURNAME` FROM `user` WHERE `ID` LIKE '$arrIdAndComment[0]'";
                
                $results = mysqli_query($this->connection,$sql1);

                $assArr2 = mysqli_fetch_assoc($results);
                $name = $assArr2['NAME'];
                $surname = $assArr2['SURNAME'];
                $comment = $arrIdAndComment[1];
                
                $arrOfResults[$i] = $name.','.$surname.','.$comment;
                $i++;
                }
              
            } 
        
            return $arrOfResults;
        
        }
        public function comment($postId){
                 
            //if the nigga wanna comment
            if(isset($_POST['SUBMIT_COMMENT'])){
                
              if(!empty($_POST['COMMENT'])){
                  //notifi the user who posted that you commenting on thier post
                  
                  $sql2 = "SELECT `USER_ID` FROM `posts` WHERE `ID` LIKE '$postId'";
                  

                $results2 = mysqli_query($this->connection,$sql2);
                  
                  $assArr2 = mysqli_fetch_assoc($results2);
                  
                  
                  $userIdToNotifi = $assArr2['USER_ID'];
                  
                  $this->notifiUser($userIdToNotifi,$postId,"c");
                  
                  //when done the update comments
                  
                 $comment = $_POST['COMMENT']; 
                   $sql1 = "SELECT `COMMENT`,`NUM_OF_COMMENTS` FROM `posts` WHERE `ID` LIKE '$postId'";
                  

                $results = mysqli_query($this->connection,$sql1);

                $assArr = mysqli_fetch_assoc($results);
                  
                  $userComment = $this->user->userID.'.'.'"'.$comment.'"'.',';
                  
                  //update number of comments
                  $newNum = intval($assArr['NUM_OF_COMMENTS']) + 1;
                  $newComment = $assArr['COMMENT'].$userComment;
                  
                  $sql = "UPDATE `posts` SET `COMMENT`='$newComment',`NUM_OF_COMMENTS`='$newNum' WHERE `ID` LIKE '$postId'";
                  
                  mysqli_query($this->connection,$sql) or die("couldnt send query 1647");
                  
                  //empty out
                  header('Location: homepage.php');
              }  
            }
            
        }
        public function myWall(){
              if($this->userisloginOrNot()){
                 return $this->post->myWall($this->user->userID);
            }else{
                header('Location: login.php');  
            }
        }
        public function notifiUser($userIdToNotifi,$postId,$commentOrShare){
            	
                    $userID = $this->user->userID;
           // post,who,what
            
                    $sql1 = "SELECT `NOTIFICATIONIDS`FROM `user` WHERE `ID` LIKE '$userIdToNotifi'";
            
                    $results = mysqli_query($this->connection,$sql1) or die("couldnt send query 1669");
            
                    $assArr = mysqli_fetch_assoc($results);
                    
                    $notifiString  = $assArr['NOTIFICATIONIDS'];
                   
                    if(strtolower($commentOrShare) == "c"){
                        if(empty($notifiString)){
                            $newNotification = $postId.".".$userID."."."c";
                        }else{
                            $newNotification = $notifiString.",".$postId.".".$userID."."."c";
                        }
                        
                        
                    }elseif(strtolower($commentOrShare) == "s"){
                        if(empty($notifiString)){
                            $newNotification = $postId.".".$userID."."."s";
                        }else{
                            $newNotification = $notifiString.",".$postId.".".$userID."."."s";
                        }
                        
                    }
            
                    
                    $sql = "UPDATE `user` SET `NOTIFICATIONIDS`='$newNotification' WHERE `ID` LIKE '$userIdToNotifi'";
            
                    mysqli_query($this->connection,$sql) or die("couldnt send query 1695");
                    
        }
        public function getNotifications($userId){
            
            if($this->userisloginOrNot()){
                  // post,who,what
            
            $sql = "SELECT `NOTIFICATIONIDS` FROM `user` WHERE `ID` LIKE '$userId' ";
            
            $results = mysqli_query($this->connection,$sql) or die("couldnt send query 1705");
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrWithInfo = array();
            $i = 0;
            $tempArr = explode(",",$assArr['NOTIFICATIONIDS']);
            
            if(!empty($tempArr)){
                   foreach($tempArr as $x){
                
                $y = explode(".",$x);
                if(empty($y[0]) || empty($y[1]) || empty($y[2])){
                     
                }else{
                    $postId = $y[0];
                    $idOfUser = $y[1];
                    $whatHappened = $y[2];
                    
                       $sql1 = "SELECT `NAME`, `SURNAME` FROM `user` WHERE `ID` LIKE '$idOfUser'";
            
                $results1 = mysqli_query($this->connection,$sql1) or die("couldnt send query");
            
                $assArr1 = mysqli_fetch_assoc($results1);
                
                $whoComOrShare = $assArr1['NAME']." ".$assArr1['SURNAME'];
                
                $result = array("POST_ID"=>$postId,
                                "WHO_COS"=>$whoComOrShare,
                                "WHAT_HAPPENED"=>$whatHappened
                               );
                
                $arrWithInfo[$i] = $result;
                $i++;
                    
                }
        
                   }
                
                return $arrWithInfo;
                
            }else{
                return null;
            }
            }else{
                header('Location: login.php');  
            }
         
        }
        public function footer(){
            echo '<footer class="row center-xm center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 ">
             <h4 id="footer_h4">Fede Kasi Connect @2018 </h4>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
               <i class="fa fa-phone-square" id="footer_i"></i><label id="footer_label">+27 644 701 482</label><br/>
                <i class="fa fa-envelope-o" id="footer_i"></i><label id="footer_label">lmphuthi09@gmail.com</label>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <label id="footer_label">About the company</label><br>
                    <p id="footer_p">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate soluta, animi, minus accusamus ducimus eum velit ex aliquam. Dolorem fugit labore eligendi sint beatae at maxime, corrupti atque consequuntur adipisci.</p>
            </div>
            
        </footer>';
        }
        
        public function __destruct(){
               $this->clearClasses();
        }

    }

?>