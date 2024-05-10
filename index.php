<?php  
    ob_start();
    session_start();
    include_once './cauhinh/ketnoi.php';
    $ip_address = $_SERVER["REMOTE_ADDR"];
    $page_accessed = $_SERVER["REQUEST_URI"];

    $sql = "INSERT INTO khach (ip_address, trang_truy_cap) VALUES ('$ip_address', '$page_accessed')";
    mysqli_query($conn, $sql);

    if( !isset($_SESSION['email']) || ($_SESSION['email']!='a@gmail.com' && $_SESSION['pass']!='a')){
        
?>
<html>
    <head><title>JERSEY CUSTOM - thời trang bất diệt</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
           <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="chatbot.js"></script>
        <link rel="stylesheet" href="css/style.css">    
        <?php
            if(isset($_GET['page_layout'])){
            switch ($_GET['page_layout']) {
                case 'danhsachtimkiem':
                    echo '<link rel="stylesheet" href="css/danhsachtimkiem.css">';
                    break;
                case 'danhsachsp':
                    echo '<link rel="stylesheet" href="css/danhsachsp.css">';
                    break;
                case 'chitietsp':
                    echo '<link rel="stylesheet" href="css/chitietsp.css">';
                    break;
                case 'giohang':
                    echo '<link rel="stylesheet" href="css/giohang.css">';
                    break;              
                case 'muahang':
                    echo '<link rel="stylesheet" href="css/muahang.css">';
                    break;
                case 'hoanthanh':
                    echo '<link rel="stylesheet" href="css/hoanthanh.css">';
                    break;
                }
            }

        ?>
    </head>
    <body>
        <div class="container">
            <!-- Header -->
            <div id="header">
                <div class="row">
                    <!-- search -->
                    <?php  
                        include_once './chucnang/timkiem/timkiem.php';
                    ?>
                    <!-- end search -->
                    <?php  
                        include_once './chucnang/login/login.php';
                    ?>
                    <!-- y-cart -->
                    <?php  
                        include_once './chucnang/giohang/giohangcuaban.php';
                    ?>
                    <!-- end y-cart -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Banner  -->
            <div id="banner">
                <div class="row">           
                    <div style="width: 220px", id="logo" class="col-md-4 col-sm-12 col-xs-12">
                        <h1>
                            <a href="index.php">
                                <img style="width: 220px" src="images/Logo2.jpg">
                            </a>
                        </h1>
                    </div>
                    <div id="ship" class="col-md-8 col-sm-12 col-xs-12">
                    <div style="width: 920px" class="quang_cao">
            <marquee behavior="scroll" direction="left" scrollamount="18">
                <img src="images/uudainho_result.webp" alt="">
                <img src="images/uudainho2_result.webp" alt="">
                <img src="images/uudainho3_result.webp" alt="">
            </marquee>
        </div>
                    </div>            
                </div>        
            </div>
            <!-- End Banner -->

            <!-- Body -->
            <div id="body">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php  
                        include_once './chucnang/sanpham/danhmucsp.php';
                        include_once './chucnang/quangcao/quangcao.php';
                        include_once './chucnang/thongke/thongke.php';
                        ?>
                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <?php  
                        include_once './chucnang/slideshow/slideshow.php';
                        ?>

                        <div id="main">
                            <?php
                            if(isset($_GET['page_layout'])){
                                switch ($_GET['page_layout']) {
                                case 'danhsachtimkiem':
                                    include_once './chucnang/timkiem/danhsachtimkiem.php';
                                    break;
                                case 'danhsachsp':
                                    include_once './chucnang/sanpham/danhsachsp.php';
                                    break;
                                case 'chitietsp':
                                    include_once './chucnang/sanpham/chitietsp.php';
                                    break;
                                case 'giohang':
                                    include_once './chucnang/giohang/giohang.php';
                                    break;
                                case 'muahang':
                                    include_once './chucnang/giohang/muahang.php';
                                    break;
                                case 'hoanthanh':
                                    include_once './chucnang/giohang/hoanthanh.php';
                                    break;
                                }
                            }else{
                                include_once './chucnang/sanpham/sanpham.php';
                            }
                            
                            ?>
                        </div>

                        
                    </div>
                </div>
            </div>  
            <!-- End Body -->
            <h1>Chatbot JERSEY CUSTOM   </h1>

<div class="chat-container" style = "
    height: 400px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
">
    <ul id="chatlog"></ul>
</div>

<input type="text" id="userInput" style="width: 100%; height: 30px; padding-left: 10px" placeholder="Đặt câu hỏi cho tôi...">
            <div id="brand">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img style=" width: 100%" class="img-thumbnail" src="images/banner1.jpg">
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div id="footer">
                <div class="row">
                    <div id="footer-main" class="col-md-12 col-sm-12 col-xs-12">
                        <h4>.......................................................................</h4>
                        <p><b>
                        JERSEY CUSTOM là thương hiệu bán điện thoại trực tuyến hàng đầu dành cho khách hàng, khai thác các khía cạnh độc đáo trên các thiết kế nhằm tạo ra các bộ sưu tập mới mỗi tháng. Các kết hợp giữa công nghệ tiên tiến và phong cách hiện đại, trên các sản phẩm vốn quen thuộc như smartphone, điện thoại di động, máy tính bảng,... Các sản phẩm tại JERSEY CUSTOM luôn mang đến sự đột phá, khác biệt và nổi bật dành cho các tín đồ công nghệ tại Việt Nam.</b> 
<br></p> 
                        <p><b>Cơ sở 1:</b> JERSEY CUSTOM STORE - 468 LÊ VĂN SỸ - QUẬN 3 | <b>Hotlin</b>e 0962734142</p>
                        <p><b>Cơ sở 2:</b> Đại học Điện lực | <b>Hotlin</b>e 0962734142</p>
                    </div>   
                </div>
            </div>
            <!-- End Footer -->
        </div>

    </body>
</html>
<?php  
    }
    else{
        header('location: ./quantri/quantri.php');
    }
