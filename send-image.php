<?php
class CurlSender
{
    private $_api_url = 'https://dialogwa.web.id/api';
    private $_session = 'demo';
    private $_token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1ZjNiMjIyZWY1MmJjMzc4MDYxM2U1OSIsInVzZXJuYW1lIjoiY2hhbmRyYSIsImlhdCI6MTcxNzc0Nzc4NywiZXhwIjo0ODczNTA3Nzg3fQ.KIqEs7rELJzVj2hk6WJqCiYy0T0Mz7G5vbiy4gFLRQ0';

    public function send_image()
    {
        try {
            $nomor_tujuan = '628123....'; // Set nomor tujuan pengiriman pesan
            $pesan = 'tes kirim image menggunakan php';
            $filepath = 'files/sample.png';

            if (!file_exists($filepath)) {
                throw new Exception("File tidak ditemukan: $filepath");
            }

            $fileData = file_get_contents($filepath);
            if ($fileData === false) {
                throw new Exception("Gagal membaca file: $filepath");
            }

            // Data yang akan dikirim ke dialogwa
            $data = [
                'session' => $this->_session,
                'target' => $nomor_tujuan,
                'message' => $pesan,
                'file' => 'data:' . mime_content_type($filepath) . ';base64,' . base64_encode($fileData),
            ];

            $response = $this->_send('POST', "$this->_api_url/send-media", $data);

            var_dump($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    private function _send($method, $url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: Bearer ' . $this->_token,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Set multipart/form-data
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }
}

// Example usage
$sender = new CurlSender();
$sender->send_image();
