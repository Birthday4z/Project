<?php
    session_start();
    require_once __DIR__ . '../../../vendor/autoload.php';

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    date_default_timezone_set("Asia/Bangkok");
    $date_time = date("Y-m-d h:i:sA");

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/tmp',
        ]),
        'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabun.ttf',
                'I' => 'THSarabun Italic.ttf',
                'B' => 'THSarabun Bold.ttf',
                'BI' => 'THSarabun Bold Italic.ttf'
            ]
        ],
        'default_font' => 'sarabun'
    ]);


    $data = "";
    $data .= '
    <p style="text-align: center;"><span style="font-size: 30px;"><strong>'.$_SESSION['TypePetition'].'</strong></span></p>
    <p style="text-align: center; line-height: 0.1;"><span style="font-size: 22px;"><strong>หอพัก Deliberant</strong></span></p>
    <p style="text-align: center; line-height: 0.1"><span style="font-size: 22px;"><strong>บ้านเลขที่18 ซอยประชาอุทิศ38 ถนนประชาอุทิศ แขวงบางมด เขตทุ่งครุ กรุงเทพมหานคร 10140</strong></span></p>
    <hr><br>';

    $data .= '
    <p><br></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">หมายเลขห้อง : '.$_SESSION['Room_ID'].'</span></strong></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">ชื่อเจ้าของห้อง : '.$_SESSION['Firstname'].' '.$_SESSION['Lastname'].'</span></strong></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">เบอร์ติดต่อ : '.$_SESSION['Phone'].'</span></strong></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">วันที่ยื่นคำร้อง : '.$_SESSION['Currentdate'].'</span></strong></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">วันที่ต้องการ : '.$_SESSION['Wantdate'].'</span></strong></p>
    <p style="margin-left: 80px; line-height: 1.5;"><strong><span style="font-size: 24px;">รายละเอียดเพิ่มเติม : '.$_SESSION['Description'].'</span></strong></p>
    <br><br><br><br><br><br>
    <p style="text-align: right; line-height: 0.5;"><strong><span style="font-size: 24px;">หอพัก Deliberant</span></strong></p>
    <p style="text-align: right;"><strong><span style="font-size: 24px;">'.$date_time.'</span></strong></p>';
    

    $mpdf->WriteHTML($data);
    $mpdf->Output();
?>