<?php  
    $id_dh=$_GET['id_dh'];
    $sql = "SELECT * FROM donhang WHERE id_dh=$id_dh";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);
    if(isset($_POST['submit'])){
        $dia_chi=$_POST['dia_chi'];
        $dien_thoai=$_POST['dien_thoai'];
        $email=$_POST['email'];
        if(isset($id_dh) && isset($dia_chi) && isset($dien_thoai) && isset($email)){
            $sql="UPDATE donhang SET dia_chi='$dia_chi', dien_thoai='$dien_thoai', email='$email' WHERE id_dh=$id_dh";
            $query = mysqli_query($conn,$sql);
            header('location: quantri.php?page_layout=dh');
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
        <h1 class="page-header">Sửa đơn hàng</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Sửa đơn hàng</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" method="post">


                        <table data-toggle="table">
                            <thead>
                                <tr>                                
                                <th data-sortable="true">ID đơn hàng</th>
                                <th data-sortable="true">Tên sản phẩm</th>
                                <th data-sortable="true">Khách hàng</th>
                                <th data-sortable="true">địện thoại</th>
                                <th data-sortable="true">Email</th>
                                <th data-sortable="true">Địa chỉ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-checkbox="true"><?php echo $row['id_dh']; ?></td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten_sp" value="<?php if(isset($_POST['ten_sp'])){echo $_POST['ten_sp'];} else{echo $row['ten_sp'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten" value="<?php if(isset($_POST['ten'])){echo $_POST['ten'];} else{echo $row['ten'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="dien_thoai" value="<?php if(isset($_POST['dien_thoai'])){echo $_POST['dien_thoai'];} else{echo $row['dien_thoai'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} else{echo $row['email'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <textarea class="form-control" rows="3" name="dia_chi"><?php if(isset($_POST['dia_chi'])){echo $_POST['dia_chi'];} else{echo $row['dia_chi'];}  ?></textarea>
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
