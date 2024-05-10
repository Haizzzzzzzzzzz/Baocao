<?php  
    if(isset($_POST['submit'])){
        $ten=$_POST['ten'];
        $id_sp=$_POST['id_sp'];
        $dien_thoai=$_POST['dien_thoai'];
        $dia_chi=$_POST['dia_chi'];
        $email=$_POST['email'];
        $ngay_gio=date('Y-m-d H:i:s');

        $sql="SELECT Max(id_dh) as Max_ID FROM donhang";
        $query_id_sp=mysqli_query($conn,$sql);
        $row_id = mysqli_fetch_array($query_id_sp);
        $i = $row_id['Max_ID'] + 1 ;

        if(isset($ten)&&isset($dien_thoai)&&isset($dia_chi)&&isset($id_sp)&&isset($email)){
                    $sql1="SELECT ten_sp as tenSP FROM SanPham WHERE id_sp='$id_sp'";
                    $query_ten_sp = mysqli_query($conn,$sql1);
                    $row_ten_sp = mysqli_fetch_array($query_ten_sp);
                    $ten_sp = $row_ten_sp['tenSP'];
                    
                    $sql="INSERT INTO donhang(id_dh, ten_sp, ten, dien_thoai, dia_chi, email, id_sp, ngay_gio) VALUES('$i','$ten_sp','$ten','$dien_thoai',"."'$dia_chi','$email','$id_sp','$ngay_gio')";
                    $query=mysqli_query($conn,$sql);

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
        <h1 class="page-header">Thêm mới đơn hàng</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Thêm đơn hàng</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" method="post">
                        <table data-toggle="table">
                            <thead>
                                <tr>                                
                                    <th data-sortable="true">Tên</th>
                                    <th data-sortable="true">Id_sp</th>
                                    <th data-sortable="true">Điện thoại</th>
                                    <th data-sortable="true">Địa chỉ</th>
                                    <th data-sortable="true">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten" value="<?php if(isset($_POST['ten']))echo $_POST['ten'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="id_sp" value="<?php if(isset($_POST['id_sp']))echo $_POST['id_sp'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="dien_thoai" value="<?php if(isset($_POST['dien_thoai']))echo $_POST['dien_thoai'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <textarea class="form-control" rows="3" name="dia_chi"><?php if(isset($_POST['dia_chi']))echo $_POST['dia_chi'];?></textarea>
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="email" value="<?php if(isset($_POST['email']))echo $_POST['email'];?>" required="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary" name="submit">Thêm mới</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->