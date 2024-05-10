<?php
$sql = "SELECT COUNT(DISTINCT id_dh) as tong_dh FROM donhang";
$result = mysqli_query($conn, $sql);

$sql_bl = "SELECT COUNT(DISTINCT id_bl) as tong_bl FROM blsanpham";
$result_bl = mysqli_query($conn, $sql_bl);

$sql_tv = "SELECT COUNT(DISTINCT id_thanhvien) as tong_tv FROM thanhvien";
$result_tv = mysqli_query($conn, $sql_tv);

$sql_khach = "SELECT COUNT(DISTINCT ip_address) as lan_truy_cap FROM khach";
$result_khach = mysqli_query($conn, $sql_khach);


?>


<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active"></li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Trang chủ quản trị</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-blue panel-widget ">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large"><?php 
                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "" . $row["tong_dh"];
                            }
                        } else {
                            echo "0";
                        }
                    ?></div>
                    <div class="text-muted">Đơn hàng</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-orange panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">
                    <?php 
                        if (mysqli_num_rows($result_bl) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result_bl)) {
                                echo "" . $row["tong_bl"];
                            }
                        } else {
                            echo "0";
                        }
                    ?>

                    </div>
                    <div class="text-muted">Bình luận</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-teal panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">
                    <?php 
                        if (mysqli_num_rows($result_tv) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result_tv)) {
                                echo "" . $row["tong_tv"];
                            }
                        } else {
                            echo "0";
                        }
                    ?>

                    </div>
                    <div class="text-muted">Thành viên</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-red panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">
                    <?php 
                        $i;
                        if (mysqli_num_rows($result_khach) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result_khach)) {
                                echo "" . $row["lan_truy_cap"];
                                // $i = $row["lan_truy_cap"];
                            }
                        } else {
                            echo "0";
                        }
                    ?>

                    </div>
                    <div class="text-muted">Người xem</div>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Cửa hàng</div>
            <div class="panel-body">
                <div style="widt: 1000;align-items: center; " class="canvas-wrapper">

                   <!-- <img style=  "width: 100%; height: 50%; " , src="anh/Slide_QuangCao.jpg" alt=""> -->


                   <head>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawVisualization);

                    <?php 
                        // truy vấn cơ sở dữ liệu để lấy dữ liệu
                        $currentMonth = date(6); // Lấy tháng hiện tại
                        $currentYear = date('Y'); // Lấy năm hiện tại
                        $result = mysqli_query($conn, "SELECT sum(gia_tien) as Gia_dh, ngay_gio FROM donhang WHERE MONTH(ngay_gio) = '$currentMonth' AND YEAR(ngay_gio) = '$currentYear' GROUP BY DATE(ngay_gio)");


                        // tạo mảng dữ liệu từ kết quả truy vấn
                        $data = array(
                            array('Ngày', 'Doanh thu'),
                        );
                        while ($row = mysqli_fetch_array($result)) {
                            $data[] = array($row['ngay_gio'], (int)$row['Gia_dh']);
}
                    ?>
                    function drawVisualization() {
                        // Some raw data (not necessarily accurate)
                        var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

                        var options = {
                        title : 'Biểu đồ thông kê doanh số của JERSEY CUSTOM',
                        // vAxis: {title: 'Cups'},
                        hAxis: {title: 'Tháng <?php echo $currentMonth ?> năm <?php echo $currentYear ?>'},
                        seriesType: 'bars',
                        series: {5: {type: 'line'}}
                        };

                        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                    }
                    </script>
                </head>
                <body>
                    <div id="chart_div" style="width: 100%; height: 500px;"></div>
                </body>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->
