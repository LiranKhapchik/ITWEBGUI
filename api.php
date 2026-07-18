<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// התחברות למסד נתונים SQLite
$dbPath = $dataDir . '/mch_database.db';
$isNewDb = !file_exists($dbPath);

try {
    $db = new PDO("sqlite:" . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// יצירת הטבלאות במידה ואינן קיימות
if ($isNewDb) {
    $db->exec("CREATE TABLE IF NOT EXISTS system_settings (
        key TEXT PRIMARY KEY,
        value TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS tickets (
        id TEXT PRIMARY KEY,
        title TEXT,
        building TEXT,
        room TEXT,
        station TEXT,
        status TEXT,
        desc TEXT,
        date TEXT,
        createdAt TEXT,
        faultType TEXT,
        component TEXT,
        assignedTo TEXT,
        phone TEXT,
        mchRows TEXT,
        events TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS team (
        personalId TEXT PRIMARY KEY,
        name TEXT,
        rank TEXT,
        profession TEXT,
        sapir TEXT,
        email TEXT,
        isKave INTEGER,
        photo TEXT,
        quotes TEXT,
        tags TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS inventory (
        id TEXT PRIMARY KEY,
        name TEXT,
        catalogCode TEXT,
        minQty INTEGER,
        totalQty INTEGER,
        serials TEXT,
        category TEXT DEFAULT 'exempt'
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS loans (
        id TEXT PRIMARY KEY,
        borrowerId TEXT,
        borrowerName TEXT,
        borrowerRank TEXT,
        borrowerRole TEXT,
        borrowerKeva TEXT,
        itemType TEXT,
        itemSerial TEXT,
        itemName TEXT,
        actualSerial TEXT,
        issuerName TEXT,
        issuerId TEXT,
        issuerRank TEXT,
        issuerRole TEXT,
        issuerKeva TEXT,
        issuerSapir TEXT,
        recipient TEXT,
        issueDate TEXT,
        expireDate TEXT,
        status TEXT,
        timestamp INTEGER,
        returnDate TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS user_profiles (
        id TEXT PRIMARY KEY,
        name TEXT,
        rank TEXT,
        keva TEXT,
        role TEXT,
        sapir TEXT,
        email TEXT,
        recipient TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS shifts_state (
        key TEXT PRIMARY KEY,
        value TEXT
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INTEGER PRIMARY KEY,
        date TEXT,
        building TEXT,
        room TEXT,
        startTime TEXT,
        endTime TEXT,
        purpose TEXT,
        isAllDay INTEGER
    )");
} else {
    // Check if category column exists in inventory table
    try {
        $checkInv = $db->query("PRAGMA table_info(inventory)")->fetchAll();
        $hasCategory = false;
        foreach ($checkInv as $col) {
            if ($col['name'] === 'category') {
                $hasCategory = true;
                break;
            }
        }
        if (!$hasCategory) {
            $db->exec("ALTER TABLE inventory ADD COLUMN category TEXT DEFAULT 'exempt'");
        }
    } catch (Exception $e) {}

    // Check if the old column 'slot' exists in bookings table and drop it if so
    try {
        $check = $db->query("PRAGMA table_info(bookings)")->fetchAll();
        $hasSlot = false;
        foreach ($check as $col) {
            if ($col['name'] === 'slot') {
                $hasSlot = true;
                break;
            }
        }
        if ($hasSlot) {
            $db->exec("DROP TABLE bookings");
            $db->exec("CREATE TABLE bookings (
                id INTEGER PRIMARY KEY,
                date TEXT,
                building TEXT,
                room TEXT,
                startTime TEXT,
                endTime TEXT,
                purpose TEXT,
                isAllDay INTEGER
            )");
        }
    } catch (Exception $e) {}
}

// פונקציית ייבוא/אתחול ראשוני (Seeder / Legacy Migration)
function seedDatabaseIfNeeded($db, $dataDir) {
    // בדיקה אם הטבלה tickets ריקה
    $stmt = $db->query("SELECT COUNT(*) FROM tickets");
    $ticketCount = $stmt->fetchColumn();
    if ($ticketCount > 0) {
        return; // כבר יש נתונים
    }

    // ניסיון לייבא מקובץ JSON ישן
    $legacyStateFile = $dataDir . '/mch_state.json';
    $imported = false;
    
    if (file_exists($legacyStateFile)) {
        $content = file_get_contents($legacyStateFile);
        $data = json_decode($content, true);
        if ($data) {
            importMchState($db, $data);
            $imported = true;
        }
    }

    if (!$imported) {
        // טעינת נתוני מוק ברירת מחדל (Mock Data) במידה ואין קובץ קיים
        $defaultTips = [
            "לפני שפותחים קריאה על מדפסת, ודאו שיש נייר והיא דלוקה! בדיקה בסיסית חוסכת זמן לכולנו.",
            "אין גישה לתיקיית רשת? הפעלה מחדש (Restart) פותרת 90% מהבעיות האלו באופן מיידי.",
            "סיסמה נעולה? ניתן לאפסה דרך אתר אופק לפעולות בשירות עצמי.",
            "ככל שתפרטו יותר בקריאת השירות (כולל צילום מסך אם אפשר), ככה נפתור אותה מהר יותר.",
            "הסיסמה לא עובדת? ודאו ש-Caps Lock כבוי ושהמקלדת בשפה הנכונה."
        ];
        
        $defaultTickets = [
            [
                'id' => 'TCK-2041', 'title' => 'אין תקשורת לעמדת מחשב', 'building' => 'snunit', 'room' => 'חדר מאבחנות',
                'station' => '2', 'status' => 'open', 'desc' => 'כבל רשת קרוע', 'date' => '14/06/2026 08:30',
                'createdAt' => '14/06/2026, 08:30', 'faultType' => 'hardware', 'component' => 'כבל תקשורת',
                'assignedTo' => 'לירן', 'phone' => '518-3508', 'mchRows' => '[]', 'events' => '[]'
            ],
            [
                'id' => 'TCK-2042', 'title' => 'מדפסת נתקעה', 'building' => 'ofroni', 'room' => 'כיתה ימנית',
                'station' => '2', 'status' => 'open', 'desc' => 'נייר נתקע במדפסת 1', 'date' => '14/06/2026 09:15',
                'createdAt' => '14/06/2026, 09:15', 'faultType' => 'hardware', 'component' => 'מדפסת',
                'assignedTo' => 'ראובן', 'phone' => '518-4455', 'mchRows' => '[]', 'events' => '[]'
            ]
        ];

        // צוות ברירת מחדל - זהה לצוות הדיפולטיבי בקרוסלה שב"אתר מחשוב"
        $defaultTeam = [
            [
                'personalId' => '7777777', 'name' => 'לירן', 'rank' => 'סמ״ר', 'profession' => 'מנהל רשת ותשתיות',
                'sapir' => '518-3508', 'email' => 'S9117951@IDF.IL', 'isKave' => 1, 'photo' => 'images/file.png',
                'quotes' => json_encode([], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode([], JSON_UNESCAPED_UNICODE)
            ],
            [
                'personalId' => '1111111', 'name' => 'מאיה', 'rank' => 'אע״צ', 'profession' => 'פסיכולוגית (מפקדת הצוות)',
                'sapir' => '518-2526', 'email' => 'C9812810@IDF.IL', 'isKave' => 0, 'photo' => 'images/mayafile.jpeg',
                'quotes' => json_encode([], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode([], JSON_UNESCAPED_UNICODE)
            ],
            [
                'personalId' => '2222222', 'name' => 'ראובן', 'rank' => 'רב״ט', 'profession' => 'תמיכת חומרה',
                'sapir' => '518-2021', 'email' => 'S9311294@IDF.IL', 'isKave' => 0, 'photo' => 'images/filrReuven.jpg',
                'quotes' => json_encode([], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode([], JSON_UNESCAPED_UNICODE)
            ],
            [
                'personalId' => '3333333', 'name' => 'חיים', 'rank' => 'סמל', 'profession' => 'טכנאי רשתות',
                'sapir' => '518-2021', 'email' => 'S9298128@IDF.IL', 'isKave' => 0, 'photo' => '',
                'quotes' => json_encode([], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode([], JSON_UNESCAPED_UNICODE)
            ],
            [
                'personalId' => '4444444', 'name' => 'ניקולאי', 'rank' => 'רב״ט', 'profession' => 'איש תמיכה בחומרה',
                'sapir' => '518-2021', 'email' => 'S9664735@IDF.IL', 'isKave' => 0, 'photo' => '',
                'quotes' => json_encode([], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode([], JSON_UNESCAPED_UNICODE)
            ]
        ];

        $defaultInventory = [
            [
                'id' => 'inv-1', 'name' => 'עכבר חוטי', 'catalogCode' => '518-5541',
                'minQty' => 5, 'totalQty' => 15, 'serials' => json_encode([], JSON_UNESCAPED_UNICODE), 'category' => 'exempt'
            ],
            [
                'id' => 'inv-2', 'name' => 'מקלדת עברית/אנגלית', 'catalogCode' => '518-5542',
                'minQty' => 10, 'totalQty' => 8, 'serials' => json_encode([], JSON_UNESCAPED_UNICODE), 'category' => 'exempt'
            ]
        ];

        // הזנת הגדרות כלליות
        saveSetting($db, 'systemStatus', 'ok');
        saveSetting($db, 'tips', json_encode($defaultTips, JSON_UNESCAPED_UNICODE));
        saveSetting($db, 'contacts', json_encode([], JSON_UNESCAPED_UNICODE));

        // הזנת תקלות
        $stmt = $db->prepare("INSERT INTO tickets (id, title, building, room, station, status, desc, date, createdAt, faultType, component, assignedTo, phone, mchRows, events) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultTickets as $t) {
            $stmt->execute([$t['id'], $t['title'], $t['building'], $t['room'], $t['station'], $t['status'], $t['desc'], $t['date'], $t['createdAt'], $t['faultType'], $t['component'], $t['assignedTo'], $t['phone'], $t['mchRows'], $t['events']]);
        }

        // הזנת צוות
        $stmt = $db->prepare("INSERT INTO team (personalId, name, rank, profession, sapir, email, isKave, photo, quotes, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultTeam as $tm) {
            $stmt->execute([$tm['personalId'], $tm['name'], $tm['rank'], $tm['profession'], $tm['sapir'], $tm['email'], $tm['isKave'], $tm['photo'], $tm['quotes'], $tm['tags']]);
        }

        // הזנת מלאי
        $stmt = $db->prepare("INSERT INTO inventory (id, name, catalogCode, minQty, totalQty, serials, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultInventory as $inv) {
            $stmt->execute([$inv['id'], $inv['name'], $inv['catalogCode'], $inv['minQty'], $inv['totalQty'], $inv['serials'], $inv['category'] ?? 'exempt']);
        }
    }

    // ייבוא לוח תורנויות
    $legacyShiftsFile = $dataDir . '/shifts_board_main.json';
    if (file_exists($legacyShiftsFile)) {
        $content = file_get_contents($legacyShiftsFile);
        if (json_decode($content)) {
            $stmt = $db->prepare("INSERT OR REPLACE INTO shifts_state (key, value) VALUES (?, ?)");
            $stmt->execute(['shifts_board_main', $content]);
        }
    } else {
        // סידר ברירת מחדל לתורנויות
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
            'justice' => ['month' => (int)date('n') - 1, 'year' => (int)date('Y'), 'counts' => new stdClass(), 'debtLedger' => []]
        ];
        $stmt = $db->prepare("INSERT OR REPLACE INTO shifts_state (key, value) VALUES (?, ?)");
        $stmt->execute(['shifts_board_main', json_encode($defaultShifts, JSON_UNESCAPED_UNICODE)]);
    }

    // ייבוא שריון חדרים
    $legacyRoomsFile = $dataDir . '/rooms_booking.json';
    if (file_exists($legacyRoomsFile)) {
        $content = file_get_contents($legacyRoomsFile);
        $bookings = json_decode($content, true);
        if (is_array($bookings)) {
            $stmt = $db->prepare("INSERT INTO bookings (id, date, building, room, startTime, endTime, purpose, isAllDay) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($bookings as $b) {
                $stmt->execute([
                    $b['id'] ?? null,
                    $b['date'] ?? '',
                    $b['building'] ?? '',
                    $b['room'] ?? '',
                    $b['startTime'] ?? '',
                    $b['endTime'] ?? '',
                    $b['purpose'] ?? '',
                    ($b['isAllDay'] ?? false) ? 1 : 0
                ]);
            }
        }
    }
}

// פונקציות עזר לשמירה ועדכון
function saveSetting($db, $key, $value) {
    $stmt = $db->prepare("INSERT OR REPLACE INTO system_settings (key, value) VALUES (?, ?)");
    $stmt->execute([$key, $value]);
}

function importMchState($db, $data) {
    $db->beginTransaction();
    try {
        // הגדרות כלליות
        saveSetting($db, 'systemStatus', $data['systemStatus'] ?? 'ok');
        saveSetting($db, 'tips', json_encode($data['tips'] ?? [], JSON_UNESCAPED_UNICODE));
        saveSetting($db, 'contacts', json_encode($data['contacts'] ?? [], JSON_UNESCAPED_UNICODE));
        
        // תקלות
        if (isset($data['tickets']) && is_array($data['tickets'])) {
            $stmt = $db->prepare("INSERT OR REPLACE INTO tickets (id, title, building, room, station, status, desc, date, createdAt, faultType, component, assignedTo, phone, mchRows, events) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($data['tickets'] as $t) {
                $mchRows = isset($t['mchRows']) ? (is_array($t['mchRows']) ? json_encode($t['mchRows'], JSON_UNESCAPED_UNICODE) : $t['mchRows']) : '[]';
                $events = isset($t['events']) ? (is_array($t['events']) ? json_encode($t['events'], JSON_UNESCAPED_UNICODE) : $t['events']) : '[]';
                
                $stmt->execute([
                    $t['id'], $t['title'] ?? '', $t['building'] ?? '', $t['room'] ?? '', $t['station'] ?? '',
                    $t['status'] ?? 'open', $t['desc'] ?? '', $t['date'] ?? '', $t['createdAt'] ?? '',
                    $t['faultType'] ?? '', $t['component'] ?? '', $t['assignedTo'] ?? '', $t['phone'] ?? '',
                    $mchRows, $events
                ]);
            }
        }

        // צוות
        if (isset($data['team']) && is_array($data['team'])) {
            $stmt = $db->prepare("INSERT OR REPLACE INTO team (personalId, name, rank, profession, sapir, email, isKave, photo, quotes, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($data['team'] as $tm) {
                $quotes = isset($tm['quotes']) ? json_encode($tm['quotes'], JSON_UNESCAPED_UNICODE) : '[]';
                $tags = isset($tm['tags']) ? json_encode($tm['tags'], JSON_UNESCAPED_UNICODE) : '[]';
                $isKave = (isset($tm['isKave']) && $tm['isKave']) ? 1 : 0;
                
                $stmt->execute([
                    $tm['personalId'], $tm['name'] ?? '', $tm['rank'] ?? '', $tm['profession'] ?? '',
                    $tm['sapir'] ?? '', $tm['email'] ?? '', $isKave, $tm['photo'] ?? '',
                    $quotes, $tags
                ]);
            }
        }

        // מלאי
        if (isset($data['inventory']) && is_array($data['inventory'])) {
            $stmt = $db->prepare("INSERT OR REPLACE INTO inventory (id, name, catalogCode, minQty, totalQty, serials, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($data['inventory'] as $inv) {
                $cat = $inv['catalogCode'] ?? ($inv['masha'] ?? '');
                $min = $inv['minQty'] ?? ($inv['threshold'] ?? 0);
                $total = $inv['totalQty'] ?? ($inv['qty'] ?? 0);
                $serials = isset($inv['serials']) ? (is_array($inv['serials']) ? json_encode($inv['serials'], JSON_UNESCAPED_UNICODE) : $inv['serials']) : '[]';
                $category = $inv['category'] ?? 'exempt';
                
                $stmt->execute([
                    $inv['id'], $inv['name'] ?? '', $cat, (int)$min, (int)$total, $serials, $category
                ]);
            }
        }

        // השאלות ציוד
        if (isset($data['loans']) && is_array($data['loans'])) {
            $stmt = $db->prepare("INSERT OR REPLACE INTO loans (id, borrowerId, borrowerName, borrowerRank, borrowerRole, borrowerKeva, itemType, itemSerial, itemName, actualSerial, issuerName, issuerId, issuerRank, issuerRole, issuerKeva, issuerSapir, recipient, issueDate, expireDate, status, timestamp, returnDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($data['loans'] as $l) {
                $stmt->execute([
                    $l['id'], $l['borrowerId'] ?? '', $l['borrowerName'] ?? '', $l['borrowerRank'] ?? '', $l['borrowerRole'] ?? '',
                    $l['borrowerKeva'] ?? '', $l['itemType'] ?? '', $l['itemSerial'] ?? '', $l['itemName'] ?? '', $l['actualSerial'] ?? '',
                    $l['issuerName'] ?? '', $l['issuerId'] ?? '', $l['issuerRank'] ?? '', $l['issuerRole'] ?? '', $l['issuerKeva'] ?? '',
                    $l['issuerSapir'] ?? '', $l['recipient'] ?? '', $l['issueDate'] ?? '', $l['expireDate'] ?? '', $l['status'] ?? 'active',
                    $l['timestamp'] ?? 0, $l['returnDate'] ?? ''
                ]);
            }
        }

        $db->commit();
    } catch (Exception $ex) {
        $db->rollBack();
        throw $ex;
    }
}

// אתחול נתונים במידת הצורך
if ($isNewDb) {
    seedDatabaseIfNeeded($db, $dataDir);
}

// עיבוד בקשות API
$fileParam = isset($_GET['file']) ? $_GET['file'] : 'default';
$fileParam = preg_replace('/[^a-zA-Z0-9_-]/', '', $fileParam);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $isJson = (strpos($contentType, 'application/json') !== false);
    
    $jsonData = file_get_contents('php://input');
    $inputData = json_decode($jsonData, true);
    
    if ($isJson && $inputData === null && !empty($jsonData)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
        exit;
    }

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

    if ($fileParam === 'mch_state') {
        // שמירת המצב המלא
        $db->beginTransaction();
        try {
            // שמירת הגדרות
            if (isset($inputData['systemStatus'])) {
                saveSetting($db, 'systemStatus', $inputData['systemStatus']);
            }
            if (isset($inputData['lastUpdated'])) {
                saveSetting($db, 'lastUpdated', $inputData['lastUpdated']);
            }
            if (isset($inputData['tips'])) {
                saveSetting($db, 'tips', json_encode($inputData['tips'], JSON_UNESCAPED_UNICODE));
            }
            if (isset($inputData['contacts'])) {
                saveSetting($db, 'contacts', json_encode($inputData['contacts'], JSON_UNESCAPED_UNICODE));
            }
            if (isset($inputData['predefinedFaults'])) {
                saveSetting($db, 'predefinedFaults', json_encode($inputData['predefinedFaults'], JSON_UNESCAPED_UNICODE));
            }
            if (isset($inputData['disabledStations'])) {
                saveSetting($db, 'disabledStations', json_encode($inputData['disabledStations'], JSON_UNESCAPED_UNICODE));
            }
            if (isset($inputData['roomsConfig'])) {
                saveSetting($db, 'rooms_config', json_encode($inputData['roomsConfig'], JSON_UNESCAPED_UNICODE));
            }
            if (isset($inputData['categoryIcons'])) {
                saveSetting($db, 'categoryIcons', json_encode($inputData['categoryIcons'], JSON_UNESCAPED_UNICODE));
            }
            
            // עדכון תקלות
            if (isset($inputData['tickets']) && is_array($inputData['tickets'])) {
                $db->exec("DELETE FROM tickets");
                $stmt = $db->prepare("INSERT INTO tickets (id, title, building, room, station, status, desc, date, createdAt, faultType, component, assignedTo, phone, mchRows, events) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData['tickets'] as $t) {
                    $mchRows = isset($t['mchRows']) ? (is_array($t['mchRows']) ? json_encode($t['mchRows'], JSON_UNESCAPED_UNICODE) : $t['mchRows']) : '[]';
                    $events = isset($t['events']) ? (is_array($t['events']) ? json_encode($t['events'], JSON_UNESCAPED_UNICODE) : $t['events']) : '[]';
                    $stmt->execute([
                        $t['id'], $t['title'] ?? '', $t['building'] ?? '', $t['room'] ?? '', $t['station'] ?? '',
                        $t['status'] ?? 'open', $t['desc'] ?? '', $t['date'] ?? '', $t['createdAt'] ?? '',
                        $t['faultType'] ?? '', $t['component'] ?? '', $t['assignedTo'] ?? '', $t['phone'] ?? '',
                        $mchRows, $events
                    ]);
                }
            }

            // עדכון צוות
            if (isset($inputData['team']) && is_array($inputData['team'])) {
                $db->exec("DELETE FROM team");
                $stmt = $db->prepare("INSERT INTO team (personalId, name, rank, profession, sapir, email, isKave, photo, quotes, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData['team'] as $tm) {
                    $quotes = isset($tm['quotes']) ? json_encode($tm['quotes'], JSON_UNESCAPED_UNICODE) : '[]';
                    $tags = isset($tm['tags']) ? json_encode($tm['tags'], JSON_UNESCAPED_UNICODE) : '[]';
                    $isKave = (isset($tm['isKave']) && $tm['isKave']) ? 1 : 0;
                    $stmt->execute([
                        $tm['personalId'], $tm['name'] ?? '', $tm['rank'] ?? '', $tm['profession'] ?? '',
                        $tm['sapir'] ?? '', $tm['email'] ?? '', $isKave, $tm['photo'] ?? '',
                        $quotes, $tags
                    ]);
                }
            }

            // עדכון מלאי
            if (isset($inputData['inventory']) && is_array($inputData['inventory'])) {
                $db->exec("DELETE FROM inventory");
                $stmt = $db->prepare("INSERT INTO inventory (id, name, catalogCode, minQty, totalQty, serials, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData['inventory'] as $inv) {
                    $cat = $inv['catalogCode'] ?? ($inv['masha'] ?? '');
                    $min = $inv['minQty'] ?? ($inv['threshold'] ?? 0);
                    $total = $inv['totalQty'] ?? ($inv['qty'] ?? 0);
                    $serials = isset($inv['serials']) ? (is_array($inv['serials']) ? json_encode($inv['serials'], JSON_UNESCAPED_UNICODE) : $inv['serials']) : '[]';
                    $category = $inv['category'] ?? 'exempt';
                    $stmt->execute([
                        $inv['id'], $inv['name'] ?? '', $cat, (int)$min, (int)$total, $serials, $category
                    ]);
                }
            }

            $db->commit();
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } 
    else if ($fileParam === 'shifts_board_main') {
        // שמירת לוח משמרות ותורנויות
        $stmt = $db->prepare("INSERT OR REPLACE INTO shifts_state (key, value) VALUES (?, ?)");
        $stmt->execute(['shifts_board_main', $jsonData]);
        echo json_encode(["status" => "success"]);
    } 
    else if ($fileParam === 'rooms_booking') {
        // שמירת שריון חדרים בצורה רלציונית
        $db->beginTransaction();
        try {
            $db->exec("DELETE FROM bookings");
            if (is_array($inputData)) {
                 $stmt = $db->prepare("INSERT INTO bookings (id, date, building, room, startTime, endTime, purpose, isAllDay) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData as $b) {
                    $stmt->execute([
                        $b['id'] ?? null,
                        $b['date'] ?? '',
                        $b['building'] ?? '',
                        $b['room'] ?? '',
                        $b['startTime'] ?? '',
                        $b['endTime'] ?? '',
                        $b['purpose'] ?? '',
                        ($b['isAllDay'] ?? false) ? 1 : 0
                    ]);
                }
            }
            $db->commit();
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } 
    else if ($fileParam === 'mch_loans') {
        // שמירת השאלות ציוד
        $db->beginTransaction();
        try {
            $db->exec("DELETE FROM loans");
            if (is_array($inputData)) {
                $stmt = $db->prepare("INSERT INTO loans (id, borrowerId, borrowerName, borrowerRank, borrowerRole, borrowerKeva, itemType, itemSerial, itemName, actualSerial, issuerName, issuerId, issuerRank, issuerRole, issuerKeva, issuerSapir, recipient, issueDate, expireDate, status, timestamp, returnDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData as $l) {
                    $stmt->execute([
                        $l['id'], $l['borrowerId'] ?? '', $l['borrowerName'] ?? '', $l['borrowerRank'] ?? '', $l['borrowerRole'] ?? '',
                        $l['borrowerKeva'] ?? '', $l['itemType'] ?? '', $l['itemSerial'] ?? '', $l['itemName'] ?? '', $l['actualSerial'] ?? '',
                        $l['issuerName'] ?? '', $l['issuerId'] ?? '', $l['issuerRank'] ?? '', $l['issuerRole'] ?? '', $l['issuerKeva'] ?? '',
                        $l['issuerSapir'] ?? '', $l['recipient'] ?? '', $l['issueDate'] ?? '', $l['expireDate'] ?? '', $l['status'] ?? 'active',
                        $l['timestamp'] ?? 0, $l['returnDate'] ?? ''
                    ]);
                }
            }
            $db->commit();
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } 
    else if ($fileParam === 'user_profiles') {
        // שמירת פרופילים מרובים או יחידים
        $db->beginTransaction();
        try {
            if (is_array($inputData)) {
                $stmt = $db->prepare("INSERT OR REPLACE INTO user_profiles (id, name, rank, keva, role, sapir, email, recipient) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($inputData as $key => $p) {
                    $id = $p['id'] ?? str_replace('user_', '', $key);
                    if ($id) {
                        $stmt->execute([
                            $id, $p['name'] ?? '', $p['rank'] ?? '', $p['keva'] ?? '', $p['role'] ?? '',
                            $p['sapir'] ?? '', $p['email'] ?? '', $p['recipient'] ?? ''
                        ]);
                    }
                }
            }
            $db->commit();
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } 
    else if ($fileParam === 'sync_store') {
        // שמירה/עדכון כללי של LocalStorage Key-Value
        if (isset($inputData['key'])) {
            saveSetting($db, $inputData['key'], $inputData['value'] ?? '');
            echo json_encode(["status" => "success"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing key"]);
        }
    }
    else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Unknown endpoint"]);
    }
} 
else {
    // עיבוד בקשות GET לקריאת נתונים
    if ($fileParam === 'mch_state') {
        $result = [];
        
        // הגדרות כלליות
        $stmt = $db->query("SELECT key, value FROM system_settings");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $k = $row['key'];
            $v = $row['value'];
            if ($k === 'tips' || $k === 'contacts' || $k === 'predefinedFaults' || $k === 'disabledStations' || $k === 'categoryIcons') {
                $result[$k] = json_decode($v, true) ?? [];
            } else if ($k === 'rooms_config') {
                $result['roomsConfig'] = json_decode($v, true) ?? [];
            } else {
                $result[$k] = $v;
            }
        }
        if (!isset($result['systemStatus'])) $result['systemStatus'] = 'ok';
        if (!isset($result['tips'])) $result['tips'] = [];
        if (!isset($result['contacts'])) $result['contacts'] = [];
        if (!isset($result['predefinedFaults'])) $result['predefinedFaults'] = [];
        if (!isset($result['disabledStations'])) $result['disabledStations'] = [];
        if (!isset($result['roomsConfig'])) $result['roomsConfig'] = null;
        if (!isset($result['categoryIcons'])) $result['categoryIcons'] = null;

        // תקלות
        $result['tickets'] = [];
        $stmt = $db->query("SELECT * FROM tickets");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['mchRows'] = json_decode($row['mchRows'], true) ?? [];
            $row['events'] = json_decode($row['events'], true) ?? [];
            $result['tickets'][] = $row;
        }

        // צוות
        $result['team'] = [];
        $stmt = $db->query("SELECT * FROM team");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['quotes'] = json_decode($row['quotes'], true) ?? [];
            $row['tags'] = json_decode($row['tags'], true) ?? [];
            $row['isKave'] = (bool)$row['isKave'];
            $result['team'][] = $row;
        }

        // מלאי
        $result['inventory'] = [];
        $stmt = $db->query("SELECT * FROM inventory");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inv = [
                'id' => $row['id'],
                'name' => $row['name'],
                'catalogCode' => $row['catalogCode'],
                'masha' => $row['catalogCode'],
                'minQty' => (int)$row['minQty'],
                'threshold' => (int)$row['minQty'],
                'totalQty' => (int)$row['totalQty'],
                'qty' => (int)$row['totalQty'],
                'serials' => json_decode($row['serials'], true) ?? [],
                'category' => $row['category'] ?? 'exempt'
            ];
            $result['inventory'][] = $inv;
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } 
    else if ($fileParam === 'shifts_board_main') {
        $stmt = $db->prepare("SELECT value FROM shifts_state WHERE key = ?");
        $stmt->execute(['shifts_board_main']);
        $val = $stmt->fetchColumn();
        echo $val ? $val : '{}';
    } 
    else if ($fileParam === 'rooms_booking') {
        $result = [];
        $stmt = $db->query("SELECT * FROM bookings ORDER BY date ASC, startTime ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['id'] = (int)$row['id'];
            $row['isAllDay'] = (bool)$row['isAllDay'];
            $result[] = $row;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } 
    else if ($fileParam === 'mch_loans') {
        $result = [];
        $stmt = $db->query("SELECT * FROM loans ORDER BY timestamp DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } 
    else if ($fileParam === 'user_profiles') {
        $result = [];
        $stmt = $db->query("SELECT * FROM user_profiles");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $key = 'user_' . $row['id'];
            $result[$key] = $row;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    else if ($fileParam === 'sync_store') {
        $key = $_GET['key'] ?? '';
        if ($key) {
            $stmt = $db->prepare("SELECT value FROM system_settings WHERE key = ?");
            $stmt->execute([$key]);
            $val = $stmt->fetchColumn();
            echo json_encode(["key" => $key, "value" => $val !== false ? $val : null]);
        } else {
            $result = [];
            $stmt = $db->query("SELECT key, value FROM system_settings");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[$row['key']] = $row['value'];
            }
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
    else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Unknown endpoint"]);
    }
}
?>