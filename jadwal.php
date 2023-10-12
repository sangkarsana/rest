<?php
header('Content-Type: application/json');

// Simulasi database sederhana menggunakan array
$jadwal = [
    [
        'id' => 1,
        'hari' => 'Senin',
        'mata_kuliah' => 'Algoritma dan Pemrograman',
        'jam' => '08:00 - 10:00',
        'ruangan' => 'IF-101'
    ],
    [
        'id' => 2,
        'hari' => 'Selasa',
        'mata_kuliah' => 'Struktur Data',
        'jam' => '10:00 - 12:00',
        'ruangan' => 'IF-102'
    ],
    // Tambahkan lebih banyak jadwal di sini
];

// Baca metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];

// Tangani permintaan berdasarkan metode HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $item = array_filter($jadwal, function ($e) use ($id) {
                return $e['id'] == $id;
            });
            echo json_encode(['jadwal' => array_values($item)]);
        } else {
            echo json_encode(['jadwal' => $jadwal]);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = end($jadwal)['id'] + 1;  // Simulasi ID otomatis
        $jadwal[] = $input;
        echo json_encode(['jadwal' => $input]);
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $input = json_decode(file_get_contents('php://input'), true);
            foreach ($jadwal as $key => $value) {
                if ($value['id'] == $id) {
                    $jadwal[$key] = array_merge($value, $input);
                    echo json_encode(['jadwal' => $jadwal[$key]]);
                    break;
                }
            }
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            foreach ($jadwal as $key => $value) {
                if ($value['id'] == $id) {
                    unset($jadwal[$key]);
                    echo json_encode(['message' => 'Deleted successfully']);
                    break;
                }
            }
        }
        break;

    default:
        echo json_encode(['message' => 'Method not supported']);
        break;
}
?>
