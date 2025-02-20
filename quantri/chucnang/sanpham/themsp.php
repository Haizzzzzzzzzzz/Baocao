<?php  
    $sqldm="SELECT * FROM dmsanpham";
    $querydm= mysqli_query($conn, $sqldm);
    if(isset($_POST['submit'])){
        $ten_sp=$_POST['ten_sp'];
        $gia_sp=$_POST['gia_sp'];
        $bao_hanh=$_POST['bao_hanh'];
        $phu_kien=$_POST['phu_kien'];
        $tinh_trang=$_POST['tinh_trang'];
        $khuyen_mai=$_POST['khuyen_mai'];
        $trang_thai=$_POST['trang_thai'];
        $chi_tiet_sp=$_POST['chi_tiet_sp'];

        if($_FILES['anh_sp']['name']==''){
            $error_anh_sp='<span style="color: red;">(*)</span>';
        }
        else{
            $anh_sp=$_FILES['anh_sp']['name'];
            $tmp_name=$_FILES['anh_sp']['tmp_name'];
        }

        if($_POST['id_dm']=='unselect'){
            $error_id_dm='<span style="color: red;">(*)</span>';          
        }else{
            $id_dm=$_POST['id_dm'];
        }
        $dac_biet=$_POST['dac_biet'];
        if (isset($ten_sp) && isset($gia_sp) && isset($bao_hanh) && isset($phu_kien) && isset($tinh_trang) && isset($khuyen_mai) && isset($trang_thai) && isset($chi_tiet_sp) && isset($anh_sp) && isset($id_dm) && isset($dac_biet)) {
            move_uploaded_file($tmp_name, 'anh/'.$anh_sp);
            $sql="INSERT INTO sanpham(ten_sp,gia_sp,bao_hanh,phu_kien,tinh_trang,khuyen_mai,trang_thai,chi_tiet_sp,anh_sp,id_dm,dac_biet) VALUES('$ten_sp','$gia_sp','$bao_hanh','$phu_kien','$tinh_trang','$khuyen_mai','$trang_thai','$chi_tiet_sp','$anh_sp','$id_dm','$dac_biet')";
            $query= mysqli_query($conn , $sql);
            header('location: quantri.php?page_layout=danhsachsp');
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
        <h1 class="page-header">Thêm sản phẩm mới</h1>
    </div>
</div><!--/.row-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Thêm sản phẩm mới</div>
            <div class="panel-body">

                <form method="post" enctype="multipart/form-data" role="form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" class="form-control"  name="ten_sp" required="">
                        </div>
                        <div class="form-group">
                            <label>Giá sản phẩm</label>
                            <input type="text" class="form-control" name="gia_sp" required="">
                        </div>

                        <div class="form-group">
                            <label>Đổi trả</label>
                            <input type="text" class="form-control" name="bao_hanh" value="7 ngày" required="">
                        </div>

                        <div class="form-group">
                            <label>Đi kèm</label>
                            <input type="text" class="form-control" name="phu_kien" value="" required="">
                        </div>
                        <div class="form-group">
                            <label>Tình trạng</label>
                            <input type="text" class="form-control" name="tinh_trang" value="Real" required="">
                        </div>

                        <div class="form-group">
                            <label>Ảnh mô tả</label>
                            <input type="file" name="anh_sp">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Khuyến mãi</label>
                            <input type="text" class="form-control" name="khuyen_mai" value="" required="">
                        </div>
                        <div class="form-group">
                            <label>Còn hàng</label>
                            <input type="text" class="form-control" name="trang_thai" value="Còn hàng" required="">
                        </div>
                        <div class="form-group">
                            <label>Sản phẩm đặc biệt</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="dac_biet" id="optionsRadios1" value=1>Có
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="dac_biet" id="optionsRadios2" value=0 checked>Không
                                </label>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Danh mục</label>
                            <select name="id_dm" class="form-control">
                                <option value="unselect" selected>Hãng ...</option>
                                <?php
                                    while($rowdm= mysqli_fetch_array($querydm)){
                                ?>
                                <option value="<?php echo $rowdm['id_dm']; ?>"><?php echo $rowdm['ten_dm']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thông tin chi tiết sản phẩm</label>
                            <textarea class="form-control" rows="3" name="chi_tiet_sp"></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace('chi_tiet_sp');
                            </script>
                        </div>



                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Thêm mới</button>
                    <button type="reset" class="btn btn-default" name="reset">Làm mới</button>


                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
