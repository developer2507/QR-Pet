<?php
session_start();
ob_start();
// require_once 'vendor/autoload.php';
// require_once 'vendor/phpoffice/phpexel/Classes/PHPExcel.php';

require_once 'vendor/autoload.php';
require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require_once 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';
require_once 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet/Drawing.php';
use Endroid\QrCode\QrCode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


//Check Admin log in
if (!isset($_SESSION['admin']) & empty($_SESSION['admin'])) {
  header('Location: ../../../index.php');
}

//Log out function

  if (isset($_POST['logout']) & !empty($_POST['logout'])) {
      session_destroy();
      session_unset();
      header('Location: ../../../index.php');
  }


if (isset($_POST['submit'])) {
  // Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qrpet";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get data from MySQL database
$sql = "SELECT id, pet_id FROM pet_info";
$result = $conn->query($sql);

// Create PHPExcel object
$objPHPExcel = new PHPExcel();

// Set up headers for Excel file
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Selected Data');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'QR Code');

// Generate QR codes and write data to Excel file
$qrCode = new Endroid\QrCode\QrCode();
$row = 2;
while ($row_data = $result->fetch_assoc()) {
  $selected_data = $row_data['pet_id'];
  $id = $row_data['id'];
  
  

  // Generate QR code for selected data
  $qrCode->setText($selected_data);
  $qrCode->setSize(300);
  $qrCode->setMargin(10);
  $qrCode->setEncoding('UTF-8');
  $qrCodeImage = $qrCode->writeDataUri();

  // Convert QR code data URI to image
  // $qrCodeFile = $selected_data.'.png';
  // file_put_contents($qrCodeFile, file_get_contents($qrCodeImage));

  // Add QR code image to Excel file
  // $objDrawing = new PHPExcel_Worksheet_Drawing();
  // $objDrawing->setPath($qrCodeFile);
  // $objDrawing->setCoordinates('B'.$row);
  // $objDrawing->setWidth(150);
  // $objDrawing->setHeight(150);
  // $objDrawing->setOffsetX(-30); // Set the X offset to a negative value to align the image to the left
  // $objDrawing->setOffsetY(10);
  // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(180);

  // Create temporary image file from QR code data
  // $qrCodeImagePath = tempnam(sys_get_temp_dir(), $selected_data);
  $qrCodeFile = 'img/'.$selected_data.'.png';
  file_put_contents($qrCodeFile, file_get_contents($qrCodeImage));

  // Add QR code image to Excel file
  // $objDrawing = new PHPExcel_Worksheet_Drawing();
  // $objDrawing->setPath($qrCodeImagePath);
  // $objDrawing->setWidth(200);
  // $objDrawing->setHeight(200);
  // $objDrawing->setCoordinates('B'.$row);
  // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(180);
  // $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setPath($qrCodeFile);
  $objDrawing->setWidth(200);
  $objDrawing->setHeight(200);
  $objDrawing->setCoordinates('B'.$row);
  $objDrawing->setOffsetX(10);
  $objDrawing->setOffsetY(10);
  $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
  
  // Clear the cell value and set it to empty string
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(220);

  // Write data to Excel file
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $selected_data);
  // //$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $qrCodeImage);
  
  
  $row++;
}

// Set up headers for Excel file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="QR Codes.xlsx"');
header('Cache-Control: max-age=0');

// Save Excel file and download it
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
    <img src="img/0XL0RIK.png" width="200" height="200">
    <form action="" method="POST">
        <label>Enter count:</label>
        <button type="submit" name="submit">Exel file</button>
    </form>

    <form action="" method="post">
        <input type="submit" name="logout" value="Log out">
    </form>


    <ul>
      <li><a href="../admin.php">Add users</a></li>
      <li><a href="generate-exel.php">Generate QR Exel File</a></li>
    </ul>
 </body>
 </html>