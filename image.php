<?php

require_once('koneksi.php');

$IdImage = $_GET['id'];

// $sql = mysqli_query($conn, "SELECT imagebase64 AS dataImage FROM db_master_image WHERE image_id = '$IdImage' GROUP BY dataImage");
$sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt, convert(imagebase64 USING utf8) AS dataImage FROM db_master_image WHERE image_id = '$IdImage' GROUP BY dataImage");
$row = mysqli_fetch_assoc($sql);

$ImageBase64 = $row['dataImage'];

// Output the image with appropriate content type header
header('Content-type: image/png');
echo base64_decode($ImageBase64);

// // header('Content-Type: image/png');

// // readfile($ImageBase64);

// mysqli_close($conn);

// Fetch the image data from the file path or base64 data
// $query = sprintf("SELECT COUNT(1) AS cnt, CONVERT(Base64Data USING utf8) AS dataImage FROM starpoin_image WHERE Filename = '%s' GROUP BY dataImage;", $NamaFile);
// $stmt = $db->query($query);
// $row = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($row) {
//     $cnt = $row['cnt'];
//     $dataImage = $row['dataImage'];

//     if ($cnt == "0") {
//         // Fetch image from file path
//         $imgFile = file_get_contents($pathimage . $NamaFile);
//         if ($imgFile === false) {
//             $errorMessage = "Error, Select Data starpoin_image | $query";
//             // dataLogImages("", $logData, $ip, $allHeader, $NamaFile, "1", "1", $errorMessage, $errorMessage, $c);

//             header("Content-Type: text/html");
//             echo $body; // Assuming $body contains the original data
//             return;
//         }

//         // Encode image data to base64
//         $dataImage = base64_encode($imgFile);
//     }

//     // Decode base64 data
//     $decoded_data = base64_decode($dataImage);
//     if ($decoded_data === false) {
//         $errorMessage = "Error, decode - data image | $query";
//         // dataLogImages("", $logData, $ip, $allHeader, $NamaFile, "1", "1", $errorMessage, $errorMessage, $c);

//         header("Content-Type: text/html");
//         echo $body; // Assuming $body contains the original data
//         return;
//     }

//     // Create a temporary file
//     $tempfile = tempnam(sys_get_temp_dir(), 'tempfile_');

//     // Write the decoded data to the temporary file
//     if (file_put_contents($tempfile, $decoded_data) === false) {
//         $errorMessage = "Error, Write to file - data image | $query";
//         // dataLogImages("", $logData, $ip, $allHeader, $NamaFile, "1", "1", $errorMessage, $errorMessage, $c);

//         header("Content-Type: text/html");
//         echo $body; // Assuming $body contains the original data
//         return;
//     }

//     // Set the appropriate content type header based on the file extension
//     $extension = strtoupper(pathinfo($tempfile, PATHINFO_EXTENSION));
//     if (strpos($extension, 'GIF') !== false) {
//         $content_type = 'image/gif';
//     } elseif (strpos($extension, 'PNG') !== false) {
//         $content_type = 'image/png';
//     } else {
//         $content_type = 'image/jpeg';
//     }

//     // Send the file to the client
//     header("Content-Type: $content_type");
//     readfile($tempfile);

//     // Delete the temporary file
//     unlink($tempfile);
// } else {
//     $errorMessage = "Error, Select Data starpoin_image | $query";
//     // dataLogImages("", $logData, $ip, $allHeader, $NamaFile, "1", "1", $errorMessage, $errorMessage, $c);

//     header("Content-Type: text/html");
//     echo $body; // Assuming $body contains the original data
// }
?>
