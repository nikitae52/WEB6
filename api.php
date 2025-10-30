<?php
$dataFile = 'glitch_data.json';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = file_get_contents('php://input');
    
    if (file_put_contents($dataFile, $data)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not write to file']);
    }
} 
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (file_exists($dataFile)) {
        $content = file_get_contents($dataFile);
        
        if (empty($content)) {
            echo json_encode(['text' => 'No data', 'css' => '.my-glitch { color: white; }']);
        } else {
            echo $content;
        }
    } else {
        echo json_encode(['text' => 'Default Text', 'css' => '.my-glitch { color: white; }']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
