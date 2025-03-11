<?php
class CurlSender
{
    private $_api_url = 'https://dialogwa.web.id/api';
    private $_session = 'demo';
    private $_token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1ZjNiMjIyZWY1MmJjMzc4MDYxM2U1OSIsInVzZXJuYW1lIjoiY2hhbmRyYSIsImlhdCI6MTcxNzc0Nzc4NywiZXhwIjo0ODczNTA3Nzg3fQ.KIqEs7rELJzVj2hk6WJqCiYy0T0Mz7G5vbiy4gFLRQ0';

    public function send_text()
    {
        $nomor_tujuan = '628123....'; //set nomor tujuan pengirima pesan
        $pesan = 'tes kirim pesan menggunakan php';

        // Data yang akan dikirim dalam body request
        $data = array(
            'session' => $this->_session,
            'target' => $nomor_tujuan, // nomor tujuan harus menggunakan kode negara contoh : 628123456789
            'message' => $pesan
        );

        $response = $this->_send('POST', "$this->_api_url/send-text", $data);

        var_dump($response);
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
$sender->send_text();
