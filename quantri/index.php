<?php  
    ob_start();
    session_start();
    include_once'./ketnoi.php';

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $pass = $_POST['mk'];
        if(isset($email) && isset($pass)){
            $sql="SELECT *FROM thanhvien WHERE email='$email' and mat_khau='$pass'";
            $query=mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($query);
            $rows=mysqli_num_rows($query);
            if($rows>0){
                $_SESSION['email']=$email;
                $_SESSION['pass']=$pass;
            }
            else{
                echo'<center class="alert alert-danger">Tài khoản không tồn tại hoặc bạn không có quyền truy cập!</center>';
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JERSEY CUSTOM - thời trang nam</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="Backgroud-login">
        <?php include './facebook_source.php'; ?>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading" style="font-weight: bold">Đăng nhập JERSEY CUSTOM</div>
                    <div class="panel-body">
                        <?php  
                            if(!isset($_SESSION['email'])){
                        ?>
                        <form method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tài khoản E-mail" name="email" type="email" autofocus="" required="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="mk" type="password" required="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="check" type="checkbox" value="Remember Me">Ghi nhớ
                                    </label>
                                </div>
                                <br/>
                                <input type="submit" name="submit" value="Đăng nhập" class="btn btn-primary">
                                <input type="reset" name="resset" value="Làm mới" class="btn btn-danger" />
                                <a href="../index.php"><input type="button" value="Trở về" class="btn btn-default" /></a>
                            </br>
                            </br>
                            </br>
                            		<input type="submit" name="submit" value="Đăng nhập" class="btn btn-primary">	
                                    </br>
                            		<?php
                                    
                                        require_once( 'Facebook/autoload.php' );
                                        $fb = new Facebook\Facebook([
                                        'app_id' => '{app-id}',
                                        'app_secret' => '{app-secret}',
                                        'default_graph_version' => 'v2.9',
                                        ]);
                                        $helper = $fb->getRedirectLoginHelper();
                                        $permissions = ['email']; // Optional permissions
                                        $loginUrl = $helper->getLoginUrl('http://localhost:8888/DoAnWeb/index.php', $permissions);
                                        echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
                                        ?>
                                  
                                    <?php
                                    
    require_once('../chucnang/login/login_gmail/define.php');
 
    /**
     * SET CONNECT
     */
    $conn = mysqli_connect(LOCALHOST,USERNAME,PASSWORD,DATABASE);
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
     
 
    /**
     * CALL GOOGLE API
     */
    require_once '../chucnang/login/login_gmail/vendor/autoload.php';
    $client = new Google_Client();
    $client->setClientId(GOOGLE_APP_ID);
    $client->setClientSecret(GOOGLE_APP_SECRET);
    $client->setRedirectUri(GOOGLE_APP_CALLBACK_URL);
    $client->addScope("email");
    $client->addScope("profile");
    
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
       // print_r($token);
        $client->setAccessToken($token['access_token']);
        
        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
       
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;    
      
        $sql = "SELECT * FROM `thanhvien` WHERE `email`='".$email."'";
        $result = mysqli_query($conn,$sql);
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
            /**
             * USER EXITS
             */
            header('location: ../../../');
        }
        else{
            $query = "INSERT INTO thanhvien (email, mat_khau ) VALUES ('{$email}', 'gmail.com')";
            // confirm($query);
            $result = mysqli_query($conn,$query);
        
            // set_message("USER CREATED");
        
            header('location: ../../../');
        }
        
    } else {
        /**
         * IF YOU DON'T LOGIN GOOGLE
         * YOU CAN SEEN AGAIN GOOGLE_APP_ID, GOOGLE_APP_SECRET, GOOGLE_APP_CALLBACK_URL
         */
        echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
    }

?>			
                            </fieldset>
                        </form>
                        <?php  
                            }
                            else{
                                if ($row['quyen_truy_cap']==2) {
                                    header('location: ./quantri.php');
                                }else{
                                    header('location: ../index.php');
                                }
                            }
                        ?>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->	



        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/chart.min.js"></script>
        <script src="js/chart-data.js"></script>
        <script src="js/easypiechart.js"></script>
        <script src="js/easypiechart-data.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script>
            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
        </script>	
    </body>

</html>
