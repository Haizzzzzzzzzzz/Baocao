<?php  
    $id_sp=$_GET['id_sp'];
    $sql = "SELECT * FROM sanpham WHERE id_sp=$id_sp";
    $query = mysqli_query($conn, $sql);
    $row= mysqli_fetch_array($query);
?>

<div id="product" class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div id="prd-thumb" class="text-center">
            <img width="380px"; style="border-radius: 15px" src="quantri/anh/<?php echo $row['anh_sp']; ?>">
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
    <div id="prd-intro">
        <h3><?php echo $row['ten_sp']; ?></h3>
        <p id="prd-price"><span class="sl">Giá sản phẩm:</span> <span class="sr"><?php echo $row['gia_sp']; ?> VNĐ</span></p>
        <p><span class="sl">Đổi trả:</span><?php echo $row['bao_hanh']; ?></p>
        <p><span class="sl">Đi kèm:</span><?php echo $row['phu_kien']; ?></p>
        <p><span class="sl">Tình trạng:</span><?php echo $row['tinh_trang']; ?></p>
        <p><span class="sl">Khuyến Mại:</span><?php echo $row['khuyen_mai']; ?></p>
        <p><span class="sl">Còn hàng:</span><?php echo $row['trang_thai']; ?></p>

        <!-- Đổi action và phương thức gửi -->
        <form action="chucnang/giohang/themhang.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_sp" value="<?php echo $row['id_sp']; ?>"> <!-- Thêm trường ẩn để gửi id_sp -->
            <label for="customText">Custom: </label>
            <input type="text" id="customText" name="customText">
            <br>
            <button style="margin: 50px; width: 250px; height: 40px; border-radius: 8px; background-color: #FF4500; color: white;" type="submit" name="submit">Thêm vào giỏ hàng và tải lên</button>
        </form>
    </div>
    </div>
</div>
<div id="prd-details" class="text-justify">
            <p>
                <?php echo $row['chi_tiet_sp']; ?>
            </p>
        </div>

<?php  
    if(isset($_POST['submit'])){
        $ten=$_POST['ten'];
        $dien_thoai=$_POST['dien_thoai'];
        $binh_luan=$_POST['binh_luan'];
        $ngay_gio=date('Y-m-d H:i:s');

        if(isset($ten)&&isset($dien_thoai)&&isset($binh_luan)){
            $sql="INSERT INTO blsanpham(ten,dien_thoai,binh_luan,ngay_gio,id_sp) VALUES('$ten','$dien_thoai',"."'$binh_luan','$ngay_gio','$id_sp')";
            $query=mysqli_query($conn,$sql);
            header('location: index.php?page_layout=chitietsp&id_sp='.$id_sp);
        }
    }
?>
<div id="comment" class="col-md-8 col-sm-9 col-xs-12">
    <h3>Bình luận sản phẩm</h3>
    <form method="post" action="index.php?page_layout=chitietsp&id_sp=<?php echo $id_sp; ?>">
      <div class="form-group">
        <label>Tên</label>
        <input type="text" name="ten" required="" class="form-control" placeholder="Tên">
      </div>
      <div class="form-group">
        <label>Điện thoại</label>
        <input type="text" name="dien_thoai" required="" class="form-control" placeholder="Điện thoại">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Nội dung</label>
        <textarea class="form-control" name="binh_luan" required="" placeholder="Nội Dung"></textarea>
      </div>
      <button type="submit" name="submit" class="btn btn-default">Bình luận</button>
    </form>
</div>
<?php
    if(isset($_GET['page']))
    {
        $page=$_GET['page'];
    }else{
        $page=1;
    }
    $rowPerPage=3;
    $perRow=$page*$rowPerPage-$rowPerPage;
    $sqlbl="SELECT * FROM blsanpham WHERE id_sp=$id_sp ORDER BY id_bl ASC LIMIT $perRow,$rowPerPage";
    $querybl=mysqli_query($conn,$sqlbl);

    $totalRow=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM blsanpham WHERE id_sp=$id_sp"));
    $totalPage= ceil($totalRow/$rowPerPage);
    $list_page="";
    for($i=1;$i<=$totalPage;$i++){
        if($page==$i){
            $list_page.='<li class="active"><a href="index.php?page_layout=chitietsp&id_sp='.$id_sp.'&page='.$i.'">'.$i.'</a></li>';
        }else{
            $list_page.='<li><a href="index.php?page_layout=chitietsp&id_sp='.$id_sp.'&page='.$i.'">'.$i.'</a></li>';
        }
    }
    $rowbl=mysqli_num_rows($querybl);
    if($rowbl>0)
    {
?>
<div id="comments" class="col-md-12 col-sm-12 col-xs-12">
    <?php  
        while($row=mysqli_fetch_array($querybl)){
    ?>
    <ul>
        <li class="comm-name"><?php echo $row['ten']; ?></li>
        <li class="comm-time"><?php echo $row['ngay_gio']; ?></li>
        <li class="comm-details">
            <p>
                <?php echo $row['binh_luan']; ?>
            </p>
        </li>
    </ul>
    <?php  
        }
    ?>
</div>
<?php  
    }
?>
<!-- Pagination -->
<div id="pagination" class="col-md-12 col-sm-12 col-xs-12">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <?php  
        echo $list_page;
        ?>
      </ul>
    </nav>
</div>            
<!-- End Pagination -->   
