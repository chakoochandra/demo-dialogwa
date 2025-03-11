<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // http_response_code(405); // Method Not Allowed
    exit;
}

// Read the incoming JSON request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['from']) && isset($data['sender']) && isset($data['message'])) {
    $sender = $data['sender']; // Nomor pengirim
    $from = $data['from']; // Nomor pengirim atau ID grup jika group chat

    $response = get_response($data['message']);

    // Hanya reply kalau pesan yang masuk memiliki pola yang sudah diketahui
    if ($response) {
        // Bila pesan adalah pesan grup, tapi reply diharapkan melalui PM, maka target set ke $sender
        echo json_encode([
            'message' => $response,
            'target' => $from,
        ]);
        exit;
    }
}

/**
 * Pengecekan pola pesan
 */
function get_response($message)
{
    // Predefined responses
    $responses = [
        'tips sehat' => 'Olahraga donk bos',
        'menu x' => 'Anda memilih menu x',
    ];

    // Check for exact match
    if (isset($responses[$message])) {
        return $responses[$message];
    }

    // Pengecekan format pesan 1
    if (preg_match('/^ac#(\d+\/Pdt\.G\/\d{4}\/PA\.\w+)$/i', $message, $matches)) {
        $no_perkara = $matches[1];

        // Logic pengecekan status akta cerai

        return "Akta Cerai nomor perkara $no_perkara sudah/belum tersedia";
    }

    // Pengecekan format pesan 2
    if (preg_match('/^jadwal#(\d+\/Pdt\.G\/\d{4}\/PA\.\w+)$/i', $message, $matches)) {
        $no_perkara = $matches[1];

        // Logic pengecekan jadwal sidang

        return "Jadwal sidang nomor perkara $no_perkara .....";
    }

    return false;
}

http_response_code(400); // Bad Request if no valid response
exit;
