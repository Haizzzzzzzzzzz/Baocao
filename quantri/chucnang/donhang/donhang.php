<script>
	function xoadh(){
		var conf= confirm('bạn có muốn xóa đơn hàng này không?');
		return conf;
	}
</script>
<?php
    if(isset($_GET['page']))
    {
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }
    $rowPerPage=5;
    $perPage=$page*$rowPerPage-$rowPerPage;
	$sql="SELECT * FROM donhang LIMIT $perPage,$rowPerPage";
	$query=mysqli_query($conn,$sql);

    $totalRows=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM donhang"));
    $totalPages=ceil($totalRows/$rowPerPage);
    $listPage="";
    for($i=1;$i<=$totalPages;$i++)
    {
        if($page==$i){
            $listPage.='<li class="active"><a href="quantri.php?page_layout=dh&page='.$i.'">'.$i.'</a></li>';
        }
        else{
            $listPage.='<li><a href="quantri.php?page_layout=dh&page='.$i.'">'.$i.'</a></li>';
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
        <h1 class="page-header">Quản lý đơn hàng</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
			<div class="panel-body" style="position: relative;">
                <a href="quantri.php?page_layout=themdh" class="btn btn-primary" style="margin: 10px 0 20px 0; position: absolute;">Thêm đơn hàng</a>
                <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>						        
                            <th data-sortable="true">ID đơn hàng</th>
                            <th data-sortable="true">ID sản phẩm</th>
                            <th data-sortable="true">Tên sản phẩm</th>
                            <th data-sortable="true">Custom</th>
                            <th data-sortable="true">Thanh toán</th>
                            <th data-sortable="true">Khách hàng</th>
                            <th data-sortable="true">địện thoại</th>
                            <th data-sortable="true">Email</th>
                            <th data-sortable="true">Địa chỉ</th>
                            <th data-sortable="true">Thời gian</th>
                            <th data-sortable="true">Sửa</th>
                            <th data-sortable="true">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php  
                            while($row= mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td data-checkbox="true"><?php echo $row['id_dh']; ?></td>
                            <td data-checkbox="true"><?php echo $row['id_sp']; ?></td>
                            <td data-checkbox="true"><?php echo $row['ten_sp']; ?></td>
                            <td data-checkbox="true"><?php echo $row['custom_text']; ?></td>
                            <td data-checkbox="true"><?php echo $row['phuongthucthanhtoan']; ?></td>
                            <td data-checkbox="true"><?php echo $row['ten']; ?></td>
                            <td data-checkbox="true"><?php echo $row['dien_thoai']; ?></td>
                            <td data-checkbox="true"><?php echo $row['email']; ?></td>
                            <td data-checkbox="true"><?php echo $row['dia_chi']; ?></td>
                            <td data-checkbox="true"><?php echo $row['ngay_gio']; ?></td>
                            <td>
                                <a href="quantri.php?page_layout=suadh&id_dh=<?php echo $row['id_dh']; ?>"><span><svg class="glyph stroked brush" style="width: 20px;height: 20px;"><use xlink:href="#stroked-brush"/></svg></span></a>
                            </td>
                            <td>
                                <a onclick="return xoadh();" href="./chucnang/donhang/xoadh.php?id_dh=<?php echo $row['id_dh']; ?>"><span><svg class="glyph stroked cancel" style="width: 20px;height: 20px;"><use xlink:href="#stroked-cancel"/></svg></span></a>
                            </td>
                        </tr>
                        <?php  
                            }
                        ?>
                    </tbody>
                </table>
                <ul class="pagination" style="float: right;">
                    <?php  
                        echo $listPage;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div><!--/.row-->	