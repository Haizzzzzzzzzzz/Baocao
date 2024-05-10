<div id="cart">
    <h2 class="h2-bar">giỏ hàng của bạn</h2>
    <style>
    .tooltip-image {
        position: absolute;
        padding: 5px;
        display: none;
        z-index: 1000;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #d3d3d3;
    }

    .tooltip-image img {
        display: block;
        max-width: 200px; /* Giới hạn kích thước hình ảnh */
        height: auto;
    }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('.image-tooltip');

        tooltips.forEach(tooltip => {
            tooltip.addEventListener('mouseover', function(e) {
                let imgTooltip = document.querySelector('.tooltip-image');
                if (!imgTooltip) {
                    imgTooltip = document.createElement('div');
                    imgTooltip.className = 'tooltip-image';
                    document.body.appendChild(imgTooltip);
                }

                imgTooltip.innerHTML = '<img src="' + this.dataset.img + '">';
                imgTooltip.style.display = 'block';
                imgTooltip.style.left = e.pageX + 10 + 'px';
                imgTooltip.style.top = e.pageY + 10 + 'px';
            });

            tooltip.addEventListener('mousemove', function(e) {
                const imgTooltip = document.querySelector('.tooltip-image');
                imgTooltip.style.left = e.pageX + 10 + 'px';
                imgTooltip.style.top = e.pageY + 10 + 'px';
            });

            tooltip.addEventListener('mouseout', function() {
                const imgTooltip = document.querySelector('.tooltip-image');
                imgTooltip.style.display = 'none';
            });
        });
    });
    </script>
    <?php  
        if (isset($_SESSION['giohang'])) {
            if(isset($_POST['sl'])){
                foreach ($_POST['sl'] as $id_sp => $sl) { //vòng lặp foreach được sử dụng để lặp qua mảng $_POST['sl'], trong đó $id_sp là khóa và $sl là giá trị tương ứng
                    if($sl==0){
                        unset($_SESSION['giohang'][$id_sp]);// Xóa ra khỏi giỏ hàng
                    }else if($sl>0){
                        $_SESSION['giohang'][$id_sp] = $sl;// Cập nhập vào giỏ hàng
                    }
                }
            }
            $arrid=array();
            foreach ($_SESSION['giohang'] as $id_sp => $so_luong) { //các khóa của mảng $_SESSION['giohang'] (tức là các id_sp của sản phẩm) sẽ được thêm vào mảng $arrid.
                //trong đó $id_sp là khóa và $so_luong là giá trị tương ứng:
                $arrid[]=$id_sp;
            }
            $strid=implode(',', $arrid); // nối các phần tử của mảng $arrid thành một chuỗi, các phần tử được nối với nhau bằng dấu phẩy
        $sql="SELECT * FROM sanpham WHERE id_sp IN($strid) ORDER BY id_sp DESC";
        $query=mysqli_query($conn,$sql);
    ?>
    <form id="giohang" method="post">
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:40%">Sản phẩm</th>
                <th style="width:10%">Giá</th>
                <th style="width:10%">Số lượng</th>
                <th style="width:30%" class="text-center">Tổng tiền</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <!-- Product Item -->
        <?php  
            $totalPriceAll=0;
            while ($row=mysqli_fetch_array($query)) {
                $totalPrice=$row['gia_sp']*$_SESSION['giohang'][$row['id_sp']]; // tính giá tiền của các sản phẩm
                  // Lấy thông tin tùy chỉnh và hình ảnh từ session
                $customText = isset($_SESSION['customText'][$row['id_sp']]) ? $_SESSION['customText'][$row['id_sp']] : '';
        ?>
        <tbody>
            <tr>    
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-2 hidden-xs"><img src="quantri/anh/<?php echo $row['anh_sp']; ?>" alt="..." class="img-responsive"/></div>
                        <div class="col-sm-10">
                            <h5><?php echo $row['ten_sp']; ?></h5>
                            <p class="image-tooltip" data-img="<?php echo htmlspecialchars($customText); ?>">
                                <?php 
                                echo "Nội dung custom: " . (mb_strlen($customText, 'UTF-8') > 50 ? mb_substr($customText, 0, 50, 'UTF-8') . "..." : $customText); 
                                ?>
                            </p>
                        </div>
                    </div>
                </td>
                <td data-th="Price"><?php echo $row['gia_sp']; ?></td>
                <td data-th="Quantity">
                    <input name="sl[<?php echo $row['id_sp']; ?>]" type="number" min="0" class="form-control text-center" value="<?php echo $_SESSION['giohang'][$row['id_sp']]; ?>">
                </td>
                <td data-th="Subtotal" class="text-center"><span><?php echo $totalPrice; ?></span></td>
                <td class="actions" data-th="">
                    <a href="chucnang/giohang/xoahang.php?id_sp=<?php echo $row['id_sp']; ?>">Xóa</a>
                </td>
            </tr>
        </tbody>
        <?php  
            $totalPriceAll+=$totalPrice;
            }
        ?>
        <!-- End Product Item -->
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>Total <span><?php echo $totalPriceAll; ?></span></strong></td>
            </tr>
            <tr>
                <td>
                    <a href="index.php" class="btn btn-warning">Tiếp tục mua hàng</a>
                    <a onclick="document.getElementById('giohang').submit();" href="#" class="btn btn-info">Cập nhật giỏ hàng</a>

                </td>
                <td colspan="2" class="hidden-xs">
                    <a class="btn btn-default" href="chucnang/giohang/xoahang.php?id_sp=0">Xóa hết sản phẩm</a>  
                </td>
                <td class="hidden-xs text-center"><strong>Tổng tiền giỏ hàng: <span><?php echo $totalPriceAll; ?></span></strong></td>
                <td><a href="index.php?page_layout=muahang" class="btn btn-success btn-block">Thanh toán</a></td>
            </tr>
        </tfoot>
    </table>
    </form>
    <?php  
        }else{
            echo '<script>alert("không có sản phẩm nào trong giả hàng!");</script>';
        }
    ?>
</div>

