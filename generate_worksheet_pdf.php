<?php
// Include mPDF library
require_once __DIR__ . '/vendor/autoload.php';

// Retrieve content from URL parameter
$encoded_content = $_GET['content'];
$content = urldecode($encoded_content);

// Create a new mPDF object
$mpdf = new \Mpdf\Mpdf();

// Add a page
$mpdf->AddPage();

// Write content to PDF
$mpdf->WriteHTML($content);

// Output the PDF as a download
$mpdf->Output('worksheet.pdf', 'D');
