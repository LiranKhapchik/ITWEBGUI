<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // מאפשר גישה מכל דף
header('Access-Control-Allow-Headers: Content-Type');

// הגדרת תיקיית הנתונים ויצירתה במידת הצורך
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// לוקחים את שם הקובץ המבוקש, או משתמשים בברירת מחדל
$fileName = isset($_GET['file']) ? $_GET['file'] : 'default';

// אבטחה: מוודאים ששם הקובץ מכיל רק אותיות, מספרים, ומקפים (מונע פריצות נתיבים)
$fileName = preg_replace('/[^a-zA-Z0-9_-]/', '', $fileName);
$filePath = $dataDir . '/' . $fileName . '.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // שמירת נתונים מתוך הבקשה
    $jsonData = file_get_contents('php://input');
    
    // מוודאים שהמידע הוא JSON תקין לפני ששומרים
    if (json_decode($jsonData) !== null) {
        file_put_contents($filePath, $jsonData);
        echo json_encode(["status" => "success", "file" => $fileName . '.json']);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    }
} else {
    // קריאת נתונים (GET)
    if (file_exists($filePath)) {
        echo file_get_contents($filePath);
    } else {
        // אם הקובץ עדיין לא קיים, מחזירים אובייקט ריק
        echo '{}';
    }
}
?>