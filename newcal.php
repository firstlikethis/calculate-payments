<?php
    header('Content-Type: text/html; charset=UTF-8');

    $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    $contracts = isset($_POST['contracts']) ? $_POST['contracts'] : '';

    $phase = 0;
    $phase2 = 0;
    $phase3 = 0;
    $total_phase = '';
    $total_phase2 = '';
    $total_phase3 = '';

    $ag = 0; //วัน
    $ag2 = 0; //เดือน
    $ag3 = 0; //ปี
    $maxMonth = 12; // max เดือน
    $maxYear = 65; // max ปี
    $tt1_month = 0; //total1 month 30/31
    $tt2_month = 0; //total2 month 30/31
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sp_phase1 = explode('/', $birthday);

        if (count($sp_phase1) >= 3) {
            try {
                //Array from birthday
                $sp1_day = (int)$sp_phase1[0];  
                $sp1_month = (int)$sp_phase1[1];
                $sp1_year = (int)$sp_phase1[2];

                

                //หาวันจ่ายงวดแรก
                $sp_phase2 = explode('/', $contracts);
                $sp2_day = (int)$sp_phase2[0];
                $sp2_month = (int)$sp_phase2[1];
                $sp2_year = (int)$sp_phase2[2];

                if($sp1_month == 1 || $sp2_month == 1){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 2 || $sp2_month == 2){
                    $tt1_month = 28;
                    $tt2_month = 28;
                }elseif($sp1_month == 3 || $sp2_month == 3){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 4 || $sp2_month == 4){
                    $tt1_month = 30;
                    $tt2_month = 30;
                }elseif($sp1_month == 5 || $sp2_month == 5){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 6 || $sp2_month == 6){
                    $tt1_month = 30;
                    $tt2_month = 30;
                }elseif($sp1_month == 7 || $sp2_month == 7){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 8 || $sp2_month == 8){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 9 || $sp2_month == 9){
                    $tt1_month = 30;
                    $tt2_month = 30;
                }elseif($sp1_month == 10 || $sp2_month == 10){
                    $tt1_month = 31;
                    $tt2_month = 31;
                }elseif($sp1_month == 11 || $sp2_month == 11){
                    $tt1_month = 30;
                    $tt2_month = 30;
                }else{
                    $tt1_month = 31;
                    $tt2_month = 31;
                }
                echo $tt1_month;
                echo $tt2_month;


                $in1 = 0;
                $in2 = 0;
                $in3 = 0;

                if ($sp2_day != 0) {
                    $in1 = 5;
                    $in2 = $sp2_month + 1;
                    $in3 = $sp2_year;

                    if ($in2 > 12) {
                        $in1 = 5;
                        $in2 = 1;
                        $in3 = $sp2_year + 1;
                    }
                    //ผลลัพท์ของวันที่เริ่มต้นชำระ
                    $total_phase = $in1 . '/' . $in2 . '/' . $in3;



                    //หาวันเกิด
                    if($sp1_day > $sp2_day){ //หาวัน
                        echo '<br>u1';
                        $ag = ($tt1_month + $sp2_day) - $sp1_day;
                    } elseif ($sp1_day < $sp2_day){
                        echo '<br>u2';
                        $ag = $sp2_day - $sp1_day;
                    } elseif ($sp1_day == $sp2_day){
                        echo '<br>u3';
                        $ag = 0;
                    }

                    if ($sp1_month != 0 || $sp2_month != 0) { //หาเดือนและปี
                        if ($sp1_month > $sp2_month) {
                            echo '<br>1';
                            $ag2 = (($sp1_month + $sp2_month) + 1) - $maxMonth;
                            $ag3 = ($sp2_year - $sp1_year) - 1;
                            
                            if($sp2_month < $sp1_month && $sp2_day > $sp1_day){ //กรณีเดือน = 1 และ วันที่มากกว่า วันที่ปัจจุบันมากกว่า วันที่เกิด
                                echo '<br>1.1.1';
                                $ag2 = ($tt1_month - ($sp2_month + $sp1_month) +1); //นำเดือนมา - 12 และ +1
                                $ag3 = ($sp2_year - $sp1_year) - 1; //นำปีมาลบกัน แล้วตัดออก 1 
                            }elseif($sp1_day == $sp2_day && $sp1_month > $sp2_month){
                                echo '<br>1.1.2';
                                $ag2 = (($sp1_month + $sp2_month)) - $maxMonth;
                                $ag3 = ($sp2_year - $sp1_year) - 1;
                            }elseif($sp1_day > $sp2_day && $sp1_month > $sp2_month){
                                echo '<br>1.1.3';
                                $ag2 = (($sp1_month + $sp2_month) - 1) - $maxMonth;
                                $ag3 = ($sp2_year - $sp1_year) - 1;
                            }

                        } else {
                            echo '<br>  2';
                            if ($sp2_month > $sp1_month && $sp1_day > $sp2_day) { // กรณีเดือนปัจจุบัน > เดือนเกิด และวันที่ของวันเกิด มากกว่า วันปัจจุบัน
                                echo '<br>2.1';
                                $ag2 = ($sp2_month - $sp1_month) - 1;
                                $ag3 = ($sp2_year - $sp1_year);
                            } elseif ($sp2_month == $sp1_month && $sp2_day < $sp1_day){ //กรณีเดือนเท่ากัน และวันปัจจุบันน้อยกว่าวันที่เกิด
                                echo '<br>2.3';
                                $ag2 = 11;
                                $ag3 = ($sp2_year - $sp1_year) - 1;
                            }  elseif ($sp2_month == $sp1_month && $sp2_day == $sp1_day){ //กรณีวันเกิดเป๊ะๆ
                                echo '<br>2.4';
                                $ag3 = ($sp2_year - $sp1_year);  
                            } elseif ($sp2_month == $sp1_month && $sp2_day > $sp1_day){  //กรณีเดือนเท่ากัน แต่วันที่ปัจจุบันมากกว่าวันที่เกิด
                                echo '<br>2.5';
                                $ag3 = ($sp2_year - $sp1_year);
                            } elseif ($sp2_month > $sp1_month && $sp2_day > $sp1_day) { //กรณีเดือนปัจจุบันมากกว่า และ วันที่ปัจจุบันมากกว่า
                                echo '<br>2.6';
                                $ag2 = $sp2_month - $sp1_month;
                                $ag3 = ($sp2_year - $sp1_year);
                            } elseif ($sp1_month < $sp2_month && $sp1_day > $sp2_day){ //กรณีเดือนปัจจุบันมากกว่า แต่วันที่เกิดมากกว่า
                                echo '<br>2.7';
                                $ag = $tt1_month - ($sp1_day + $sp2_day);
                                $ag2 = ($sp2_month - $sp1_month) - 1;
                                $ag3 = ($sp2_year - $sp1_year);
                            }elseif($sp1_day == $sp2_day && $sp1_month < $sp2_month){
                                echo '<br>2.8';
                                $ag2 = $sp2_month - $sp1_month;
                                $ag3 = ($sp2_year - $sp1_year);
                            }
                        }
                    }



                    //หาวันสิ้นสุดการชำระเงิน
                    if ($sp1_day <= 4) {
                        $sp1_month = $sp1_month - 1;
                    } elseif ($sp1_day >= 5) {
                        $sp1_month = $sp1_month + 1;

                        if ($sp1_month >= $maxMonth) {
                            $sp1_month = 1;
                            $sp1_year = $sp1_year + 1;
                        }
                    }


                }
            } catch (Exception $e) {
               //ไม่แสดง เฉยๆนี่แหละ
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title></title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: Arial, sans-serif;
    }

    .container {
        width: 500px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;width:500px;">
        <div class="container">
            <form method="post" action="newcal.php">
                <div class="mb-3">
                    <label for="birthday" class="form-label">วันเกิด<p style="color:red;">(dd/mm/yyyy)</p></label>
                    <input type="text" name="birthday" id="birthday" class="form-control"
                        value="<?php echo $birthday; ?>">
                </div>

                <div class="mb-3">
                    <label for "contracts" class="form-label">วันที่ทำสัญญา<p style="color:red;">(dd/mm/yyyy)</p></label>
                    <input type="text" name="contracts" id="contracts" class="form-control"
                        value="<?php echo $contracts; ?>">
                </div>

                <div class="mb-3">
                    <label for="moneyParam" class="form-label">จำนวนเงิน</label>
                    <input type="text" name="moneyParam" id="moneyParam" class="form-control" value="">
                </div>

                <div class="text-center">
                    <button type="submit" id="button" name="button" class="btn btn-primary">ยืนยัน</button>
                </div>
            </form>
            <div class="col-lg-12 pt-5 m-0">
                <p>วันเกิด: <?php echo $birthday; ?></p>
                <p>อายุ: <?php echo $ag3; ?> ปี <?php echo ($ag2 == 0) ? '' : $ag2 . ' เดือน'; ?> <?php echo $ag; ?> วัน
                </p>
                <p>วันที่ทำสัญญา: <?php echo $contracts; ?></p>
                <p>วันที่เริ่มต้นชำระเงิน: <?php echo $total_phase; ?></p>
                <p>วันที่สิ้นสุดการชำระเงิน: <?php echo $total_phase2; ?></p>
                <p>จำนวนเงินต่องวด</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.3/i18n/th.json"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js">
    </script>
</body>

</html>