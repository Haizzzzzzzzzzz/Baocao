<script>
	function xoaquangcao(){
		var conf= confirm('bạn có muốn xóa quang cao này không?');
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
	$sql="SELECT * FROM quangcao LIMIT $perPage,$rowPerPage";
	$query=mysqli_query($conn,$sql);

	$totalRows=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM quangcao"));
    $totalPages=ceil($totalRows/$rowPerPage);
    $listPage="";
    for($i=1;$i<=$totalPages;$i++)
    {
        if($page==$i){
            $listPage.='<li class="active"><a href="quantri.php?page_layout=quangcao&page='.$i.'">'.$i.'</a></li>';
        }
        else{
            $listPage.='<li><a href="quantri.php?page_layout=quangcao&page='.$i.'">'.$i.'</a></li>';
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
        <h1 class="page-header">Quảng cáo</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">					
            <div class="panel-body" style="position: relative;">
                <a href="quantri.php?page_layout=themquangcao" class="btn btn-primary" style="margin: 10px 0 20px 0; position: absolute;">Thêm quảng cáo</a>				
                <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>						        
                            <th data-sortable="true">Id_quangcao</th>
                            <th data-sortable="true">id_thue</th>
                            <th data-sortable="true">Hình ảnh quảng cáo</th>
                            <th data-sortable="true">Sửa</th>
                            <th data-sortable="true">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            while($row=mysqli_fetch_array($query)){
                        ?>
                        <tr style="height: 300px;">
                            <td data-checkbox="true"><a href="quantri.php?page_layout=suaquangcao&id_quangcao=<?php echo $row['id_quangcao']; ?>"><?php echo $row['id_quangcao']; ?></a></td>
                            <td data-checkbox="true"><?php echo $row['id_thue']; ?></td>
                            <td data-checkbox="true">
                            	<span class="thumb"><img width="80px" height="150px" src="anh/<?php echo $row['ten_anh']; ?>" /></span>
                            </td>
                            <td>
                                <a href="quantri.php?page_layout=suaquangcao&id_quangcao=<?php echo $row['id_quangcao']; ?>"><span><svg class="glyph stroked brush" style="width: 20px;height: 20px;"><use xlink:href="#stroked-brush"/></svg></span></a>
                            </td>
                            <td>
                                <a onclick="return xoaquangcao();" href="./chucnang/quangcao/xoaquangcao.php?id_quangcao=<?php echo $row['id_quangcao']; ?>"><span><svg class="glyph stroked cancel" style="width: 20px;height: 20px;"><use xlink:href="#stroked-cancel"/></svg></span></a>
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