?>
<script>
// Lấy các phần tử DOM cần thiết
const userInput = document.getElementById('userInput');//lấy tham chiếu đến phần tử input có id là "userInput" trong HTML và gán nó vào biến userInput. 
const chatlog = document.getElementById('chatlog');// lấy tham chiếu đến phần tử ul có id là "chatlog" trong HTML và gán nó vào biến chatlog

// Gán sự kiện "Enter" khi người dùng nhấn phím
userInput.addEventListener('keydown', function(event) {
    if (event.keyCode === 13) {
        const message = userInput.value;
        MessageUser(message);
        ChatbotRep(message);
    }
});

// Hiển thị tin nhắn của người dùng trong chatlog
function MessageUser(message) {
    const listItem = document.createElement('li');
    listItem.innerHTML = '<strong>You:</strong> ' + message;
    chatlog.appendChild(listItem); //đặt nội dung là tin nhắn của người dùng và thêm phần tử này vào danh sách chatlog.
    userInput.value = '';
}

// Tạo phản hồi từ chatbot (có thể chỉ là các phản hồi cứng cố định trong ví dụ này)
function ChatbotRep(message) {
    const response = getBotResponse(message);
    displayBotMessage(response);
}

// Hiển thị tin nhắn của chatbot trong chatlog
function displayBotMessage(message) {
    const listItem = document.createElement('li');
    listItem.innerHTML = '<strong>Chatbot:</strong> ' + message;
    chatlog.appendChild(listItem);
}

// Gửi yêu cầu API để lấy phản hồi từ chatbot
function getBotResponse(message) {
    const lowerCaseMessage = message.toLowerCase();
    if (lowerCaseMessage.includes('xin chào')) {
        return 'Xin chào! Tôi có thể giúp gì cho bạn hôm nay?';
    } else if (lowerCaseMessage.includes('thế nào')) {
        return 'Tôi là một trí tuệ nhân tạo, nên tôi không có cảm xúc, nhưng cảm ơn bạn đã hỏi! Tôi có thể giúp gì cho bạn?';
    } else if (lowerCaseMessage.includes('điện thoại')) {
        return 'Tất nhiên, tôi có thể giúp bạn với vấn đề đó. Bạn cần thông tin cụ thể về điện thoại gì?';
    } else if (lowerCaseMessage.includes('mua')) {
        return 'Tuyệt vời! Chúng tôi có rất nhiều loại điện thoại để lựa chọn. Bạn có thể cung cấp thêm thông tin về loại điện thoại mà bạn quan tâm không?';
    } else if (lowerCaseMessage.includes('ship hàng')||lowerCaseMessage.includes('ship')) {
        return 'Chúng tôi có dịch vụ giao hàng toàn quốc. Bạn vui lòng cung cấp địa chỉ giao hàng của bạn để chúng tôi có thể tính phí và thời gian giao hàng chính xác cho bạn.';
    } else if (lowerCaseMessage.includes('phí giao hàng')) {
        return 'Phí giao hàng sẽ phụ thuộc vào địa chỉ giao hàng của bạn và trọng lượng sản phẩm. Bạn vui lòng cung cấp thông tin cụ thể để chúng tôi có thể tính toán phí giao hàng chính xác cho bạn.';
    } else if (lowerCaseMessage.includes('thời gian giao hàng')) {
        return 'Thời gian giao hàng sẽ phụ thuộc vào địa chỉ giao hàng của bạn và phương thức vận chuyển. Bạn vui lòng cung cấp thông tin cụ thể để chúng tôi có thể cung cấp thời gian giao hàng chính xác cho bạn.';
    } else if (lowerCaseMessage.includes('samsung s23')) {
        return 'Samsung Galaxy S23 và S23 Plus là hai phiên bản mới trong dòng điện thoại cao cấp của Samsung [1]. Chiếc S23 Plus có màu Tím Lilac và được thiết kế với một mặt lưng đứng thẳng, trong khi một chiếc khác có cạnh bên hiển thị thiết kế camera nổi bật [1]. Về thông số kỹ thuật, Samsung Galaxy S23 được trang bị màn hình AMOLED 120Hz, gồm phiên bản Galaxy S23 Ultra với ba camera [2]. Ngoài ra, điện thoại này còn sử dụng các vật liệu thân thiện với môi trường như thuỷ tinh tái chế và màng PET, giúp tăng tính thẩm mỹ và bảo vệ môi trường [3]. Để biết thêm thông tin chi tiết và các thông số kỹ thuật khác về Samsung Galaxy S23, bạn có thể truy cập vào trang web chính thức của Samsung [1] [2] [3].';
    } else {
        return 'Xin lỗi, nhưng tôi không hiểu tin nhắn của bạn.';
    }
}


</script>
