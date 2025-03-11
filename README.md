# DEMO DIALOGWA

Snippet code menggunakan php untuk melakukan pengiriman pesan text dan file, serta menerima pesan dari https://dialogwa.web.id

## Mengirim Pesan

DialogWA support pengiriman pesan teks maupun file gambar, dokumen, pdf, dan base64

### Mengirim Teks

Endpoint : https://dialogwa.web.id/api/send-text
Method : POST
Format data yang dikirimkan :
```
array(
    'session' => 'nama_sesi',
    'target' => 'nomor_tujuan', // nomor tujuan harus menggunakan kode negara contoh : 628123456789
    'message' => 'pesan yang akan dikirimkan'
)
```

### Mengirim File

Endpoint : https://dialogwa.web.id/api/send-media
Method : POST
Format data yang dikirimkan :
```
array(
    'session' => 'nama_sesi',
    'target' => 'nomor_tujuan', // nomor tujuan harus menggunakan kode negara contoh : 628123456789
    'message' => 'pesan yang akan dikirimkan'
    'file' => 'code base64 dari file'
)
```

## Webhook 

### Webhook Reply

DialogWA memiliki built-in autoreply pesan yang dikirim ke nomor bot menggunakan template yang bisa dikustomisasi sesuai kebutuhan.

Namun bila Anda akan membuat sistem autoreply sendiri, Anda bisa menggunakan Webhook Reply. Set link Webhook Reply pada halaman profile DialogWA Anda.

Saat bot menerima pesan whatsapp, DialogWA akan mengirimkan isi pesan tersebut beserta informasi pengirim ke link Webhook Reply Anda. Data yang dikirimkan:
```
{
    "from": "628123456789",
    "sender": "628123456789",
    "message": "ini adalah pesan masuk"
}
```

Pada aplikasi Anda, Anda dapat mengolah pesan yang masuk tersebut dan menentukan untuk membalas atau tidak membalas pesan. Bila akan membalas pesan masuk tersebut, aplikasi Anda harus melakukan return data berupa:
 ```
array(
    'target' => 'nomor_tujuan', // nomor tujuan harus menggunakan kode negara contoh : 628123456789
    'message' => 'pesan yang akan dikirimkan'
)

atau

array(
    'target' => 'nomor_tujuan', // nomor tujuan harus menggunakan kode negara contoh : 628123456789
    'message' => 'pesan yang akan dikirimkan',
    'file' => 'code base64 dari file' // bila aplikasi akan mengirimkan file pada pesan balasan
)
 ```

## Bantuan
Butuh bantuan? Silakan chat ke https://dialogwa.web.id/chat/6287778299688
