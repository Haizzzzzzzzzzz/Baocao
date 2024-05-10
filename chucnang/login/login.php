<?php 
	if (isset($_SESSION['email'])&&isset($_SESSION['email'])){
?>
<div id="login" class="col-md-4 col-sm-12 col-xs-12 " style = "background-color: black">
    <div id="login-main">
        <ul>
        	<li id="user" style="border: 1px solid black; padding: 5px; color: white; font-weight: bold;">Xin chào <?php echo $_SESSION['email'];?>
                <div>
                    <ul id="user-main">
                        <li><a href="./quantri/chucnang/dangxuat/dangxuat.php" style="color: red">Logout</a></li>
                    </ul>      
                </div>
            </li>
        </ul>
    </div>  
</div>
<?php  
	}else{
?>
<div id="login" class="col-md-4 col-sm-12 col-xs-12 text-right" style="padding-top: 7px; margin-bottom: -4px;">
    <div id="login-main">
        <p>
            <a href="./quantri/index.php" class="btn btn-primary" style="width: 100px; height: 30px; background-color: black; border-color: red; ">Login</a>
            <span> ---------- </span>
            <a href="./chucnang/tao_tk/taotk.php" class="btn btn-primary"style="width: 100px; height: 30px; background-color: black; border-color: red;">Sign In</a>
        </p>
    </div>
</div>

<?php  
	}
?>