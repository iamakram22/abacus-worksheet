<?php
if (!isset($_GET['subject']))
    exit;

$subject = basename($_GET['subject']);
$baseDir = __DIR__ . '/' . $subject;
$response = [];

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getClasses':
            $dirs = array_filter(glob("{$baseDir}/*"), 'is_dir');
            $response = array_map('basename', $dirs);
            break;

        case 'getTopics':
            if (!isset($_GET['class']))
                break;
            $class = basename($_GET['class']);
            $dirs = array_filter(glob("{$baseDir}/{$class}/*"), 'is_dir');
            $response = array_map('basename', $dirs);
            break;

        case 'getFiles':
            if (!isset($_GET['class'], $_GET['topic']))
                break;
            $class = basename($_GET['class']);
            $topic = basename($_GET['topic']);
            $files = glob("{$baseDir}/{$class}/{$topic}/*.xlsx");
            $response = array_map('basename', $files);
            break;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
