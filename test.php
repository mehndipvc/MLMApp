<?php
$filepath = 'test-image/1719416282142.jpg';
$logopath = 'test-image/logo.png';

// CREATE IMAGE FROM QR CODE
$QR = imagecreatefrompng($filepath);

// START TO DRAW THE IMAGE ON THE QR CODE
$logo = imagecreatefromstring(file_get_contents($logopath));
$QR_width = imagesx($QR);
$QR_height = imagesy($QR);

$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit in the QR Code
$logo_qr_width = $QR_width / 3;
$scale = $logo_width / $logo_qr_width;
$logo_qr_height = $logo_height / $scale;

$logo_resized = imagecreatetruecolor($logo_qr_width, $logo_qr_height);
imagealphablending($logo_resized, false);
imagesavealpha($logo_resized, true);
$transparent = imagecolorallocatealpha($logo_resized, 0, 0, 0, 127);
imagefill($logo_resized, 0, 0, $transparent);
imagecopyresampled($logo_resized, $logo, 0, 0, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

// Set the opacity
$opacity = 50; // 0 = fully transparent, 100 = fully opaque

// Merge the logo onto the QR code with specified opacity
imagecopymerge($QR, $logo_resized, ($QR_width - $logo_qr_width) / 2, ($QR_height - $logo_qr_height) / 2, 0, 0, $logo_qr_width, $logo_qr_height, $opacity);

// Output the image directly to the browser
header('Content-Type: image/png');
imagepng($QR);

// Free up memory
imagedestroy($QR);
imagedestroy($logo);
imagedestroy($logo_resized);
?>
