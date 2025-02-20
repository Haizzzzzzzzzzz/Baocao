﻿<?php  

    if(isset($_SESSION['giohang'])){
        $arrid=array();
        foreach ($_SESSION['giohang'] as $id_sp => $sl) {
            $arrid[]=$id_sp;
        }
        $strId=implode(',', $arrid);
        $sql="SELECT * FROM sanpham WHERE id_sp IN($strId) ORDER BY id_sp DESC";
        $query=mysqli_query($conn,$sql);
    }
?>
<div id="checkout">
<h2 class="h2-bar">xác nhận hóa đơn thanh toán</h2>
<table class="table table-bordered">
    <tr>
    <thead>
    <th>tên sản phẩm</th>
    <th>Custom</th>
    <th>giá</th>
    <th>số lượng</th>
    <th>thành tiền</th>
    </thead>
    </tr>

    <?php 
        $arr_custom = [];
        $totalPriceAll=0;
        while ($row=mysqli_fetch_array($query)) {
            $totalPrice=$row['gia_sp']*$_SESSION['giohang'][$row['id_sp']];
            // Lấy thông tin tùy chỉnh và hình ảnh từ session
            $customText = isset($_SESSION['customText'][$row['id_sp']]) ? $_SESSION['customText'][$row['id_sp']] : '';
            $arr_custom[] = "$customText";
        
    ?>
    <tr>
        <td><?php echo $row['ten_sp']; ?></td>
        <td><?php echo $customText; ?></td>
        <td><span><?php echo $row['gia_sp']; ?></span></td>
        <td><?php echo $_SESSION['giohang'][$row['id_sp']]; ?></td>
        <td><span><?php echo $totalPrice; ?></span></td>
    </tr>


    <?php
        $totalPriceAll+=$totalPrice;  
        }
    ?>
    <tr>
        <td>Tổng giá trị hóa đơn:</td>
        <td colspan="2"></td>
        <td><b><span><?php echo $totalPriceAll; ?></span></b></td>
    </tr>
</table>
</div>
<?php  
   
    //MOMO
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    if(isset($_POST['payUrl'])){
        //THong tin người mua
        $ten=$_POST['name'];
        $email=$_POST['mail'];
        $sdt=$_POST['mobi'];
        $diachi=$_POST['add'];
        $ngay_gio=date('Y-m-d H:i:s');
        // THông tin momo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $totalPriceAll;
        $orderId = time() . "";
        $redirectUrl = "http://localhost/DoAnWeb/index.php?page_layout=hoanthanh&ten=$ten&email=$email&sdt=$sdt&diachi=$diachi&ngay_gio=$ngay_gio";
        $ipnUrl = "http://localhost/DoAnWeb/index.php?page_layout=hoanthanh&ten=$ten&email=$email&sdt=$sdt&diachi=$diachi&ngay_gio=$ngay_gio";
        $extraData = "";
        // $ten=$_POST['name'];
        // $email=$_POST['mail'];
        // $sdt=$_POST['mobi'];
        // $diachi=$_POST['add'];
        // $ngay_gio=date('Y-m-d H:i:s');

        if (!empty($_POST)) {
            $partnerCode = $partnerCode;
            $accessKey = $accessKey;
            $serectkey = $secretKey;
            $orderId = $orderId; // Mã đơn hàng
            $orderInfo = $orderInfo;
            $amount = $amount;
            $ipnUrl = $ipnUrl;
            $redirectUrl = $redirectUrl;
            $extraData = $extraData;

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there

            header('Location: ' . $jsonResult['payUrl']);
        }
    }
    else if(isset($_POST['redirect'])){
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost/DoAnWeb/index.php?page_layout=muahang";
    $vnp_TmnCode = "TXT3KZ17";//Mã website tại VNPAY 
    $vnp_HashSecret = "EXRNCPTN8E5ORKZUF70S6OAL7RQ8KF1N"; //Chuỗi bí mật

    $vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = "Noi dung thanh toan";
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = 10000 * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];
    //BillingSS
    /////////////////////////////////////////////
    // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    // $vnp_Bill_Email = $_POST['txt_billing_email'];
    // $fullName = trim($_POST['txt_billing_fullname']);
    // if (isset($fullName) && trim($fullName) != '') {
    //     $name = explode(' ', $fullName);
    //     $vnp_Bill_FirstName = array_shift($name);
    //     $vnp_Bill_LastName = array_pop($name);
    // }
    // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
    // $vnp_Bill_City=$_POST['txt_bill_city'];
    // $vnp_Bill_Country=$_POST['txt_bill_country'];
    // $vnp_Bill_State=$_POST['txt_bill_state'];
    // // Invoice
    // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
    // $vnp_Inv_Email=$_POST['txt_inv_email'];
    // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
    // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
    // $vnp_Inv_Company=$_POST['txt_inv_company'];
    // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
    // $vnp_Inv_Type=$_POST['cbo_inv_type'];
    /////////////////////////////////////////////
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        // "vnp_ExpireDate"=>$vnp_ExpireDate
        ///////////////////////////////////////////
        // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
        // "vnp_Bill_Email"=>$vnp_Bill_Email,
        // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
        // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
        // "vnp_Bill_Address"=>$vnp_Bill_Address,
        // "vnp_Bill_City"=>$vnp_Bill_City,
        // "vnp_Bill_Country"=>$vnp_Bill_Country,
        // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
        // "vnp_Inv_Email"=>$vnp_Inv_Email,
        // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
        // "vnp_Inv_Address"=>$vnp_Inv_Address,
        // "vnp_Inv_Company"=>$vnp_Inv_Company,
        // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
        // "vnp_Inv_Type"=>$vnp_Inv_Type
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    // }

    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
        }
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
require 'ThemdonhangGuimail.php';
    if(isset($_POST['Cod'])){
        themDonHangVaGuiEmail($conn, $_POST['name'], $_POST['mail'], $_POST['mobi'], $_POST['add'], 'Cod');
    } 
?>
<div id="custom-form" class="col-md-6 col-sm-8 col-xs-12">
<form method="post">
    <div class="form-group">
        <label>Tên khách hàng</label>
        <input required type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label>Địa chỉ Email</label>
        <input required type="text" class="form-control" name="mail">
    </div>
    <div class="form-group">
        <label>Số Điện thoại</label>
        <input required type="text" class="form-control" name="mobi">
    </div>
    <div class="form-group">
        <label>Địa chỉ nhận hàng</label>
        <input required type="text" class="form-control" name="add">
    </div>
    <button class="btn btn-success btn-block" name="Cod">Mua hàng</button>
    <button name="redirect" class="btn btn-success btn-block">VNPay</button>
    <button name="payUrl" class="btn btn-success btn-block">MOMO</button>
</form>
</div>

