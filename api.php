<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// Default Seed Data
$defaultTips = [
    "לפני שפותחים קריאה על מדפסת, ודאו שיש נייר והיא דלוקה! בדיקה בסיסית חוסכת זמן לכולנו.",
    "אין גישה לתיקיית רשת? הפעלה מחדש (Restart) פותרת 90% מהבעיות האלו באופן מיידי.",
    "סיסמה נעולה? ניתן לאפסה דרך אתר אופק לפעולות בשירות עצמי.",
    "ככל שתפרטו יותר בקריאת השירות (כולל צילום מסך אם אפשר), ככה נפתור אותה מהר יותר.",
    "הסיסמה לא עובדת? ודאו ש-Caps Lock כבוי ושהמקלדת בשפה הנכונה."
];

$defaultTeam = [
    [
        'personalId' => '7777777', 'name' => 'לירן', 'rank' => 'סמ״ר', 'profession' => 'מנהל רשת ותשתיות',
        'sapir' => '518-3508', 'email' => 'S9117951@IDF.IL', 'isKave' => true, 'photo' => 'images/file.png',
        'quotes' => [], 'tags' => []
    ],
    [
        'personalId' => '1111111', 'name' => 'מאיה', 'rank' => 'אע״צ', 'profession' => 'פסיכולוגית (מפקדת הצוות)',
        'sapir' => '518-2526', 'email' => 'C9812810@IDF.IL', 'isKave' => false, 'photo' => 'images/mayafile.jpeg',
        'quotes' => [], 'tags' => []
    ],
    [
        'personalId' => '2222222', 'name' => 'ראובן', 'rank' => 'רב״ט', 'profession' => 'תמיכת חומרה',
        'sapir' => '518-2021', 'email' => 'S9311294@IDF.IL', 'isKave' => false, 'photo' => 'images/filrReuven.jpg',
        'quotes' => [], 'tags' => []
    ],
    [
        'personalId' => '3333333', 'name' => 'חיים', 'rank' => 'סמל', 'profession' => 'טכנאי רשתות',
        'sapir' => '518-2021', 'email' => 'S9298128@IDF.IL', 'isKave' => false, 'photo' => '',
        'quotes' => [], 'tags' => []
    ],
    [
        'personalId' => '4444444', 'name' => 'ניקולאי', 'rank' => 'רב״ט', 'profession' => 'איש תמיכה בחומרה',
        'sapir' => '518-2021', 'email' => 'S9664735@IDF.IL', 'isKave' => false, 'photo' => '',
        'quotes' => [], 'tags' => []
    ]
];

$defaultInventory = [
    [
        'id' => 'inv-1', 'name' => 'עכבר חוטי', 'catalogCode' => '518-5541', 'masha' => '518-5541',
        'minQty' => 5, 'threshold' => 5, 'totalQty' => 15, 'qty' => 15, 'serials' => [], 'category' => 'exempt'
    ],
    [
        'id' => 'inv-2', 'name' => 'מקלדת עברית/אנגלית', 'catalogCode' => '518-5542', 'masha' => '518-5542',
        'minQty' => 10, 'threshold' => 10, 'totalQty' => 8, 'qty' => 8, 'serials' => [], 'category' => 'exempt'
    ]
];

$defaultTickets = [
    [
        'id' => 'TCK-2041', 'title' => 'אין תקשורת לעמדת מחשב', 'building' => 'snunit', 'room' => 'חדר מאבחנות',
        'station' => '2', 'status' => 'open', 'desc' => 'כבל רשת קרוע', 'date' => '14/06/2026 08:30',
        'createdAt' => '14/06/2026, 08:30', 'faultType' => 'hardware', 'component' => 'כבל תקשורת',
        'assignedTo' => 'לירן', 'phone' => '518-3508', 'mchRows' => [], 'events' => []
    ],
    [
        'id' => 'TCK-2042', 'title' => 'מדפסת נתקעה', 'building' => 'ofroni', 'room' => 'כיתה ימנית',
        'station' => '2', 'status' => 'open', 'desc' => 'נייר נתקע במדפסת 1', 'date' => '14/06/2026 09:15',
        'createdAt' => '14/06/2026, 09:15', 'faultType' => 'hardware', 'component' => 'מדפסת',
        'assignedTo' => 'ראובן', 'phone' => '518-4455', 'mchRows' => [], 'events' => []
    ]
];

$defaultState = [
    'systemStatus' => 'ok',
    'tips' => $defaultTips,
    'contacts' => [],
    'predefinedFaults' => [],
    'disabledStations' => [],
    'roomsConfig' => null,
    'categoryIcons' => null,
    'tickets' => $defaultTickets,
    'team' => $defaultTeam,
    'inventory' => $defaultInventory
];

