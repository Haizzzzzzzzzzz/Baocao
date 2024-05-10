<?php  
	session_start();
	if($_SESSION['email']=='a@gmail.com' && $_SESSION['pass']=='a'){
		$id_bl=$_GET['id_bl'];
		include_once'../../ketnoi.php';
		$sql= "DELETE FROM blsanpham WHERE id_bl='$id_bl'";
		$query= mysqli_query($conn,$sql);
		header('location: ../../quantri.php?page_layout=blsp');
	}else{
		header('location: ../../index.php');
	}
?>