<?php

    class post{
        
    private $connection;
        
    public $allPosts;
    public $kasiPost;
    public $postFromI2N;
    public $postFromI2I;
        
    public $allProducts;
    public $kasiProducts;
        
    public $allServices;
    public $kasiServices;
    
        
    public function __construct(){
          $this->connectToServer();
          $this->intiFilters();
     }
        
    private function connectToServer(){
         $this->connection = mysqli_connect('localhost','root','');

            mysqli_select_db($this->connection,'fedekasiconnect');
        }
     
    private function intiFilters(){
        $this->allPosts = true;
         $this->kasiPost = false;
         $this->postFromI2N = false;
         $this->postFromI2I = false;
        
         $this->allProducts = true;
         $this->kasiProducts = false;
        
         $this->allServices = true;
         $this->kasiServices = false;
    }
        
    public function newsFeed($userId){
        if(!empty($userId)){
            $sql = "SELECT `POSTIDYOUCANVIEW` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfNumbers = explode(",",$assArr['POSTIDYOUCANVIEW']);
            
            $arrWithListOfResults = array();
            $i = 0;
        foreach($arrOfNumbers as $x){
            
           $sql = "SELECT * FROM `posts` WHERE `CATEGORY` LIKE 'newsfeed' AND `ID` LIKE '$x'";

          $results = mysqli_query($this->connection,$sql) or die("couldnt send query");

          $assArr = mysqli_fetch_assoc($results);
            
           //post to html the information
            if(!empty($assArr)){
                
                if($this->allPosts){
                $arrWithListOfResults[$i] = $assArr;
                $i++;
            }
            if($this->kasiPost){
                    
            $sql = "SELECT `KASI` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr2 = mysqli_fetch_assoc($results);
                    
                    $kasi = $assArr2['KASI']; 
                    
                    if(strtolower($assArr['LOCATION']) == strtolower($kasi)){
                       $arrWithListOfResults[$i] = $assArr;
                        $i++; 
                    }
                }  
                
            }
            
        } 
            
            
            //posts u cn view
            $this->whoCanViewPost();
            //when done return
                 return $arrWithListOfResults;
            
        }else{
            return null;
        }
    }
    
    public function products($userId){
           if(!empty($userId)){
            $sql = "SELECT `POSTIDYOUCANVIEW` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfNumbers = explode(",",$assArr['POSTIDYOUCANVIEW']);
            $arrWithListOfResults = array();
            $i = 0;
        foreach($arrOfNumbers as $x){
           $sql = "SELECT * FROM `posts` WHERE `CATEGORY` LIKE 'product' AND `ID` LIKE '$x'";

          $results = mysqli_query($this->connection,$sql) or die("couldnt send query");

          $assArr = mysqli_fetch_assoc($results);

           //post to html the information
               if(!empty($assArr)){
                
            if($this->allProducts){
                $arrWithListOfResults[$i] = $assArr;
                $i++;
            }
                   
            if($this->kasiProducts){
                    
            $sql = "SELECT `KASI` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr2 = mysqli_fetch_assoc($results);
                    
                    $kasi = $assArr2['KASI']; 
                    
                    if(strtolower($assArr['LOCATION']) == strtolower($kasi)){
                       $arrWithListOfResults[$i] = $assArr;
                        $i++; 
                    }
                }
            }
            }
               //posts u cn view
            $this->whoCanViewPost();
                 //when done return
                 return $arrWithListOfResults;
        }else{
               return null;
        }
    }
        
    public function services($userId){
          if(!empty($userId)){
            $sql = "SELECT `POSTIDYOUCANVIEW` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfNumbers = explode(",",$assArr['POSTIDYOUCANVIEW']);
            
            
            $arrWithListOfResults = array();
            $i = 0;
        foreach($arrOfNumbers as $x){
           $sql = "SELECT * FROM `posts` WHERE `CATEGORY` LIKE 'services' AND `ID` LIKE '$x'";

          $results = mysqli_query($this->connection,$sql) or die("couldnt send query");

          $assArr = mysqli_fetch_assoc($results);

           //post to html the information
                if(!empty($assArr)){
                
            if($this->allServices){
                $arrWithListOfResults[$i] = $assArr;
                $i++;
            }
                   
            if($this->kasiServices){
                    
            $sql = "SELECT `KASI` FROM `user` WHERE `ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArr2 = mysqli_fetch_assoc($results);
                    
                    $kasi = $assArr2['KASI']; 
                    
                    if(strtolower($assArr['LOCATION']) == strtolower($kasi)){
                       $arrWithListOfResults[$i] = $assArr;
                        $i++; 
                    }
                }
            }
            }
              //posts u cn view
            $this->whoCanViewPost();
                //when done return
                 return $arrWithListOfResults;
          }else{
              return null;
          }
            
        }
        
    public function postNewsFeed($userId){
        if(isset($_POST['SUBMIT_POST'])){
            $requiredNum = 3;
            $description = "";
            $location = "";
            $category = "newsfeed";
            $image = "";
            if(empty($_POST['DESCRIPTION'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $description = $_POST['DESCRIPTION'];
            }
            if(isset($_POST['UPLOAD_IMAGE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                
                $file = $_FILES['UPLOAD_IMAGE'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
               $tempVar = explode('.',$fileName);
                $filExt = strtolower(end($tempVar));
                
                if($fileError == 0 && $fileSize <= 500000){
                  //  $newName = uniqid('',true).'.'.$filExt;
                  //  $destination = 'uploaded_images/'.$newName;
                 //   move_uploaded_file($fileTmpName,$destination) or die("couldnt upload file");
                 //    $image = $newName;
                    $image = file_get_contents($fileTmpName);
                    $image = base64_encode($image);
                }
            }
            if(empty($_POST['UPLOAD_VIDEO'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }
            if(empty($_POST['LOCATION'])){
                 $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $location = $_POST['LOCATION'];
            }    
            
            if($requiredNum >= 1){
                $sql = "INSERT INTO `posts`(`ID`, `USER_ID`, `DESCRIPTION`, `PICTURE`, `VIDEO`, `CATEGORY`, `PRICE`, `BOUGHT_BY`, `TRADES_WITH`, `WHO_APPLIED`, `WHO_REQUESTED`, `LOCATION`, `IMPORTANT`, `DO_ONCE_IMPT`, `NOT_IMPORTANT`, `DO_ONCE_NTIMPT`, `NUM_OF_COMMENTS`, `COMMENT`, `CURRENT_STATE`) VALUES (null,'$userId','$description','$image','','$category','','','','','','$location','','','','','','','')";
                
                mysqli_query($this->connection,$sql) or die("couldnt send query");
                
            }
        }
    }
        
    public function postProducts($userId){
                if(isset($_POST['SUBMIT_POST'])){
                    
            $requiredNum = 4;
            $description = "";
            $location = "";
            $currentState = "AVAILABLE";
            $category = "product";
            $price = 0;
            $image = "";
            if(empty($_POST['DESCRIPTION'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $description = $_POST['DESCRIPTION'];
            }
            if(isset($_POST['UPLOAD_IMAGE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $file = $_FILES['UPLOAD_IMAGE'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
               
                if($fileError == 0 && $fileSize <= 500000){
                  //  $destination = 'uploaded_images/'.$fileName;
                  //  move_uploaded_file($fileTmpName,$destination) or die("couldnt upload file 289");
                    
                    $image = file_get_contents($fileTmpName);
                    $image = base64_encode($image);
                }
            }
            if(empty($_POST['PRICE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $price = $_POST['PRICE'];
            }
            if(empty($_POST['UPLOAD_VIDEO'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }
            if(empty($_POST['LOCATION'])){
                
            }else{
                $location = $_POST['LOCATION'];
            }
            
            if($requiredNum >= 2){
               $sql = "INSERT INTO `posts`(`ID`, `USER_ID`, `DESCRIPTION`, `PICTURE`, `VIDEO`, `CATEGORY`, `PRICE`, `BOUGHT_BY`, `TRADES_WITH`, `WHO_APPLIED`, `WHO_REQUESTED`, `LOCATION`, `IMPORTANT`, `DO_ONCE_IMPT`, `NOT_IMPORTANT`, `DO_ONCE_NTIMPT`, `NUM_OF_COMMENTS`, `COMMENT`, `CURRENT_STATE`) VALUES (null,'$userId','$description','$image','','$category','$price','','','','','$location','','','','','','','$currentState')";
                
                mysqli_query($this->connection,$sql) or die("couldnt send query 313");
                
            }
        }
    }
        
    public function postServices($userId){
                if(isset($_POST['SUBMIT_POST'])){
            $requiredNum = 4;
            $description = "";
            $location = "";
            $currentState = "AVAILABLE";
            $category = "services";
            $price = "";
            $image = "";
            if(empty($_POST['DESCRIPTION'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $description = $_POST['DESCRIPTION'];
            }
            if(isset($_POST['UPLOAD_IMAGE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                 
                $file = $_FILES['UPLOAD_IMAGE'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
               
                if($fileError == 0 && $fileSize <= 500000){
                 //   $destination = 'uploaded_images/'.$fileName;
                 //   move_uploaded_file($fileTmpName,$destination) or die("couldnt upload file 347");
                 //    $image = $fileName;
                    $image = file_get_contents($fileTmpName);
                    $image = base64_encode($image);
                }
            }
            if(empty($_POST['PRICE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $price = $_POST['PRICE'];
            }
            if(empty($_POST['UPLOAD_VIDEO'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }
            if(empty($_POST['LOCATION'])){
                
            }else{
                $location = $_POST['LOCATION'];
            }
            
            if($requiredNum >= 2){
            
                  $sql = "INSERT INTO `posts`(`ID`, `USER_ID`, `DESCRIPTION`, `PICTURE`, `VIDEO`, `CATEGORY`, `PRICE`, `BOUGHT_BY`, `TRADES_WITH`, `WHO_APPLIED`, `WHO_REQUESTED`, `LOCATION`, `IMPORTANT`, `DO_ONCE_IMPT`, `NOT_IMPORTANT`, `DO_ONCE_NTIMPT`, `NUM_OF_COMMENTS`, `COMMENT`, `CURRENT_STATE`) VALUES (null,'$userId','$description','$image','','$category','$price','','','','','$location','','','','','','','$currentState')";
                
                mysqli_query($this->connection,$sql) or die("couldnt send query 376");
            }
        }
    }
        
    public function newsFeedFilter(){
        
        if(isset($_POST['UPDATE_POST_FILTER'])){
           
            if(isset($_POST['NEWSFEED']) && !empty($_POST['NEWSFEED'])){
                $choice = $_POST['NEWSFEED'];
                 
                if($choice == "KASI_POST"){
                    $this->allPosts = false;
                    $this->kasiPost = true;
                }elseif($choice == "ALL_POST"){
                    $this->allPosts = true;
                    $this->kasiPost = false;
                }
            }
        }
    }
        
    public function productFilter(){
           if(isset($_POST['UPDATE_PRODUCTS_FILTER'])){
            if(isset($_POST['PRODUCT']) && !empty($_POST['PRODUCT'])){
                $choice = $_POST['PRODUCT'];
                
                if($choice == "KASI_PRODUCTS"){
                    $this->allProducts = false;
                    $this->kasiProducts = true;
                }elseif($choice == "ALL_PRODUCTS"){
                    $this->allProducts = true;
                    $this->kasiProducts = false;
                }
            }
        }
    }
        
    public function serviceFilter(){
            if(isset($_POST['UPDATE_SERVICES_FILTER'])){
            if(isset($_POST['SERVICE']) && !empty($_POST['SERVICE'])){
                $choice = $_POST['SERVICE'];
                
                if($choice == "KASI_SERVICES"){
                    $this->allServices = false;
                    $this->kasiServices = true;
                }elseif($choice == "ALL_SERVICES"){
                    $this->allServices = true;
                    $this->kasiServices = false;
                }
            }
        }
    }
        
    public function filter(){
        $this->newsFeedFilter();
        $this->productFilter();
        $this->serviceFilter();
    }
        
    public function myWall($userId){
           if(!empty($userId)){
            $sql = "SELECT `ID`,`CATEGORY` FROM `posts` WHERE `USER_ID` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $assArrOfPost = array();
            $arrofArrs = array();   
               $i = 0;
            while($assArr = mysqli_fetch_assoc($results)){
                $assArrOfPost = array("ID"=>$assArr['ID'],"CATEGORY"=>$assArr['CATEGORY']);
                
                $arrofArrs[$i] = $assArrOfPost;
                $i++; 
            }    
               //posts u cn view
            $this->whoCanViewPost();
                 //when done return
                 return $arrofArrs;
        }else{
               return null;
        }
    }
        
    public function getPost($idOfPost){
         if(!empty($idOfPost)){
         
           $sql = "SELECT * FROM `posts` WHERE `ID` LIKE '$idOfPost'";
          $results = mysqli_query($this->connection,$sql) or die("couldnt send query 462");
          $assArr = mysqli_fetch_assoc($results);
            
           //post to html the information
            if(!empty($assArr)){
                //posts u cn view
            $this->whoCanViewPost();
                
                return $assArr;
            }else{
                return null;
            }
      
        }else{
            return null;
        }
    }
        
    public function whoCanViewPost(){
        
        $sql2 = "SELECT `ID` FROM `posts` WHERE 1";
        
        $results2 = mysqli_query($this->connection,$sql2) or die("couldnt send query 485");
        
        $ids = array();
        $j =0;
        
        while($arr2 = mysqli_fetch_assoc($results2)){
            $ids[$j] = $arr2['ID'];
            $j++;
        }
        
        
        $sql1 = "SELECT `ID` FROM `user` WHERE 1";
        
        $results1 = mysqli_query($this->connection,$sql1) or die("couldnt send query 498");
        
        while($arr = mysqli_fetch_assoc($results1)){
            if(!empty($ids)){
            $newArr = implode(",",$ids);

            $id = $arr['ID'];
                
            $sql = "UPDATE `user` SET `POSTIDYOUCANVIEW`='$newArr' WHERE `ID` LIKE '$id'"; 

            mysqli_query($this->connection,$sql) or die("couldnt send query 508");
        }
    }
        
         
        
    }
        
    public function newsFeedTemplate($mainClass,$x){
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
                   
        echo '<button onclick="important('.$x['USER_ID'].','.$x['ID'].','.$mainClass->user->userID.')" type="button" name="impt">';  
        echo '<span id="like" class="'.$x['ID']."like1".'">'.$x['IMPORTANT'].'</span>'; 
        echo 'Important</button>';      
                     
        echo '<button onclick="not_important('.$x['USER_ID'].','.$x['ID'].','.$mainClass->user->userID.')" type="button" name="ntimpt">';
        echo '<span id="like" class="'.$x['ID']."like2".'">'.$x['NOT_IMPORTANT'].'</span>'; 
                     
        echo 'Not Important</button>';           
        echo '<button onclick="document.location = \'shareto.php\'" id="shareTo" type="button">Share to </button>'; 
                     
        echo ' <button onclick="comment('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="cmmt">';  
        echo '<span id="like2">'.$x['NUM_OF_COMMENTS'].'</span>'; 
         echo 'Comment</button>';  
        
        echo ' <button onclick="deletePost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="del">';  
         echo 'Delete</button>';
        
         echo ' <button onclick="editPost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="edit">';  
         echo 'Edit</button>';
        
        echo '</div>';  
        echo '</div>';
                     echo '</form>';
    }
        
    public function productTemplate($mainClass,$x){
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
         echo '<div id="btns">';
        echo ' <button onclick="deletePost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="del">';  
         echo 'Delete</button>';
        
         echo ' <button onclick="editPost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="edit">';  
         echo 'Edit</button>';
        
        echo '</div>';
             echo '</div>';
    }
        
    public function serviceTemplate($mainClass,$x){ 
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
         echo '<div id="btns">';
        echo ' <button onclick="deletePost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="del">';  
         echo 'Delete</button>';
        
         echo ' <button onclick="editPost('.$x['USER_ID'].','.$x['ID'].')"  type="button" name="edit">';  
         echo 'Edit</button>';
        
        echo '</div>';
        echo ' </div>';     
    }
        
    public function editServiceProductNewsfeed($idOfPost,$Category,$mustBeGreaterthanRequiredNumber){
        
         $requiredNum = 4;
            $description = "";
            $location = "";
            $currentState = "AVAILABLE";
            $category = $Category;
            $price = "";
            $image = "";
            if(empty($_POST['DESCRIPTION'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $description = $_POST['DESCRIPTION'];
            }
            if(isset($_POST['UPLOAD_IMAGE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
                
            }else{
            
                $file = $_FILES['UPLOAD_IMAGE'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
               
                if($fileError == 0 && $fileSize <= 500000){
                 //   $destination = 'uploaded_images/'.$fileName;
                   // move_uploaded_file($fileTmpName,$destination) or die("couldnt upload file 775");
                    
                   //  $image = $fileName;
                    $image = file_get_contents($fileTmpName);
                    $image = base64_encode($image);
                }
            }
            if(empty($_POST['PRICE'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }else{
                $price = $_POST['PRICE'];
            }
            if(empty($_POST['UPLOAD_VIDEO'])){
                $x = $requiredNum - 1;
                $requiredNum = $x;
            }
            if(empty($_POST['LOCATION'])){
                
            }else{
                $location = $_POST['LOCATION'];
            }
            if($requiredNum >= $mustBeGreaterthanRequiredNumber){
                 if(empty($image)){
                     
                    $sql = "UPDATE `posts` SET `DESCRIPTION`='$description',`PRICE`='$price',`LOCATION`='$location' WHERE `ID` LIKE '$idOfPost'";
                    
                    mysqli_query($this->connection,$sql) or die("couldnt send query 800");
                }else{
                     
                    $sql = "UPDATE `posts` SET `DESCRIPTION`='$description'.`PRICE`='$price',`PICTURE`='$image',`LOCATION`='$location' WHERE `ID` LIKE '$idOfPost'";
                    
                    mysqli_query($this->connection,$sql) or die("couldnt send query 804");
                }
            }
        
    }
        
    public function editThePost(){
        if(isset($_POST['UPDATE_POST'])){
            if(!empty($_POST['IOP'])){
                 
                $idOfPost = $_POST['IOP'];
                
                 if($_POST['CATEGORY'] == 'product'){
                    $this->editServiceProductNewsfeed($idOfPost,'product',2);
                }
                if($_POST['CATEGORY'] == 'services'){
                 $this->editServiceProductNewsfeed($idOfPost,'services',2);
                }
                if($_POST['CATEGORY'] == 'newsfeed'){
                    $this->editServiceProductNewsfeed($idOfPost,'newsfeed',2);
                }
            }    
        }
    }
        
    public function __destruct(){
                mysqli_close($this->connection) or die("couldnt disconnect to database 830");
        }
        
    }


?>