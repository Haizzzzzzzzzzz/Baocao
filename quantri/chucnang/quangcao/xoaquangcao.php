<?php  
	session_start();
	if($_SESSION['email']=='a@gmail.com' && $_SESSION['pass']=='a'){
		$id_quangcao=$_GET['id_quangcao'];
		include_once'../../ketnoi.php';
		$sql="DELETE FROM quangcao WHERE id_quangcao='$id_quangcao'";
		$query=mysqli_query($conn ,$sql);
		header('location: ../../quantri.php?page_layout=quangcao');
	}else{
		header('location: ../../index.php');
	}
?>