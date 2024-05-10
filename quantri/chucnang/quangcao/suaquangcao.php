<?php  
	$id_quangcao=$_GET['id_quangcao'];
	$sql = "SELECT * FROM quangcao WHERE id_quangcao=$id_quangcao";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);

    if (isset($_POST['submit'])) {
		$id_thue=$_POST['id_thue'];
		$hinh_anh=$_POST['ten_anh'];
        if($_FILES['hinh_anh']['name']==''){
            $ten_anh=$_POST['ten_anh'];
        }else{
            $ten_anh=$_FILES['hinh_anh']['name'];
            $tmp_name=$_FILES['hinh_anh']['tmp_name'];
        }
		if (isset($id_thue)&&isset($ten_anh)) {
            move_uploaded_file($tmp_name, 'anh/'.$hinh_anh);
			$sql="UPDATE quangcao SET id_thue='$id_thue',ten_anh='$hinh_anh' WHERE id_quangcao=$id_quangcao";
            $query = mysqli_query($conn,$sql);
            header('location: quantri.php?page_layout=quangcao');
		}
	}
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active"></li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Sửa quảng cáo</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Sửa quảng cáo</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" enctype="multipart/form-data" method="post">
                        <table data-toggle="table">
                            <thead>
                                <tr>                                
		                            <th data-sortable="true">id_thue</th>
		                            <th data-sortable="true">Tên ảnh</th>
                                    <th data-sortable="true">Hình ảnh quảng cáo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="id_thue" value="<?php if(isset($_POST['id_thue'])){echo $_POST['id_thue'];}else{echo $row['id_thue'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten_anh" value="<?php if(isset($_POST['ten_anh'])){echo $_POST['ten_anh'];}else{echo $row['ten_anh'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input type="file" name="hinh_anh"><input type="hidden" name="hinh_anh" value="<?php echo $row['ten_anh']; ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary" name="submit">Sửa</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->