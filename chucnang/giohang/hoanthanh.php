
<div class="ordered">
    <p class="ordered-report">Quý khách đã đặt hàng thành công!</p>
    <p>• Hóa đơn mua hàng của Quý khách đã được chuyển đến Địa chỉ Email có trong phần Thông tin Khách hàng của chúng Tôi</p>
    <p>• Sản phẩm của Quý khách sẽ được chuyển đến Địa có trong phần Thông tin Khách hàng của chúng Tôi sau thời gian 2 đến 3 ngày, tính từ thời điểm này.</p>
    <p>• Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng</p>
    <p align="center">Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</p>
</div>
<p id="return-home" align="right"><a href="index.php">Quay về trang chủ</a></p>

<?php 
require 'ThemdonhangGuimail.php';
      if(isset($_GET['partnerCode'])){
            $ten=$_GET['ten'];
            $email=$_GET['email'];
            $sdt=$_GET['sdt'];
            $diachi=$_GET['diachi'];
            $ngay_gio=date('Y-m-d H:i:s');
            $momo_partnerCode = $_GET['partnerCode'];
            $_orderId = $_GET['orderId'];
            $_requestId = $_GET['requestId'];
            $_amount = $_GET['amount'];
            $_orderInfo = $_GET['orderInfo'];
            $_orderType = $_GET['orderType'];
            $_transId = $_GET['transId'];
            $_payType = $_GET['payType'];
            $_signature = $_GET['signature'];

            $sql="INSERT INTO momo(partnerCode, orderId, requestId, amount,orderInfo,orderType,transId, payType, signature) VALUES('$momo_partnerCode','$_orderId','$_requestId','$_amount','$_orderInfo','$_orderType','$_transId','$_payType','$_signature')";
            $query=mysqli_query($conn,$sql);
            $phuongthucthanhtoan = "momo";

            themDonHangVaGuiEmail($conn, $ten, $email, $sdt, $diachi, $phuongthucthanhtoan);
    }
    
?>
                    