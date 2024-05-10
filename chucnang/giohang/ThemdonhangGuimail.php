<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function themDonHangVaGuiEmail($conn, $ten, $email, $sdt, $diachi, $thanhtoan) {
    $ngay_gio = date('Y-m-d H:i:s');

    // Lấy ID đơn hàng mới nhất và tăng lên
    $sql = "SELECT MAX(id_dh) AS Max_ID FROM donhang";
    $query_id_sp = mysqli_query($conn, $sql);
    $row_id = mysqli_fetch_array($query_id_sp);
    $i = is_null($row_id['Max_ID']) ? 0 : $row_id['Max_ID'] + 1;

    // Kiểm tra nếu có giỏ hàng
    if (isset($_SESSION['giohang'])) {
        $arrid = array();
        foreach ($_SESSION['giohang'] as $id_sp => $sl) {
            // Lấy thông tin sản phẩm
            $sql1 = "SELECT ten_sp, gia_sp FROM SanPham WHERE id_sp='$id_sp'";
            $query_ten_sp = mysqli_query($conn, $sql1);
            $row_ten_sp = mysqli_fetch_array($query_ten_sp);
            $ten_sp = $row_ten_sp['ten_sp'];
            $gia_tien = $row_ten_sp['gia_sp'];
            $customText = isset($_SESSION['customText'][$id_sp]) ? $_SESSION['customText'][$id_sp] : '';

            // Thêm vào đơn hàng
            $sql = "INSERT INTO donhang (id_dh, ten_sp, custom_text, phuongthucthanhtoan, ten, dien_thoai, dia_chi, email, id_sp, ngay_gio, gia_tien) VALUES ('$i', '$ten_sp', '$customText', '$thanhtoan', '$ten', '$sdt', '$diachi', '$email', '$id_sp', '$ngay_gio', '$gia_tien')";
            $query = mysqli_query($conn, $sql);
            $arrid[] = $id_sp;
        }
        $strId=implode(',', $arrid);
        $sql="SELECT * FROM sanpham WHERE id_sp IN($strId) ORDER BY id_sp DESC";
        $query=mysqli_query($conn,$sql);
        // Gửi email xác nhận
        guiEmailXacNhan($email, $ten, $_SESSION['giohang'], $sdt, $diachi, $query, $arrid, $conn);
    }
}

function guiEmailXacNhan($email, $ten, $giohang, $sdt, $diachi, $query, $arrid, $conn) {
    // Tạo body email
    $strBody='';
    $strBody = "<p><b>Khách hàng:</b> $ten<br /><b>Email:</b> $email<br /><b>Điện thoại:</b> $sdt<br /><b>Địa chỉ:</b> $diachi</p>";
    $strBody .= '<table border="1px" cellpadding="10px" cellspacing="1px" width="100%">
    <tr>
        <td align="center" bgcolor="#3F3F3F" colspan="4"><font color="white"><b>XÁC NHẬN HÓA ĐƠN THANH TOÁN</b></font></td>
    </tr>
    <tr id="invoice-bar">
        <td width="45%"><b>Tên Sản phẩm</b></td>
        <td width="20%"><b>Giá</b></td>
        <td width="15%"><b>Số lượng</b></td>
        <td width="20%"><b>Thành tiền</b></td>
    </tr>';

    $totalPriceAll = 0;
    while($row = mysqli_fetch_array($query)){
    $totalPrice = $row['gia_sp']*$_SESSION['giohang'][$row['id_sp']];

    $strBody .= '<tr>
        <td class="prd-name">'.$row['ten_sp'].'</td>
        <td class="prd-price"><font color="#C40000">'.$row['gia_sp'].' VNĐ</font></td>
        <td class="prd-number">'.$_SESSION['giohang'][$row['id_sp']].'</td>
        <td class="prd-total"><font color="#C40000">'.$totalPrice.' VNĐ</font></td>
    </tr>';

    $totalPriceAll += $totalPrice;
    }

        $strBody .= '<tr>
            <td class="prd-name">Tổng giá trị hóa đơn là:</td>
            <td colspan="2"></td>
            <td class="prd-total"><b><font color="#C40000">'.$totalPriceAll.' VNĐ</font></b></td>
        </tr>
    </table>';

    $strBody .= '<p align="justify">
        <b>Quý khách đã đặt hàng thành công!</b><br />
        • Sản phẩm của Quý khách sẽ được chuyển đến Địa chỉ có trong phần Thông tin Khách hàng của chúng Tôi sau thời gian 2 đến 3 ngày, tính từ thời điểm này.<br />
        • Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng.<br />
        <b><br />Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</b>
    </p>';

    // Thiết lập SMTP Server
    // require("class.phpmailer.php"); // nạp thư viện
    $mailer = new PHPMailer(); // khởi tạo đối tượng

    $mailer->isSMTP(); // gọi class smtp để đăng nhập
    $mailer->CharSet="utf-8"; // bảng mã unicode

    //Đăng nhập Gmail
    $mailer->SMTPAuth = true; // Đăng nhập
    $mailer->SMTPSecure = "tls"; // Giao thức SSL
    $mailer->Host = "smtp.gmail.com"; // SMTP của GMAIL
    $mailer->Port = 587; // cổng SMTP

    // Phải chỉnh sửa lại
    $mailer->Username = "caiginhi103@gmail.com"; // GMAIL username
    $mailer->Password = "wfkypltccgttmexo"; // GMAIL password
    $mailer->AddAddress($email, $ten); //email người nhận, $email và $ten là 2 biến đc gán bởi $_POST lấy từ trong form
    $mailer->AddCC("caiginhi103@gmail.com", "Admin FEAER"); // gửi thêm một email cho Admin

    // Chuẩn bị gửi thư nào
    $mailer->setFromName = 'Shop FEAER'; // tên người gửi
    $mailer->setFrom = 'caiginhi103@gmail.com'; // mail người gửi
    $mailer->Subject = 'Hóa đơn xác nhận mua hàng từ FEAER';
    $mailer->IsHTML(TRUE); //Bật HTML không thích thì false

    // Nội dung lá thư
    $mailer->Body = $strBody;

    //gửi mail
    if(!$mailer->Send()){
        //gửi không được đưa thông báo lôi
        
        echo "Lỗi gửi email: ".$mailer->ErrorInfo;
        // header('location: index.php?page_layout=hoanthanh');
    }else{
        //gửi thành công
        echo 'Email sent successfully';
        header('location: index.php?page_layout=hoanthanh');
    }

    
}
?>