<?php  
    session_start();
    if (isset($_POST['submit'])) {
        $id_sp = $_POST['id_sp'];
        $customText = $_POST['customText']; // Nhận văn bản tùy chỉnh
        $file = $_FILES['fileUpload']; // Nhận file hình ảnh

        // Xử lý hình ảnh: lưu vào thư mục và lưu đường dẫn vào session
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "File has been uploaded.";
        } else {
            echo "File upload failed.";
        }

        // Thêm vào giỏ hàng
        if (isset($_SESSION['giohang'][$id_sp])) {
            $_SESSION['giohang'][$id_sp] += 1;
        } else {
            $_SESSION['giohang'][$id_sp] = 1;
        }

        // Lưu văn bản tùy chỉnh và đường dẫn hình ảnh vào session
        $_SESSION['customText'][$id_sp] = $customText;
        $_SESSION['productImage'][$id_sp] = $target_file;

        header('location: ../../index.php?page_layout=giohang');
    } else {
        header('location: ../../index.php');
    }
?>
