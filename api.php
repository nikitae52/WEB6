<?php
// Файл, який ми використовуємо як БД
$dataFile = 'glitch_data.json';

// Завжди відповідаємо у форматі JSON
header('Content-Type: application/json');

// --- 1. ОБРОБКА POST (ЗБЕРЕЖЕННЯ) ---
// Коли creator.html надсилає дані
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Отримуємо JSON-дані, які надіслав JavaScript
    $data = file_get_contents('php://input');
    
    // Зберігаємо ці дані у наш файл
    // file_put_contents перезапише файл новими даними
    if (file_put_contents($dataFile, $data)) {
        // Якщо збереглося, кажемо JS, що все добре
        echo json_encode(['status' => 'success']);
    } else {
        // Якщо сталася помилка (наприклад, через права доступу)
        echo json_encode(['status' => 'error', 'message' => 'Could not write to file']);
    }
} 
// --- 2. ОБРОБКА GET (ЧИТАННЯ) ---
// Коли display.html запитує дані
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (file_exists($dataFile)) {
        // Якщо файл існує, читаємо його вміст
        $content = file_get_contents($dataFile);
        
        // Перевіряємо, чи не порожній він
        if (empty($content)) {
            // Якщо порожній, віддаємо текст за замовчуванням
            echo json_encode(['text' => 'No data', 'css' => '.my-glitch { color: white; }']);
        } else {
            // Якщо не порожній, віддаємо збережені дані
            echo $content;
        }
    } else {
        // Якщо файлу ще немає, віддаємо текст за замовчуванням
        echo json_encode(['text' => 'Default Text', 'css' => '.my-glitch { color: white; }']);
    }
} else {
    // Якщо це не POST або GET запит
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>