$defaultShifts = [
    'soldiers' => [
        ['name' => "ראובן", 'role' => "mashak", 'color' => "#7dd3fc"],
        ['name' => "חיים", 'role' => "mashak", 'color' => "#93c5fd"],
        ['name' => "ניקולאי", 'role' => "mashak", 'color' => "#ddd6fe"],
        ['name' => "אריאל דגן", 'role' => "meavchenet", 'color' => "#fca5a5"],
        ['name' => "אריאל פרץ", 'role' => "meavchenet", 'color' => "#fcd34d"],
        ['name' => "גל", 'role' => "meavchenet", 'color' => "#86efac"],
        ['name' => "יהב", 'role' => "meavchenet", 'color' => "#cbd5e1"],
        ['name' => "עדן", 'role' => "meavchenet", 'color' => "#fdba74"],
        ['name' => "רונה", 'role' => "meavchenet", 'color' => "#bef264"],
        ['name' => "הילה", 'role' => "meavchenet", 'color' => "#c084fc"],
        ['name' => "שני", 'role' => "meavchenet", 'color' => "#fda4af"],
        ['name' => "שיר", 'role' => "meavchenet", 'color' => "#fde047"]
    ],
    'constraints' => new stdClass(),
    'assignments' => new stdClass(),
    'swaps' => new stdClass(),
    'justice' => [
        'month' => (int)date('n') - 1,
        'year' => (int)date('Y'),
        'counts' => new stdClass(),
        'debtLedger' => []
    ]
];

// Endpoint resolution
$fileParam = isset($_GET['file']) ? $_GET['file'] : 'default';
$fileParam = preg_replace('/[^a-zA-Z0-9_-]/', '', $fileParam);
$filePath = $dataDir . '/' . $fileParam . '.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    
    // Check for image upload first
    if ($fileParam === 'upload_image') {
        if (!isset($_FILES['image'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No image file provided"]);
            exit;
        }
        
        $file = $_FILES['image'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Upload failed with error code: " . $file['error']]);
            exit;
        }
        
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "File is not an image"]);
            exit;
        }
        
        $uploadDir = __DIR__ . '/images/kb';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid image extension"]);
            exit;
        }
        
        $filename = 'step_' . uniqid() . '_' . time() . '.' . $ext;
        $destPath = $uploadDir . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            echo json_encode([
                "status" => "success", 
                "url" => "images/kb/" . $filename
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to save file"]);
        }
        exit;
    }

    // Special behavior for sync_store setting save
    if ($fileParam === 'sync_store') {
        $inputData = json_decode($jsonData, true);
        if (isset($inputData['key'])) {
            $key = $inputData['key'];
            $val = $inputData['value'] ?? '';
            
            $storeData = [];
            if (file_exists($filePath)) {
                $storeData = json_decode(file_get_contents($filePath), true) ?: [];
            }
            $storeData[$key] = $val;
            file_put_contents($filePath, json_encode($storeData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            echo json_encode(["status" => "success"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing key"]);
        }
        exit;
    }

    // Otherwise, generic JSON writing
    $inputData = json_decode($jsonData, true);
    if ($inputData !== null || empty($jsonData)) {
        // Special case for user profiles to merge/update rather than overwrite completely
        if ($fileParam === 'user_profiles' && is_array($inputData)) {
            $existingProfiles = [];
            if (file_exists($filePath)) {
                $existingProfiles = json_decode(file_get_contents($filePath), true) ?: [];
            }
            foreach ($inputData as $key => $p) {
                $id = $p['id'] ?? str_replace('user_', '', $key);
                if ($id) {
                    $existingProfiles['user_' . $id] = $p;
                }
            }
            file_put_contents($filePath, json_encode($existingProfiles, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        } else {
            file_put_contents($filePath, json_encode($inputData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo json_encode(["status" => "success"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    }
} else {
    // GET requests
    if ($fileParam === 'mch_state') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode($defaultState, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo file_get_contents($filePath);
    } 
    elseif ($fileParam === 'shifts_board_main') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode($defaultShifts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo file_get_contents($filePath);
    } 
    elseif ($fileParam === 'rooms_booking') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo file_get_contents($filePath);
    } 
    elseif ($fileParam === 'mch_loans') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo file_get_contents($filePath);
    } 
    elseif ($fileParam === 'user_profiles') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode(new stdClass(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        echo file_get_contents($filePath);
    } 
    elseif ($fileParam === 'sync_store') {
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode(new stdClass(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        
        $key = $_GET['key'] ?? '';
        $storeData = json_decode(file_get_contents($filePath), true) ?: [];
        
        if ($key) {
            $val = isset($storeData[$key]) ? $storeData[$key] : null;
            echo json_encode(["key" => $key, "value" => $val]);
        } else {
            echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
        }
    } 
    else {
        if (file_exists($filePath)) {
            echo file_get_contents($filePath);
        } else {
            echo json_encode(new stdClass());
        }
    }
}
?>