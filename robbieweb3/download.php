<?php
// Check if file and type parameters exist
if(isset($_GET['file']) && isset($_GET['type'])) {
    $file = $_GET['file'];
    $type = $_GET['type'];
    
    // Validate file type (for security)
    $validFiles = [
        'free' => ['safaricom_free.hc', 'airtel_free.hc'],
        'premium' => ['safaricom_unlimited_ip.hc', 'safaricom_unlimited_noip.hc', 'all_capped_bundle.hc']
    ];
    
    // Check if user has access to premium files
    if($type === 'premium') {
        session_start();
        if(!isset($_SESSION['premium_access'])) {
            die('You need premium access to download this file');
        }
    }
    
    // Check if file exists in the valid files list
    if(in_array($file, $validFiles[$type])) {
        $filepath = 'configs/' . $file;
        
        if(file_exists($filepath)) {
            // Set headers for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            die('File not found');
        }
    } else {
        die('Invalid file request');
    }
} else {
    die('Invalid request');
}
?>