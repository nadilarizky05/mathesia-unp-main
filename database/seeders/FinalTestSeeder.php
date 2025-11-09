<?php

namespace Database\Seeders;

use App\Models\FinalTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinalTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finalTests = [
            [
                'material_id' => 1,
                'questions' => json_encode([
                    ['question' => '<p>Dalam rangka acara Pameran Karya Siswa, Rani dan teman-temannya menghias kelas mereka agar terlihat menarik dengan lampu tumblr pada mode twinkle. Pada mode ini semua lampu hidup bersamaan selama 2 detik, kemudian mati selama 1 detik, dan pola ini terus berulang selama pameran berlangsung. Jika lampu telah berkedip (hidup dan mati bergantian) selama 21 detik, berapa lama total waktu lampu dalam keadaan hidup dalam waktu tersebut? Jelaskan pendapatmu!</p>', 'max_score' => 35],

                    ['question' => 'Andi memiliki berbagai jenis mainan rubik. Salah satunya adalah rubik snack, yaitu mainan yang tersusun dari potongan-potongan segitiga berwarna merah dan putih sehingga membentuk pola tertentu seperti yang tampak pada gambar berikut. Tentukan persamaan dari pola segitiga putih dari rubik snack.', 'max_score' => 35],

                    ['question' => '<p>Suatu hari, Tono berkunjung ke Toko Buku langganannya dan menemukan buku kesukaannya. Untuk membeli buku tersebut ia bertekad untuk menabung secara rutin setiap minggu. Setiap hari, Tono menerima uang jajan Rp25.000 dari orang tuanya. Pada minggu pertama, Tono menabung Rp5.000. Mulai minggu kedua dan seterusnya, ia menambah jumlah nominal tabungannya Rp3.000 lebih banyak dari minggu sebelumnya. Berapa banyak uang yang Tono tabung pada minggu ke-8.</p>', 'max_score' => 30],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 2,
                'questions' => json_encode([
                    ['question' => '<p>Dalam rangka acara Pameran Karya Siswa, Rani dan teman-temannya menghias kelas mereka agar terlihat menarik dengan lampu tumblr pada mode twinkle. Pada mode ini semua lampu hidup bersamaan selama 2 detik, kemudian mati selama 1 detik, dan pola ini terus berulang selama pameran berlangsung. Jika lampu telah berkedip (hidup dan mati bergantian) selama 21 detik, berapa lama total waktu lampu dalam keadaan hidup dalam waktu tersebut? Jelaskan pendapatmu!</p>', 'max_score' => 35],

                    ['question' => 'Andi memiliki berbagai jenis mainan rubik. Salah satunya adalah rubik snack, yaitu mainan yang tersusun dari potongan-potongan segitiga berwarna merah dan putih sehingga membentuk pola tertentu seperti yang tampak pada gambar berikut. Tentukan persamaan dari pola segitiga putih dari rubik snack.', 'max_score' => 35],

                    ['question' => '<p>Suatu hari, Tono berkunjung ke Toko Buku langganannya dan menemukan buku kesukaannya. Untuk membeli buku tersebut ia bertekad untuk menabung secara rutin setiap minggu. Setiap hari, Tono menerima uang jajan Rp25.000 dari orang tuanya. Pada minggu pertama, Tono menabung Rp5.000. Mulai minggu kedua dan seterusnya, ia menambah jumlah nominal tabungannya Rp3.000 lebih banyak dari minggu sebelumnya. Berapa banyak uang yang Tono tabung pada minggu ke-8.</p>', 'max_score' => 30],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 3,
                'questions' => json_encode([
                    ['question' => '<p>Dalam rangka acara Pameran Karya Siswa, Rani dan teman-temannya menghias kelas mereka agar terlihat menarik dengan lampu tumblr pada mode twinkle. Pada mode ini semua lampu hidup bersamaan selama 2 detik, kemudian mati selama 1 detik, dan pola ini terus berulang selama pameran berlangsung. Jika lampu telah berkedip (hidup dan mati bergantian) selama 21 detik, berapa lama total waktu lampu dalam keadaan hidup dalam waktu tersebut? Jelaskan pendapatmu!</p>', 'max_score' => 35],

                    ['question' => 'Andi memiliki berbagai jenis mainan rubik. Salah satunya adalah rubik snack, yaitu mainan yang tersusun dari potongan-potongan segitiga berwarna merah dan putih sehingga membentuk pola tertentu seperti yang tampak pada gambar berikut. Tentukan persamaan dari pola segitiga putih dari rubik snack.', 'max_score' => 35],

                    ['question' => '<p>Suatu hari, Tono berkunjung ke Toko Buku langganannya dan menemukan buku kesukaannya. Untuk membeli buku tersebut ia bertekad untuk menabung secara rutin setiap minggu. Setiap hari, Tono menerima uang jajan Rp25.000 dari orang tuanya. Pada minggu pertama, Tono menabung Rp5.000. Mulai minggu kedua dan seterusnya, ia menambah jumlah nominal tabungannya Rp3.000 lebih banyak dari minggu sebelumnya. Berapa banyak uang yang Tono tabung pada minggu ke-8.</p>', 'max_score' => 30],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 4,
                'questions' => json_encode([
                    ['question' => 'Galah panjang adalah permainan tradisional dengan pemain yang terdiri atas dua kelompok, satu kelompok disebut penyerang yang bertugas melewati garis batas lawan dan kelompok lainnya disebut penjaga untuk menjaga garis batas mereka agar tidak dilewati kelompok penyerang. Permainan galah panjang dilakukan di lapangan yang diberi batas berupa garis-garis melintang dan membujur. <br><br> Terdapat duabelas anak sedang bermain galah panjang dan enam orang diantara mereka menjadi penjaga, adapun posisi pemain yang menjadi penjaga adalah sebagai berikut <br> a. Tentukan koordinat tiap pemain pada bidang kartesius, jika dimisalkan Wawan berada pada koordinat (0, 0)! <br> b. Tentukan posisi tiap pemain terhadap Wawan! <br> c. Tentukan posisi tiap pemain terhadap Dimas!', 'max_score' => 25],

                    ['question' => 'Sebuah lapangan bola berbentuk persegi panjang seperti gambar di bawah ini. <br> a. Tentukan koordinat tiga titik sudut lapangan yang lain pada bidang kartesius dengan salah satu titik sudutnya berada di (-10, -5) dan titik tengah lapangan berada pada koordinat (0, 0)! <br> b. Tentukan luas lapangan bola tersebut! <br> c. Tentukan berapa jarak titik pojok kanan atas dengan titik pojok kiri bawah lapangan bola tersebut!', 'max_score' => 25],

                    ['question' => 'Jalur trans purwekerto-purbalingga seperti gambar di bawah. <br><br>Pada gambar tersebut terdapat 6 halte trans purwekerto-purbalingga. <br>Amanda ingin membuat beberapa garis dengan ketentuan sebagai berikut: 
                    <br>a. Garis yang menghubungkan halte indokores dengan halte SMP 2 PBG 2
                    <br>b. Garis yang menghubungkan halte taman Usman Junatin dengan halte SMP 2 PBG 2
                    <br>c. Garis yang menghubungkan halte MAN PBG dengan halte yuro
                    <br>d. Garis yang menghubungkan halte yuro dengan halte taman Usman Junatin
                    <br>e. Garis yang menghubungkan halte indokores dengan halte simpang', 'max_score' => 25],

                    ['question' => 'Bantulah Amanda untuk membuat garis-garis tersebut pada koordinat kartesius dengan memisalkan setiap halte sebagai titik pada bidang kartesius dan lingkaran sebagai titik	(0, 0), kemudian berdasarkan garis- garis yang telah dibuat tentukan: 
                    <br>a. Garis yang sejajar dengan sumbu X dan garis yang sejajar dengan sumbu Y
                    <br>b. Garis yang tegak lurus dengan sumbu X dan garis yang tegak lurus dengan sumbu Y
                    <br>c. Garis yang berpotongan dengan sumbu X dan garis yang berpotongan dengan sumbu Y', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 5,
                'questions' => json_encode([
                    ['question' => 'Galah panjang adalah permainan tradisional dengan pemain yang terdiri atas dua kelompok, satu kelompok disebut penyerang yang bertugas melewati garis batas lawan dan kelompok lainnya disebut penjaga untuk menjaga garis batas mereka agar tidak dilewati kelompok penyerang. Permainan galah panjang dilakukan di lapangan yang diberi batas berupa garis-garis melintang dan membujur. <br><br> Terdapat duabelas anak sedang bermain galah panjang dan enam orang diantara mereka menjadi penjaga, adapun posisi pemain yang menjadi penjaga adalah sebagai berikut <br> a. Tentukan koordinat tiap pemain pada bidang kartesius, jika dimisalkan Wawan berada pada koordinat (0, 0)! <br> b. Tentukan posisi tiap pemain terhadap Wawan! <br> c. Tentukan posisi tiap pemain terhadap Dimas!', 'max_score' => 25],

                    ['question' => 'Sebuah lapangan bola berbentuk persegi panjang seperti gambar di bawah ini. <br> a. Tentukan koordinat tiga titik sudut lapangan yang lain pada bidang kartesius dengan salah satu titik sudutnya berada di (-10, -5) dan titik tengah lapangan berada pada koordinat (0, 0)! <br> b. Tentukan luas lapangan bola tersebut! <br> c. Tentukan berapa jarak titik pojok kanan atas dengan titik pojok kiri bawah lapangan bola tersebut!', 'max_score' => 25],

                    ['question' => 'Jalur trans purwekerto-purbalingga seperti gambar di bawah. <br><br>Pada gambar tersebut terdapat 6 halte trans purwekerto-purbalingga. <br>Amanda ingin membuat beberapa garis dengan ketentuan sebagai berikut: 
                    <br>a. Garis yang menghubungkan halte indokores dengan halte SMP 2 PBG 2
                    <br>b. Garis yang menghubungkan halte taman Usman Junatin dengan halte SMP 2 PBG 2
                    <br>c. Garis yang menghubungkan halte MAN PBG dengan halte yuro
                    <br>d. Garis yang menghubungkan halte yuro dengan halte taman Usman Junatin
                    <br>e. Garis yang menghubungkan halte indokores dengan halte simpang', 'max_score' => 25],

                    ['question' => 'Bantulah Amanda untuk membuat garis-garis tersebut pada koordinat kartesius dengan memisalkan setiap halte sebagai titik pada bidang kartesius dan lingkaran sebagai titik	(0, 0), kemudian berdasarkan garis- garis yang telah dibuat tentukan: 
                    <br>a. Garis yang sejajar dengan sumbu X dan garis yang sejajar dengan sumbu Y
                    <br>b. Garis yang tegak lurus dengan sumbu X dan garis yang tegak lurus dengan sumbu Y
                    <br>c. Garis yang berpotongan dengan sumbu X dan garis yang berpotongan dengan sumbu Y', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 6,
                'questions' => json_encode([
                    ['question' => 'Galah panjang adalah permainan tradisional dengan pemain yang terdiri atas dua kelompok, satu kelompok disebut penyerang yang bertugas melewati garis batas lawan dan kelompok lainnya disebut penjaga untuk menjaga garis batas mereka agar tidak dilewati kelompok penyerang. Permainan galah panjang dilakukan di lapangan yang diberi batas berupa garis-garis melintang dan membujur. <br><br> Terdapat duabelas anak sedang bermain galah panjang dan enam orang diantara mereka menjadi penjaga, adapun posisi pemain yang menjadi penjaga adalah sebagai berikut <br> a. Tentukan koordinat tiap pemain pada bidang kartesius, jika dimisalkan Wawan berada pada koordinat (0, 0)! <br> b. Tentukan posisi tiap pemain terhadap Wawan! <br> c. Tentukan posisi tiap pemain terhadap Dimas!', 'max_score' => 25],

                    ['question' => 'Sebuah lapangan bola berbentuk persegi panjang seperti gambar di bawah ini. <br> a. Tentukan koordinat tiga titik sudut lapangan yang lain pada bidang kartesius dengan salah satu titik sudutnya berada di (-10, -5) dan titik tengah lapangan berada pada koordinat (0, 0)! <br> b. Tentukan luas lapangan bola tersebut! <br> c. Tentukan berapa jarak titik pojok kanan atas dengan titik pojok kiri bawah lapangan bola tersebut!', 'max_score' => 25],

                    ['question' => 'Jalur trans purwekerto-purbalingga seperti gambar di bawah. <br><br>Pada gambar tersebut terdapat 6 halte trans purwekerto-purbalingga. <br>Amanda ingin membuat beberapa garis dengan ketentuan sebagai berikut: 
                    <br>a. Garis yang menghubungkan halte indokores dengan halte SMP 2 PBG 2
                    <br>b. Garis yang menghubungkan halte taman Usman Junatin dengan halte SMP 2 PBG 2
                    <br>c. Garis yang menghubungkan halte MAN PBG dengan halte yuro
                    <br>d. Garis yang menghubungkan halte yuro dengan halte taman Usman Junatin
                    <br>e. Garis yang menghubungkan halte indokores dengan halte simpang', 'max_score' => 25],

                    ['question' => 'Bantulah Amanda untuk membuat garis-garis tersebut pada koordinat kartesius dengan memisalkan setiap halte sebagai titik pada bidang kartesius dan lingkaran sebagai titik	(0, 0), kemudian berdasarkan garis- garis yang telah dibuat tentukan: 
                    <br>a. Garis yang sejajar dengan sumbu X dan garis yang sejajar dengan sumbu Y
                    <br>b. Garis yang tegak lurus dengan sumbu X dan garis yang tegak lurus dengan sumbu Y
                    <br>c. Garis yang berpotongan dengan sumbu X dan garis yang berpotongan dengan sumbu Y', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 7,
                'questions' => json_encode([
                    ['question' => 'Dalam kegiatan ekstrakurikuler di sekolah, setiap peserta didik boleh mengikuti lebih dari satu kegiatan sesuai dengan minatnya. Rina mengikuti Pramuka dan Basket, Zafran mengikuti Voli, Reivan mengikuti Pramuka dan Drumband, dan Sinta mengikuti Paduan Suara. Nyatakanlah relasi antara peserta didik dengan ekstrakurikuler yang diikuti dalam bentuk diagram kartesius!', 'max_score' => 25],

                    ['question' => 'Sebuah les privat matematika menetapkan biaya yang terdiri atas biaya pendaftaran Rp50.000 dan biaya setiap pertemuan Rp25.000. Tiga orang peserta didik mengikuti les tersebut. Raka telah mengikuti 4 pertemuan, Citra 5 pertemuan, dan Nina telah mengeluarkan biaya Rp200.000 selama mengikuti les. Nyatakanlah relasi antara peserta didik dan biaya yang telah dikeluarkan dalam bentuk pasangan berurutan!', 'max_score' => 25],

                    ['question' => 'Pada kuis matematika, peserta didik diminta membuat grafik dari dua fungsi berikut.  f(x)= 2x dan fx= x^2 + 1. Gambarlah grafik dari kedua fungsi dan jelaskan perbedaan dari grafik yang terbentuk!', 'max_score' => 25],

                    ['question' => 'Dalam pelajaran Matematika, pendidik membagi peserta didik menjadi 5 kelompok. Setelah menyelesaikan diskusi, setiap kelompok diminta mempresentasikan hasil kerja mereka. Untuk mengatur giliran, pendidik menyiapkan nomor urut presentasi dari 1 sampai 5 <br>a. Apakah relasi antara nomor urut presentasi dan kelompok merupakan korespondensi satu-satu? Jelaskan alasanmu. <br> b. Berapa banyak kemungkinan korespondensi satu-satu yang dapat terjadi antara nomor urut presentasi dan kelompok?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 8,
                'questions' => json_encode([
                    ['question' => 'Dalam kegiatan ekstrakurikuler di sekolah, setiap peserta didik boleh mengikuti lebih dari satu kegiatan sesuai dengan minatnya. Rina mengikuti Pramuka dan Basket, Zafran mengikuti Voli, Reivan mengikuti Pramuka dan Drumband, dan Sinta mengikuti Paduan Suara. Nyatakanlah relasi antara peserta didik dengan ekstrakurikuler yang diikuti dalam bentuk diagram kartesius!', 'max_score' => 25],

                    ['question' => 'Sebuah les privat matematika menetapkan biaya yang terdiri atas biaya pendaftaran Rp50.000 dan biaya setiap pertemuan Rp25.000. Tiga orang peserta didik mengikuti les tersebut. Raka telah mengikuti 4 pertemuan, Citra 5 pertemuan, dan Nina telah mengeluarkan biaya Rp200.000 selama mengikuti les. Nyatakanlah relasi antara peserta didik dan biaya yang telah dikeluarkan dalam bentuk pasangan berurutan!', 'max_score' => 25],

                    ['question' => 'Pada kuis matematika, peserta didik diminta membuat grafik dari dua fungsi berikut.  f(x)= 2x dan fx= x^2 + 1. Gambarlah grafik dari kedua fungsi dan jelaskan perbedaan dari grafik yang terbentuk!', 'max_score' => 25],

                    ['question' => 'Dalam pelajaran Matematika, pendidik membagi peserta didik menjadi 5 kelompok. Setelah menyelesaikan diskusi, setiap kelompok diminta mempresentasikan hasil kerja mereka. Untuk mengatur giliran, pendidik menyiapkan nomor urut presentasi dari 1 sampai 5 <br>a. Apakah relasi antara nomor urut presentasi dan kelompok merupakan korespondensi satu-satu? Jelaskan alasanmu. <br> b. Berapa banyak kemungkinan korespondensi satu-satu yang dapat terjadi antara nomor urut presentasi dan kelompok?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 9,
                'questions' => json_encode([
                    ['question' => 'Dalam kegiatan ekstrakurikuler di sekolah, setiap peserta didik boleh mengikuti lebih dari satu kegiatan sesuai dengan minatnya. Rina mengikuti Pramuka dan Basket, Zafran mengikuti Voli, Reivan mengikuti Pramuka dan Drumband, dan Sinta mengikuti Paduan Suara. Nyatakanlah relasi antara peserta didik dengan ekstrakurikuler yang diikuti dalam bentuk diagram kartesius!', 'max_score' => 25],

                    ['question' => 'Sebuah les privat matematika menetapkan biaya yang terdiri atas biaya pendaftaran Rp50.000 dan biaya setiap pertemuan Rp25.000. Tiga orang peserta didik mengikuti les tersebut. Raka telah mengikuti 4 pertemuan, Citra 5 pertemuan, dan Nina telah mengeluarkan biaya Rp200.000 selama mengikuti les. Nyatakanlah relasi antara peserta didik dan biaya yang telah dikeluarkan dalam bentuk pasangan berurutan!', 'max_score' => 25],

                    ['question' => 'Pada kuis matematika, peserta didik diminta membuat grafik dari dua fungsi berikut.  f(x)= 2x dan fx= x^2 + 1. Gambarlah grafik dari kedua fungsi dan jelaskan perbedaan dari grafik yang terbentuk!', 'max_score' => 25],

                    ['question' => 'Dalam pelajaran Matematika, pendidik membagi peserta didik menjadi 5 kelompok. Setelah menyelesaikan diskusi, setiap kelompok diminta mempresentasikan hasil kerja mereka. Untuk mengatur giliran, pendidik menyiapkan nomor urut presentasi dari 1 sampai 5 <br>a. Apakah relasi antara nomor urut presentasi dan kelompok merupakan korespondensi satu-satu? Jelaskan alasanmu. <br> b. Berapa banyak kemungkinan korespondensi satu-satu yang dapat terjadi antara nomor urut presentasi dan kelompok?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 10,
                'questions' => json_encode([
                    ['question' => 'Pak Ahmad adalah seorang tukang bangunan. Salah satu bagian pekerjaan yang harus ia selesaikan adalah membuat tangga seperti gambar berikut. <br> <br> Ia membuat sebuah tangga dengan tinggi 3 meter dan panjang lantai dasar tangga 4 meter. Tentukanlah berapa kemiringan tangga tersebut!', 'max_score' => 35],

                    ['question' => 'Diva ingin membeli kotak pensil di toko buku langganannya dengan menabung secara rutin setiap minggu. Sebelum memulai menabung, Diva sudah memiliki uang Rp10.000 dari pamannya. Kemudian Ia menyisihkan Rp5.000 setiap minggu dari uang jajannya untuk ditabung. <br>a. Tentukanlah persamaan yang menyatakan banyak tabungan Diva berdasarkan waktu menabung! <br>b. Jika harga kotak pensil tersebut Rp40.000, tentukanlah berapa minggu yang diperlukan Diva untuk menabung agar uangnya cukup membeli kotak pensil tersebut?', 'max_score' => 35],

                    ['question' => 'Pada pembelajaran matematika, peserta didik mendapatkan dua persamaan garis untuk dikerjakan sebagai tugas. Kedua persamaan garis tersebut yaitu y=2x+4 dan y=2x+8. Buatlah grafik dari kedua persamaan garis tersebut dan tentukanlah kedudukan dua garisnya!', 'max_score' => 30]
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 11,
                'questions' => json_encode([
                    ['question' => 'Pak Ahmad adalah seorang tukang bangunan. Salah satu bagian pekerjaan yang harus ia selesaikan adalah membuat tangga seperti gambar berikut. <br> <br> Ia membuat sebuah tangga dengan tinggi 3 meter dan panjang lantai dasar tangga 4 meter. Tentukanlah berapa kemiringan tangga tersebut!', 'max_score' => 35],

                    ['question' => 'Diva ingin membeli kotak pensil di toko buku langganannya dengan menabung secara rutin setiap minggu. Sebelum memulai menabung, Diva sudah memiliki uang Rp10.000 dari pamannya. Kemudian Ia menyisihkan Rp5.000 setiap minggu dari uang jajannya untuk ditabung. <br>a. Tentukanlah persamaan yang menyatakan banyak tabungan Diva berdasarkan waktu menabung! <br>b. Jika harga kotak pensil tersebut Rp40.000, tentukanlah berapa minggu yang diperlukan Diva untuk menabung agar uangnya cukup membeli kotak pensil tersebut?', 'max_score' => 35],

                    ['question' => 'Pada pembelajaran matematika, peserta didik mendapatkan dua persamaan garis untuk dikerjakan sebagai tugas. Kedua persamaan garis tersebut yaitu y=2x+4 dan y=2x+8. Buatlah grafik dari kedua persamaan garis tersebut dan tentukanlah kedudukan dua garisnya!', 'max_score' => 30]
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 12,
                'questions' => json_encode([
                    ['question' => 'Pak Ahmad adalah seorang tukang bangunan. Salah satu bagian pekerjaan yang harus ia selesaikan adalah membuat tangga seperti gambar berikut. <br> <br> Ia membuat sebuah tangga dengan tinggi 3 meter dan panjang lantai dasar tangga 4 meter. Tentukanlah berapa kemiringan tangga tersebut!', 'max_score' => 35],

                    ['question' => 'Diva ingin membeli kotak pensil di toko buku langganannya dengan menabung secara rutin setiap minggu. Sebelum memulai menabung, Diva sudah memiliki uang Rp10.000 dari pamannya. Kemudian Ia menyisihkan Rp5.000 setiap minggu dari uang jajannya untuk ditabung. <br>a. Tentukanlah persamaan yang menyatakan banyak tabungan Diva berdasarkan waktu menabung! <br>b. Jika harga kotak pensil tersebut Rp40.000, tentukanlah berapa minggu yang diperlukan Diva untuk menabung agar uangnya cukup membeli kotak pensil tersebut?', 'max_score' => 35],

                    ['question' => 'Pada pembelajaran matematika, peserta didik mendapatkan dua persamaan garis untuk dikerjakan sebagai tugas. Kedua persamaan garis tersebut yaitu y=2x+4 dan y=2x+8. Buatlah grafik dari kedua persamaan garis tersebut dan tentukanlah kedudukan dua garisnya!', 'max_score' => 30]
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 13,
                'questions' => json_encode([
                    ['question' => 'Ani dan Ida akan melaksanakan ujian. Untuk melaksanakan ujian, mereka harus membeli pensil dan penghapus. Ani membeli 2 pensil dan 2 penghapus dengan harga Rp26.000,00. Ida membeli 3 pensil dan 1 penghapus denga harga Rp35.000,00. Bagaimana caramu menyajikan pernyataan tersebut menjadi lebih sederhana dengan caramu masing-masing!', 'max_score' => 20],

                    ['question' => 'Denis, Rani, dan Putri sedang jalan-jalan di Bukittinggi. Saat berkeliling, mereka ingin membeli celana dan baju dengan motif ciri khas minangkabau. Denis membeli 3 celana dan 5 baju dengan harga Rp255.000,00 dan Rani membeli 1 celana dan 2 baju dengan harga Rp130.000,00. Jika Putri ingin menghabiskan uang yang dimilikinya yaitu Rp350.000,00, berapa helai celana dan baju lagi yang bisa dibeli oleh Putri? Selesaikan permasalahan dengan menggunakan metode grafik!', 'max_score' => 20],

                    ['question' => 'Pak Andi seorang pedagang buah yang memiliki toko buah di pasar. Dia menjual dua jenis buah, yaitu apel dan jeruk. Setiap hari, dia mencatat jumlah buah yang dijual dan harga total yang diperoleh dari penjualan tersebut. Pada hari pertama, Pak Andi menjual 5 kg apel dan 3 kg jeruk, dan mendapatkan Rp235.000,00. Pada hari kedua, Pak Andi menjual 2 kg apel dan 4 kg jeruk, dan mendapatkan Rp150.000,00. Jika pada hari ketiga Pak Andi menjual 4 kg apel dan 6 kg jeruk, berapakah penjualan yang diperoleh pak Andi pada hari ketiga?', 'max_score' => 20],

                    ['question' => 'Pak Edi sedang bermain teka-teki bersama anaknya Fira. Teka-tekinya adalah “Di Taman, Ayah melihat anak-anak sedang bermain dengan beberapa kelinci. Pada saat dihitung ternyata ada 30 kaki dan 11 kepala. Berapakah banyak anak dan kelinci tersebut?”. Fira menggunakan konsep matematika dalam menjawab teka-teki ayahnya dan jawabannya benar dan tepat. Berapakah banyak anak dan kelinci yang ditemukan Fira?', 'max_score' => 20],

                    ['question' => 'Pak Arya memiliki beberapa ekor kelinci dan beberapa kandang. Pada saat Pak Arya menempatkan 2 ekor kelinci setiap 1 kandang, ternyata 1 ekor kelinci berlebih tidak mendapatkan kandang. Pada saat Pak Arya menempatkan 3 ekor kelinci setiap 1 kandang, ternyata kandangnya berlebih 2. Berapakah banyak kelinci dan kandang yang dimiliki oleh Pak Arya?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 14,
                'questions' => json_encode([
                    ['question' => 'Ani dan Ida akan melaksanakan ujian. Untuk melaksanakan ujian, mereka harus membeli pensil dan penghapus. Ani membeli 2 pensil dan 2 penghapus dengan harga Rp26.000,00. Ida membeli 3 pensil dan 1 penghapus denga harga Rp35.000,00. Bagaimana caramu menyajikan pernyataan tersebut menjadi lebih sederhana dengan caramu masing-masing!', 'max_score' => 20],

                    ['question' => 'Denis, Rani, dan Putri sedang jalan-jalan di Bukittinggi. Saat berkeliling, mereka ingin membeli celana dan baju dengan motif ciri khas minangkabau. Denis membeli 3 celana dan 5 baju dengan harga Rp255.000,00 dan Rani membeli 1 celana dan 2 baju dengan harga Rp130.000,00. Jika Putri ingin menghabiskan uang yang dimilikinya yaitu Rp350.000,00, berapa helai celana dan baju lagi yang bisa dibeli oleh Putri? Selesaikan permasalahan dengan menggunakan metode grafik!', 'max_score' => 20],

                    ['question' => 'Pak Andi seorang pedagang buah yang memiliki toko buah di pasar. Dia menjual dua jenis buah, yaitu apel dan jeruk. Setiap hari, dia mencatat jumlah buah yang dijual dan harga total yang diperoleh dari penjualan tersebut. Pada hari pertama, Pak Andi menjual 5 kg apel dan 3 kg jeruk, dan mendapatkan Rp235.000,00. Pada hari kedua, Pak Andi menjual 2 kg apel dan 4 kg jeruk, dan mendapatkan Rp150.000,00. Jika pada hari ketiga Pak Andi menjual 4 kg apel dan 6 kg jeruk, berapakah penjualan yang diperoleh pak Andi pada hari ketiga?', 'max_score' => 20],

                    ['question' => 'Pak Edi sedang bermain teka-teki bersama anaknya Fira. Teka-tekinya adalah “Di Taman, Ayah melihat anak-anak sedang bermain dengan beberapa kelinci. Pada saat dihitung ternyata ada 30 kaki dan 11 kepala. Berapakah banyak anak dan kelinci tersebut?”. Fira menggunakan konsep matematika dalam menjawab teka-teki ayahnya dan jawabannya benar dan tepat. Berapakah banyak anak dan kelinci yang ditemukan Fira?', 'max_score' => 20],

                    ['question' => 'Pak Arya memiliki beberapa ekor kelinci dan beberapa kandang. Pada saat Pak Arya menempatkan 2 ekor kelinci setiap 1 kandang, ternyata 1 ekor kelinci berlebih tidak mendapatkan kandang. Pada saat Pak Arya menempatkan 3 ekor kelinci setiap 1 kandang, ternyata kandangnya berlebih 2. Berapakah banyak kelinci dan kandang yang dimiliki oleh Pak Arya?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 15,
                'questions' => json_encode([
                    ['question' => 'Ani dan Ida akan melaksanakan ujian. Untuk melaksanakan ujian, mereka harus membeli pensil dan penghapus. Ani membeli 2 pensil dan 2 penghapus dengan harga Rp26.000,00. Ida membeli 3 pensil dan 1 penghapus denga harga Rp35.000,00. Bagaimana caramu menyajikan pernyataan tersebut menjadi lebih sederhana dengan caramu masing-masing!', 'max_score' => 20],

                    ['question' => 'Denis, Rani, dan Putri sedang jalan-jalan di Bukittinggi. Saat berkeliling, mereka ingin membeli celana dan baju dengan motif ciri khas minangkabau. Denis membeli 3 celana dan 5 baju dengan harga Rp255.000,00 dan Rani membeli 1 celana dan 2 baju dengan harga Rp130.000,00. Jika Putri ingin menghabiskan uang yang dimilikinya yaitu Rp350.000,00, berapa helai celana dan baju lagi yang bisa dibeli oleh Putri? Selesaikan permasalahan dengan menggunakan metode grafik!', 'max_score' => 20],

                    ['question' => 'Pak Andi seorang pedagang buah yang memiliki toko buah di pasar. Dia menjual dua jenis buah, yaitu apel dan jeruk. Setiap hari, dia mencatat jumlah buah yang dijual dan harga total yang diperoleh dari penjualan tersebut. Pada hari pertama, Pak Andi menjual 5 kg apel dan 3 kg jeruk, dan mendapatkan Rp235.000,00. Pada hari kedua, Pak Andi menjual 2 kg apel dan 4 kg jeruk, dan mendapatkan Rp150.000,00. Jika pada hari ketiga Pak Andi menjual 4 kg apel dan 6 kg jeruk, berapakah penjualan yang diperoleh pak Andi pada hari ketiga?', 'max_score' => 20],

                    ['question' => 'Pak Edi sedang bermain teka-teki bersama anaknya Fira. Teka-tekinya adalah “Di Taman, Ayah melihat anak-anak sedang bermain dengan beberapa kelinci. Pada saat dihitung ternyata ada 30 kaki dan 11 kepala. Berapakah banyak anak dan kelinci tersebut?”. Fira menggunakan konsep matematika dalam menjawab teka-teki ayahnya dan jawabannya benar dan tepat. Berapakah banyak anak dan kelinci yang ditemukan Fira?', 'max_score' => 20],

                    ['question' => 'Pak Arya memiliki beberapa ekor kelinci dan beberapa kandang. Pada saat Pak Arya menempatkan 2 ekor kelinci setiap 1 kandang, ternyata 1 ekor kelinci berlebih tidak mendapatkan kandang. Pada saat Pak Arya menempatkan 3 ekor kelinci setiap 1 kandang, ternyata kandangnya berlebih 2. Berapakah banyak kelinci dan kandang yang dimiliki oleh Pak Arya?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 16,
                'questions' => json_encode([
                    ['question' => 'Dina bekerja pada bagian desain grafis sebuah perusahaan. Saat ini, Dina bersama tim nya ditugaskan untuk merancang logo baru yang akan diapakai oleh salah satu Anak Perusahaan tersebut. Logo yang dirancang berbentuk segitiga siku-siku dengan ukuran sisi 6 satuan, 8 satuan, dan sisi terpanjangnya adalah 10 satuan. Tentukan apakah dengan ukuran tersebut sudah sesuai untuk membentuk logo berbentuk segitiga siku-siku ?', 'max_score' => 25],

                    ['question' => 'Farrel dan Qaim tinggal di komplek perumahan yang sama dan untuk menuju ke rumah Qaim, Farel harus berjalan kaki dari rumahnya ke arah Barat sejauh 40 meter, kemudian ke arah Selatan sejauh 30 meter. Jalan yang Farel lewati saling tegak lurus membentuk sudut siku-siku di titik B, seperti yang dapat dilhat pada Gambar 1. Namun, sebenarnya rumah Farel dan Qaim memiliki jarak yang lebih dekat melalui jalan dari A ke C meskipun tidak ramai dilalui oleh pejalan kaki.<br><br>Farrel ingin mencoba rute dari A ke C dengan terlebih dahulu menghitung panjang jalan tersebut. Bantulah Farrel menemukan panjang jalan dari A ke C sebagai jarak terpendek antara rumah mereka!', 'max_score' => 25],

                    ['question' => 'Dinda melihat pekerjaan seorang tukang yang sedang membuat sebuah kolam ikan berbentuk segitiga siku-siku di halaman belakang rumahnya. Tukang tersebut merencanakan  bahwa sisi terpanjang dari kolam adalah 3 m. Kolam yang ingin dibuat mempunyai satu sudut siku-siku dan dua sisi yang saling tegak lurus memiliki panjang yang sama, seperti pada gambar berikut! <br><br>Jika disekeliling kolam ikan akan dihias dengan lampu warna warni, maka berapakah panjang lampu yang dibutuhkan untuk menghias kolam tersebut ?', 'max_score' => 25],

                    ['question' => 'Seorang anak sedang mengamati dua buah kapal dari puncak menara dengan ketinggian 12 km di atas permukaan laut. Anak tersebut mengamati dua kapal yang sedang berlayar mendekati menara seperti yang dapat dilihat pada gambar.<br><br>Jarak kapal pertama dari pengamatan sang anak adalah 13 km dan jarak kapal kedua dari pengamatan sang anak adalah 20 km. Jika PS merupakan jarak kapal pertama ke Menara dan PQ merupakan jarak kapal kedua ke Menara, maka tentukanlah jarak dari S ke Q sebagai jarak antara kedua kapal !', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 17,
                'questions' => json_encode([
                    ['question' => 'Dina bekerja pada bagian desain grafis sebuah perusahaan. Saat ini, Dina bersama tim nya ditugaskan untuk merancang logo baru yang akan diapakai oleh salah satu Anak Perusahaan tersebut. Logo yang dirancang berbentuk segitiga siku-siku dengan ukuran sisi 6 satuan, 8 satuan, dan sisi terpanjangnya adalah 10 satuan. Tentukan apakah dengan ukuran tersebut sudah sesuai untuk membentuk logo berbentuk segitiga siku-siku ?', 'max_score' => 25],

                    ['question' => 'Farrel dan Qaim tinggal di komplek perumahan yang sama dan untuk menuju ke rumah Qaim, Farel harus berjalan kaki dari rumahnya ke arah Barat sejauh 40 meter, kemudian ke arah Selatan sejauh 30 meter. Jalan yang Farel lewati saling tegak lurus membentuk sudut siku-siku di titik B, seperti yang dapat dilhat pada Gambar 1. Namun, sebenarnya rumah Farel dan Qaim memiliki jarak yang lebih dekat melalui jalan dari A ke C meskipun tidak ramai dilalui oleh pejalan kaki.<br><br>Farrel ingin mencoba rute dari A ke C dengan terlebih dahulu menghitung panjang jalan tersebut. Bantulah Farrel menemukan panjang jalan dari A ke C sebagai jarak terpendek antara rumah mereka!', 'max_score' => 25],

                    ['question' => 'Dinda melihat pekerjaan seorang tukang yang sedang membuat sebuah kolam ikan berbentuk segitiga siku-siku di halaman belakang rumahnya. Tukang tersebut merencanakan  bahwa sisi terpanjang dari kolam adalah 3 m. Kolam yang ingin dibuat mempunyai satu sudut siku-siku dan dua sisi yang saling tegak lurus memiliki panjang yang sama, seperti pada gambar berikut! <br><br>Jika disekeliling kolam ikan akan dihias dengan lampu warna warni, maka berapakah panjang lampu yang dibutuhkan untuk menghias kolam tersebut ?', 'max_score' => 25],

                    ['question' => 'Seorang anak sedang mengamati dua buah kapal dari puncak menara dengan ketinggian 12 km di atas permukaan laut. Anak tersebut mengamati dua kapal yang sedang berlayar mendekati menara seperti yang dapat dilihat pada gambar.<br><br>Jarak kapal pertama dari pengamatan sang anak adalah 13 km dan jarak kapal kedua dari pengamatan sang anak adalah 20 km. Jika PS merupakan jarak kapal pertama ke Menara dan PQ merupakan jarak kapal kedua ke Menara, maka tentukanlah jarak dari S ke Q sebagai jarak antara kedua kapal !', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 18,
                'questions' => json_encode([
                    ['question' => 'Dina bekerja pada bagian desain grafis sebuah perusahaan. Saat ini, Dina bersama tim nya ditugaskan untuk merancang logo baru yang akan diapakai oleh salah satu Anak Perusahaan tersebut. Logo yang dirancang berbentuk segitiga siku-siku dengan ukuran sisi 6 satuan, 8 satuan, dan sisi terpanjangnya adalah 10 satuan. Tentukan apakah dengan ukuran tersebut sudah sesuai untuk membentuk logo berbentuk segitiga siku-siku ?', 'max_score' => 25],

                    ['question' => 'Farrel dan Qaim tinggal di komplek perumahan yang sama dan untuk menuju ke rumah Qaim, Farel harus berjalan kaki dari rumahnya ke arah Barat sejauh 40 meter, kemudian ke arah Selatan sejauh 30 meter. Jalan yang Farel lewati saling tegak lurus membentuk sudut siku-siku di titik B, seperti yang dapat dilhat pada Gambar 1. Namun, sebenarnya rumah Farel dan Qaim memiliki jarak yang lebih dekat melalui jalan dari A ke C meskipun tidak ramai dilalui oleh pejalan kaki.<br><br>Farrel ingin mencoba rute dari A ke C dengan terlebih dahulu menghitung panjang jalan tersebut. Bantulah Farrel menemukan panjang jalan dari A ke C sebagai jarak terpendek antara rumah mereka!', 'max_score' => 25],

                    ['question' => 'Dinda melihat pekerjaan seorang tukang yang sedang membuat sebuah kolam ikan berbentuk segitiga siku-siku di halaman belakang rumahnya. Tukang tersebut merencanakan  bahwa sisi terpanjang dari kolam adalah 3 m. Kolam yang ingin dibuat mempunyai satu sudut siku-siku dan dua sisi yang saling tegak lurus memiliki panjang yang sama, seperti pada gambar berikut! <br><br>Jika disekeliling kolam ikan akan dihias dengan lampu warna warni, maka berapakah panjang lampu yang dibutuhkan untuk menghias kolam tersebut ?', 'max_score' => 25],

                    ['question' => 'Seorang anak sedang mengamati dua buah kapal dari puncak menara dengan ketinggian 12 km di atas permukaan laut. Anak tersebut mengamati dua kapal yang sedang berlayar mendekati menara seperti yang dapat dilihat pada gambar.<br><br>Jarak kapal pertama dari pengamatan sang anak adalah 13 km dan jarak kapal kedua dari pengamatan sang anak adalah 20 km. Jika PS merupakan jarak kapal pertama ke Menara dan PQ merupakan jarak kapal kedua ke Menara, maka tentukanlah jarak dari S ke Q sebagai jarak antara kedua kapal !', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 19,
                'questions' => json_encode([
                    ['question' => 'Taman bunga atau taman flora adalah area di mana bunga ditanam dan dirawat. Keindahan taman bunga dapat terwujud apabila susunan bunga, termasuk jenis dan warnanya, disesuaikan dan ditata dengan baik. Zahra, yang menjadi pengurus taman di Pantai Kata Pariaman, ingin melakukan perancangan ulang susunan taman yang berbentuk lingkaran. Ia merancang susunan bunga agar menyerupai unsur-unsur lingkaran seperti pada gambar  berikut.<br><br>Bagian yang berwarna hijau akan di tanami bunga Melati dan bagian yang berwarna kuning akan ditanami bunga Bugenville.  
                    <br>a. Apakah nama unur lingkaran yang ditanami bunga Bugenville?
                    <br>b. Apabila Zahra ingin menandai batas-batas bunga dengan papan nama yang sesuai dengan unsur lingkaran?
                    <br>c. Apakah nama dari batas CO, AB, OE, OA, dan OB?', 'max_score' => 25],

                    ['question' => 'Layla merupakan seorang pemilik butik di kota Padang. Ia ingin merenovasi butiknya agar lebih menarik. Ia ingin merenovasi bagian pintu masuk dengan mengganti pintu masuknya yang didorong biasa menjadi pintu kaca lingkaran yang berputar seperti pada gambar di bawah ini<br><br>Namun Layla tidak mendapatkan informasi mengenai luas dari seluruh pintu tersebut. Ia hanya mendapatkan beberapa informasi yaitu :
                    <br>a. Pintu berbentuk lingkaran yang dibagi empat sama besar
                    <br>b. Panjang salah satu bagian pintu adalah 1.1m
                    <br>Bantulah Layla untuk mencari luas dari keseluruhan pintu dan luas dari masing-masing bagian pintu  tersebut!', 'max_score' => 25],

                    ['question' => 'Bima merupakan salah satu atlit pada cabang atletik di Kota Malang. Setiap Sabtu pagi pelatihnya mengadakan latihan mandiri, yaitu dengan berlari sejauh 1000m atau 1km. Bima memilih melakukan latihan mandiri di alun-alun tugu kota malang yang berupa taman berbentuk lingkaran. Ia mengetahui dari jari-jari dari taman tersebut adalah 35m. Bima telah berlari 4kali putaran.
                    <br>a. Sudah berapa meterkah Bima berlari?
                    <br>b. Apakah dengan 4 putaran tersebut sudah memenuhi instruksi dari pelatih Bima?', 'max_score' => 25],

                    ['question' => 'Rangga, Rina dan Tuti tinggal disebuah komplek yang berbentuk lingkaran. Ditengah komplek tersebut terdapat sebuah Masjid. Rumah Rina dan Tuti di sebelah kiri masjid dan rumah Rangga berada di sebelah kanan masjid.
                    <br>Ilustrasikanlah/gambarkanlah tata letak rumah Rangga, Rina, Tuti  dan masjid !
                    <br>Apabila sudut yang terbentuk yang menghubungkan rumah Rina, Rangga, Tuti adalah 25°. Berapakah sudut yang terbentuk yang menghubungkan rumah Rina,Tuti dan masjid?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 20,
                'questions' => json_encode([
                    ['question' => 'Taman bunga atau taman flora adalah area di mana bunga ditanam dan dirawat. Keindahan taman bunga dapat terwujud apabila susunan bunga, termasuk jenis dan warnanya, disesuaikan dan ditata dengan baik. Zahra, yang menjadi pengurus taman di Pantai Kata Pariaman, ingin melakukan perancangan ulang susunan taman yang berbentuk lingkaran. Ia merancang susunan bunga agar menyerupai unsur-unsur lingkaran seperti pada gambar  berikut.<br><br>Bagian yang berwarna hijau akan di tanami bunga Melati dan bagian yang berwarna kuning akan ditanami bunga Bugenville.  
                    <br>a. Apakah nama unur lingkaran yang ditanami bunga Bugenville?
                    <br>b. Apabila Zahra ingin menandai batas-batas bunga dengan papan nama yang sesuai dengan unsur lingkaran?
                    <br>c. Apakah nama dari batas CO, AB, OE, OA, dan OB?', 'max_score' => 25],

                    ['question' => 'Layla merupakan seorang pemilik butik di kota Padang. Ia ingin merenovasi butiknya agar lebih menarik. Ia ingin merenovasi bagian pintu masuk dengan mengganti pintu masuknya yang didorong biasa menjadi pintu kaca lingkaran yang berputar seperti pada gambar di bawah ini<br><br>Namun Layla tidak mendapatkan informasi mengenai luas dari seluruh pintu tersebut. Ia hanya mendapatkan beberapa informasi yaitu :
                    <br>a. Pintu berbentuk lingkaran yang dibagi empat sama besar
                    <br>b. Panjang salah satu bagian pintu adalah 1.1m
                    <br>Bantulah Layla untuk mencari luas dari keseluruhan pintu dan luas dari masing-masing bagian pintu  tersebut!', 'max_score' => 25],

                    ['question' => 'Bima merupakan salah satu atlit pada cabang atletik di Kota Malang. Setiap Sabtu pagi pelatihnya mengadakan latihan mandiri, yaitu dengan berlari sejauh 1000m atau 1km. Bima memilih melakukan latihan mandiri di alun-alun tugu kota malang yang berupa taman berbentuk lingkaran. Ia mengetahui dari jari-jari dari taman tersebut adalah 35m. Bima telah berlari 4kali putaran.
                    <br>a. Sudah berapa meterkah Bima berlari?
                    <br>b. Apakah dengan 4 putaran tersebut sudah memenuhi instruksi dari pelatih Bima?', 'max_score' => 25],

                    ['question' => 'Rangga, Rina dan Tuti tinggal disebuah komplek yang berbentuk lingkaran. Ditengah komplek tersebut terdapat sebuah Masjid. Rumah Rina dan Tuti di sebelah kiri masjid dan rumah Rangga berada di sebelah kanan masjid.
                    <br>Ilustrasikanlah/gambarkanlah tata letak rumah Rangga, Rina, Tuti  dan masjid !
                    <br>Apabila sudut yang terbentuk yang menghubungkan rumah Rina, Rangga, Tuti adalah 25°. Berapakah sudut yang terbentuk yang menghubungkan rumah Rina,Tuti dan masjid?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 21,
                'questions' => json_encode([
                    ['question' => 'Taman bunga atau taman flora adalah area di mana bunga ditanam dan dirawat. Keindahan taman bunga dapat terwujud apabila susunan bunga, termasuk jenis dan warnanya, disesuaikan dan ditata dengan baik. Zahra, yang menjadi pengurus taman di Pantai Kata Pariaman, ingin melakukan perancangan ulang susunan taman yang berbentuk lingkaran. Ia merancang susunan bunga agar menyerupai unsur-unsur lingkaran seperti pada gambar  berikut.<br><br>Bagian yang berwarna hijau akan di tanami bunga Melati dan bagian yang berwarna kuning akan ditanami bunga Bugenville.  
                    <br>a. Apakah nama unur lingkaran yang ditanami bunga Bugenville?
                    <br>b. Apabila Zahra ingin menandai batas-batas bunga dengan papan nama yang sesuai dengan unsur lingkaran?
                    <br>c. Apakah nama dari batas CO, AB, OE, OA, dan OB?', 'max_score' => 25],

                    ['question' => 'Layla merupakan seorang pemilik butik di kota Padang. Ia ingin merenovasi butiknya agar lebih menarik. Ia ingin merenovasi bagian pintu masuk dengan mengganti pintu masuknya yang didorong biasa menjadi pintu kaca lingkaran yang berputar seperti pada gambar di bawah ini<br><br>Namun Layla tidak mendapatkan informasi mengenai luas dari seluruh pintu tersebut. Ia hanya mendapatkan beberapa informasi yaitu :
                    <br>a. Pintu berbentuk lingkaran yang dibagi empat sama besar
                    <br>b. Panjang salah satu bagian pintu adalah 1.1m
                    <br>Bantulah Layla untuk mencari luas dari keseluruhan pintu dan luas dari masing-masing bagian pintu  tersebut!', 'max_score' => 25],

                    ['question' => 'Bima merupakan salah satu atlit pada cabang atletik di Kota Malang. Setiap Sabtu pagi pelatihnya mengadakan latihan mandiri, yaitu dengan berlari sejauh 1000m atau 1km. Bima memilih melakukan latihan mandiri di alun-alun tugu kota malang yang berupa taman berbentuk lingkaran. Ia mengetahui dari jari-jari dari taman tersebut adalah 35m. Bima telah berlari 4kali putaran.
                    <br>a. Sudah berapa meterkah Bima berlari?
                    <br>b. Apakah dengan 4 putaran tersebut sudah memenuhi instruksi dari pelatih Bima?', 'max_score' => 25],

                    ['question' => 'Rangga, Rina dan Tuti tinggal disebuah komplek yang berbentuk lingkaran. Ditengah komplek tersebut terdapat sebuah Masjid. Rumah Rina dan Tuti di sebelah kiri masjid dan rumah Rangga berada di sebelah kanan masjid.
                    <br>Ilustrasikanlah/gambarkanlah tata letak rumah Rangga, Rina, Tuti  dan masjid !
                    <br>Apabila sudut yang terbentuk yang menghubungkan rumah Rina, Rangga, Tuti adalah 25°. Berapakah sudut yang terbentuk yang menghubungkan rumah Rina,Tuti dan masjid?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 22,
                'questions' => json_encode([
                    ['question' => 'Sebuah perahu dari Mercusuar A berlayar ke arah barat sejauh 12 km menuju mercusuar B. Selanjutnya perahu melanjutkan perjalanan  dengan berbelok kearah selatan sejauh 5 km hingga tiba di Mercusuar C. Untuk tiba di Mercusuar D perharu hanya perlu melanjutkan perjalanan sejauh 10 km lagi. 
                    <br>a. Tentukanlah jarak dari Mercusuar A ke Mercusuar C!
                    <br>b. Tentukanlah jarak dari Mercusuar A ke Mercusuar D!
                    <br>c. Gambarkanlah perjalanan dari perahu di atas!
                    <br><br>Cermatilah Teks 1 untuk menjawab pertanyaan nomor 2,3, dan 4!
                    <br><br>Rumah Dini berdekatan sebuah tower yang memancarkan sinyal. Dari rumahnya, Dini mengamati tower tersebut. Ia begitu kagum karena tower tersebut sangat tinggi. Dini penasaran berapakah jarak jika ia memandang puncak tower dari rumahnya. Dini kemudian melakukan penyelidikan dan mendapatkan beberapa informasi berikut:
                    <br>i. Biaya pembuatan tower tersebut adalah Rp240.000.000,-
                    <br>ii. Biaya pembauatn tower per meter adalah Rp10.000.000,-
                    <br>iii. Tower tersebut dikelilingi oleh pagar sepanjang 32 meter
                    <br>iv. Biaya pembuatan pagar adalah Rp15.000.000,-
                    <br>v. Jarak rumah Dini dengan tower tersebut adalah 10 meter
                    <br><br>Bantulah Dini dalam menemukan jarak jika ia memandang puncak tower dari rumahnya dengan menjawab pertanyaan-pertanyaan berikut!', 'max_score' => 20],

                    ['question' => 'Informasi apa saja yang dapat digunakan untuk menemukan jarak pandang Dini ke puncak tower?', 'max_score' => 20],

                    ['question' => 'Tulislah bentuk matematis dari informasi yang didapat oleh Dini!', 'max_score' => 20],

                    ['question' => 'Berapakah jarak jika Dini memandang ujung tower dari rumahnya', 'max_score' => 20],
                    
                    ['question' => 'Lala dimintai tolong oleh Ayahnya untuk menghitung total biaya pembuatan tangga yang menghubungkan lantai 1 dan lantai 2 di rumahnya. Jika alas tangga berjarak 3 meter dari dinding dan tinggi dinding rumah Lala adalah 4 meter. Berapakah total biaya pembuatan tangga tersebut jika biaya per meternya adalah Rp5.000.000?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 23,
                'questions' => json_encode([
                    ['question' => 'Sebuah perahu dari Mercusuar A berlayar ke arah barat sejauh 12 km menuju mercusuar B. Selanjutnya perahu melanjutkan perjalanan  dengan berbelok kearah selatan sejauh 5 km hingga tiba di Mercusuar C. Untuk tiba di Mercusuar D perharu hanya perlu melanjutkan perjalanan sejauh 10 km lagi. 
                    <br>a. Tentukanlah jarak dari Mercusuar A ke Mercusuar C!
                    <br>b. Tentukanlah jarak dari Mercusuar A ke Mercusuar D!
                    <br>c. Gambarkanlah perjalanan dari perahu di atas!
                    <br><br>Cermatilah Teks 1 untuk menjawab pertanyaan nomor 2,3, dan 4!
                    <br><br>Rumah Dini berdekatan sebuah tower yang memancarkan sinyal. Dari rumahnya, Dini mengamati tower tersebut. Ia begitu kagum karena tower tersebut sangat tinggi. Dini penasaran berapakah jarak jika ia memandang puncak tower dari rumahnya. Dini kemudian melakukan penyelidikan dan mendapatkan beberapa informasi berikut:
                    <br>i. Biaya pembuatan tower tersebut adalah Rp240.000.000,-
                    <br>ii. Biaya pembauatn tower per meter adalah Rp10.000.000,-
                    <br>iii. Tower tersebut dikelilingi oleh pagar sepanjang 32 meter
                    <br>iv. Biaya pembuatan pagar adalah Rp15.000.000,-
                    <br>v. Jarak rumah Dini dengan tower tersebut adalah 10 meter
                    <br><br>Bantulah Dini dalam menemukan jarak jika ia memandang puncak tower dari rumahnya dengan menjawab pertanyaan-pertanyaan berikut!', 'max_score' => 20],

                    ['question' => 'Informasi apa saja yang dapat digunakan untuk menemukan jarak pandang Dini ke puncak tower?', 'max_score' => 20],

                    ['question' => 'Tulislah bentuk matematis dari informasi yang didapat oleh Dini!', 'max_score' => 20],

                    ['question' => 'Berapakah jarak jika Dini memandang ujung tower dari rumahnya', 'max_score' => 20],
                    
                    ['question' => 'Lala dimintai tolong oleh Ayahnya untuk menghitung total biaya pembuatan tangga yang menghubungkan lantai 1 dan lantai 2 di rumahnya. Jika alas tangga berjarak 3 meter dari dinding dan tinggi dinding rumah Lala adalah 4 meter. Berapakah total biaya pembuatan tangga tersebut jika biaya per meternya adalah Rp5.000.000?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 24,
                'questions' => json_encode([
                    ['question' => 'Sebuah perahu dari Mercusuar A berlayar ke arah barat sejauh 12 km menuju mercusuar B. Selanjutnya perahu melanjutkan perjalanan  dengan berbelok kearah selatan sejauh 5 km hingga tiba di Mercusuar C. Untuk tiba di Mercusuar D perharu hanya perlu melanjutkan perjalanan sejauh 10 km lagi. 
                    <br>a. Tentukanlah jarak dari Mercusuar A ke Mercusuar C!
                    <br>b. Tentukanlah jarak dari Mercusuar A ke Mercusuar D!
                    <br>c. Gambarkanlah perjalanan dari perahu di atas!
                    <br><br>Cermatilah Teks 1 untuk menjawab pertanyaan nomor 2,3, dan 4!
                    <br><br>Rumah Dini berdekatan sebuah tower yang memancarkan sinyal. Dari rumahnya, Dini mengamati tower tersebut. Ia begitu kagum karena tower tersebut sangat tinggi. Dini penasaran berapakah jarak jika ia memandang puncak tower dari rumahnya. Dini kemudian melakukan penyelidikan dan mendapatkan beberapa informasi berikut:
                    <br>i. Biaya pembuatan tower tersebut adalah Rp240.000.000,-
                    <br>ii. Biaya pembauatn tower per meter adalah Rp10.000.000,-
                    <br>iii. Tower tersebut dikelilingi oleh pagar sepanjang 32 meter
                    <br>iv. Biaya pembuatan pagar adalah Rp15.000.000,-
                    <br>v. Jarak rumah Dini dengan tower tersebut adalah 10 meter
                    <br><br>Bantulah Dini dalam menemukan jarak jika ia memandang puncak tower dari rumahnya dengan menjawab pertanyaan-pertanyaan berikut!', 'max_score' => 20],

                    ['question' => 'Informasi apa saja yang dapat digunakan untuk menemukan jarak pandang Dini ke puncak tower?', 'max_score' => 20],

                    ['question' => 'Tulislah bentuk matematis dari informasi yang didapat oleh Dini!', 'max_score' => 20],

                    ['question' => 'Berapakah jarak jika Dini memandang ujung tower dari rumahnya', 'max_score' => 20],
                    
                    ['question' => 'Lala dimintai tolong oleh Ayahnya untuk menghitung total biaya pembuatan tangga yang menghubungkan lantai 1 dan lantai 2 di rumahnya. Jika alas tangga berjarak 3 meter dari dinding dan tinggi dinding rumah Lala adalah 4 meter. Berapakah total biaya pembuatan tangga tersebut jika biaya per meternya adalah Rp5.000.000?', 'max_score' => 20],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 25,
                'questions' => json_encode([
                    ['question' => 'Wili adalah seorang siswa kelas VIII SMP. Saat ini, di sekolah ia belajar matematika dengan materinya adalah bangun ruang sisi datar. Gurunya memberikan tugas untuk membuat bangun ruang kubus, balok, prisma segitiga sama sisi, dan limas persegi dari karton. Bantulah Wili untuk merancang bentuk bangun ruangnya dengan menggambarkan jaring-jaring dari semua bangun ruang tersebut!', 'max_score' => 25],

                    ['question' => 'Sebuah perusahaan minuman kemasan “Aquair” membuat dua jenis kotak untuk kemasan minuman yang akan dijual. Kotak pertama berbentuk kubus dengan panjang rusuk 30 cm, sedangkan kotak kedua berbentuk balok dengan ukuran panjang 40 cm, lebar 25 cm, dan tinggi 22 cm. Menurutmu, kotak manakah yang harus dipilih oleh perusahaan tersebut jika mempertimbangkan biaya pembuatan kotak ? Berikan alasanmu!', 'max_score' => 25],

                    ['question' => 'Ayu memiliki rumah baru yang masih dalam pembangunan. Pembangunan rumahnya akan memasuki tahap pemasangan genting. Atap rumahnya berbentuk limas persegi dengan ukuran rusuk alasnya adalah 8 meter dan tinggi atap 3 meter. Jika setiap meter persegi membutuhkan 20 buah genting, maka berapa banyak genting yang diperlukan?', 'max_score' => 25],

                    ['question' => 'Perhatikan gambar berikut.<br><br>Pak Roni akan mengisi kolam renang berbentuk prisma trapezium siku-siku yang memiliki ukuran seperti tampak pada gambar. Kolam tersebut akan diisi air dari mobil tangki air dengan debit 500 dm3/menit. Berapa lamakah waktu yang dibutuhkan untuk mengisi kolam tersebut hingga penuh? ( 1 m3 = 1000 dm3)', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 26,
                'questions' => json_encode([
                    ['question' => 'Wili adalah seorang siswa kelas VIII SMP. Saat ini, di sekolah ia belajar matematika dengan materinya adalah bangun ruang sisi datar. Gurunya memberikan tugas untuk membuat bangun ruang kubus, balok, prisma segitiga sama sisi, dan limas persegi dari karton. Bantulah Wili untuk merancang bentuk bangun ruangnya dengan menggambarkan jaring-jaring dari semua bangun ruang tersebut!', 'max_score' => 25],

                    ['question' => 'Sebuah perusahaan minuman kemasan “Aquair” membuat dua jenis kotak untuk kemasan minuman yang akan dijual. Kotak pertama berbentuk kubus dengan panjang rusuk 30 cm, sedangkan kotak kedua berbentuk balok dengan ukuran panjang 40 cm, lebar 25 cm, dan tinggi 22 cm. Menurutmu, kotak manakah yang harus dipilih oleh perusahaan tersebut jika mempertimbangkan biaya pembuatan kotak ? Berikan alasanmu!', 'max_score' => 25],

                    ['question' => 'Ayu memiliki rumah baru yang masih dalam pembangunan. Pembangunan rumahnya akan memasuki tahap pemasangan genting. Atap rumahnya berbentuk limas persegi dengan ukuran rusuk alasnya adalah 8 meter dan tinggi atap 3 meter. Jika setiap meter persegi membutuhkan 20 buah genting, maka berapa banyak genting yang diperlukan?', 'max_score' => 25],

                    ['question' => 'Perhatikan gambar berikut.<br><br>Pak Roni akan mengisi kolam renang berbentuk prisma trapezium siku-siku yang memiliki ukuran seperti tampak pada gambar. Kolam tersebut akan diisi air dari mobil tangki air dengan debit 500 dm3/menit. Berapa lamakah waktu yang dibutuhkan untuk mengisi kolam tersebut hingga penuh? ( 1 m3 = 1000 dm3)', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 27,
                'questions' => json_encode([
                    ['question' => 'Wili adalah seorang siswa kelas VIII SMP. Saat ini, di sekolah ia belajar matematika dengan materinya adalah bangun ruang sisi datar. Gurunya memberikan tugas untuk membuat bangun ruang kubus, balok, prisma segitiga sama sisi, dan limas persegi dari karton. Bantulah Wili untuk merancang bentuk bangun ruangnya dengan menggambarkan jaring-jaring dari semua bangun ruang tersebut!', 'max_score' => 25],

                    ['question' => 'Sebuah perusahaan minuman kemasan “Aquair” membuat dua jenis kotak untuk kemasan minuman yang akan dijual. Kotak pertama berbentuk kubus dengan panjang rusuk 30 cm, sedangkan kotak kedua berbentuk balok dengan ukuran panjang 40 cm, lebar 25 cm, dan tinggi 22 cm. Menurutmu, kotak manakah yang harus dipilih oleh perusahaan tersebut jika mempertimbangkan biaya pembuatan kotak ? Berikan alasanmu!', 'max_score' => 25],

                    ['question' => 'Ayu memiliki rumah baru yang masih dalam pembangunan. Pembangunan rumahnya akan memasuki tahap pemasangan genting. Atap rumahnya berbentuk limas persegi dengan ukuran rusuk alasnya adalah 8 meter dan tinggi atap 3 meter. Jika setiap meter persegi membutuhkan 20 buah genting, maka berapa banyak genting yang diperlukan?', 'max_score' => 25],

                    ['question' => 'Perhatikan gambar berikut.<br><br>Pak Roni akan mengisi kolam renang berbentuk prisma trapezium siku-siku yang memiliki ukuran seperti tampak pada gambar. Kolam tersebut akan diisi air dari mobil tangki air dengan debit 500 dm3/menit. Berapa lamakah waktu yang dibutuhkan untuk mengisi kolam tersebut hingga penuh? ( 1 m3 = 1000 dm3)', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 28,
                'questions' => json_encode([
                    ['question' => 'Ranti memiliki usaha membuat lilin aromaterapi dan berencana menjual dua jenis lilin, yaitu Lilin A berbentuk kerucut dan Lilin B berbentuk tabung. Kedua lilin tersebut memiliki diameter alas dan tinggi yang sama.<br><br>Berdasarkan pengukuran, volume satu lilin A adalah 100 ml, sedangkan volume satu lilin B tiga kali lebih besar dari lilin A. Ranti telah menyiapkan 3 liter (1 liter = 1.000 ml) lilin cair siap cetak, Ia mencetak 15 lilin A dan 5 Lilin B. Jika Ranti menetapkan harga lilin A sebesar Rp15.000 dan harga lilin B sebesar Rp40.000, maka tentukan uang yang diperoleh Ranti jika semua lilinnya terjual?', 'max_score' => 25],

                    ['question' => 'Dalam rangka merayakan ulang tahunnya, Alya berencana membagikan 10 liter jus jeruk kepada 35 orang temannya di kelas. Ia menyiapkan dua jenis cup berbentuk tabung, yaitu cup berdiameter 7 cm dan tinggi 14 cm untuk 15 teman laki-laki, serta cup berdiameter 7 cm dan tinggi 12 cm untuk 20 teman perempuan. Agar tidak tumpah, setiap cup tidak diisi sampai penuh melainkan menyisakan jarak 1 cm dari bibir cup. Berdasarkan informasi tersebut, tentukan apakah 10 liter jus jeruk cukup untuk mengisi semua cup hingga batas tersebut, Jika tidak, berapa liter tambahan jus jeruk yang perlu disiapkan Alya?', 'max_score' => 25],

                    ['question' => 'Di sepanjang trotoar jalan, sering terlihat batu besar berbentuk bola yang disebut bollard. Fungsinya untuk mencegah kendaraan naik ke trotoar serta memperindah tampilan jalan. Pemerintah berencana membuat 20 bollard dengan diameter 56 cm yang akan diletakkan trotoar jalan. Jika diperkirakan biaya pembuatan satu liter bahan beton cair adalah Rp 1.500, berapakah biaya yang dibutuhkan untuk membuat 20 bollard tersebut?', 'max_score' => 25],

                    ['question' => 'Ibu Dita memiliki usaha pesanan nasi tumpeng, pada Hari Minggu ia mendapat pesanan 4 buah nasi tumpeng. Ia menyiapkan 10 liter beras mentah, setelah dimasak diketahui volume beras menjadi dua kali lipatnya. Cetakan nasi tumpeng yang digunakan memiliki diameter alas 28 cm dan tinggi 30 cm, dan setiap cetakan harus terisi penuh. Bantulah Ibu Dita untuk menghitung apakah 10 liter beras yang disediakan cukup untuk membuat 4 tumpeng, jika tidak, berapa liter beras tambahan yang perlu disiapkan Ibu Dita?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 29,
                'questions' => json_encode([
                    ['question' => 'Ranti memiliki usaha membuat lilin aromaterapi dan berencana menjual dua jenis lilin, yaitu Lilin A berbentuk kerucut dan Lilin B berbentuk tabung. Kedua lilin tersebut memiliki diameter alas dan tinggi yang sama.<br><br>Berdasarkan pengukuran, volume satu lilin A adalah 100 ml, sedangkan volume satu lilin B tiga kali lebih besar dari lilin A. Ranti telah menyiapkan 3 liter (1 liter = 1.000 ml) lilin cair siap cetak, Ia mencetak 15 lilin A dan 5 Lilin B. Jika Ranti menetapkan harga lilin A sebesar Rp15.000 dan harga lilin B sebesar Rp40.000, maka tentukan uang yang diperoleh Ranti jika semua lilinnya terjual?', 'max_score' => 25],

                    ['question' => 'Dalam rangka merayakan ulang tahunnya, Alya berencana membagikan 10 liter jus jeruk kepada 35 orang temannya di kelas. Ia menyiapkan dua jenis cup berbentuk tabung, yaitu cup berdiameter 7 cm dan tinggi 14 cm untuk 15 teman laki-laki, serta cup berdiameter 7 cm dan tinggi 12 cm untuk 20 teman perempuan. Agar tidak tumpah, setiap cup tidak diisi sampai penuh melainkan menyisakan jarak 1 cm dari bibir cup. Berdasarkan informasi tersebut, tentukan apakah 10 liter jus jeruk cukup untuk mengisi semua cup hingga batas tersebut, Jika tidak, berapa liter tambahan jus jeruk yang perlu disiapkan Alya?', 'max_score' => 25],

                    ['question' => 'Di sepanjang trotoar jalan, sering terlihat batu besar berbentuk bola yang disebut bollard. Fungsinya untuk mencegah kendaraan naik ke trotoar serta memperindah tampilan jalan. Pemerintah berencana membuat 20 bollard dengan diameter 56 cm yang akan diletakkan trotoar jalan. Jika diperkirakan biaya pembuatan satu liter bahan beton cair adalah Rp 1.500, berapakah biaya yang dibutuhkan untuk membuat 20 bollard tersebut?', 'max_score' => 25],

                    ['question' => 'Ibu Dita memiliki usaha pesanan nasi tumpeng, pada Hari Minggu ia mendapat pesanan 4 buah nasi tumpeng. Ia menyiapkan 10 liter beras mentah, setelah dimasak diketahui volume beras menjadi dua kali lipatnya. Cetakan nasi tumpeng yang digunakan memiliki diameter alas 28 cm dan tinggi 30 cm, dan setiap cetakan harus terisi penuh. Bantulah Ibu Dita untuk menghitung apakah 10 liter beras yang disediakan cukup untuk membuat 4 tumpeng, jika tidak, berapa liter beras tambahan yang perlu disiapkan Ibu Dita?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 30,
                'questions' => json_encode([
                    ['question' => 'Ranti memiliki usaha membuat lilin aromaterapi dan berencana menjual dua jenis lilin, yaitu Lilin A berbentuk kerucut dan Lilin B berbentuk tabung. Kedua lilin tersebut memiliki diameter alas dan tinggi yang sama.<br><br>Berdasarkan pengukuran, volume satu lilin A adalah 100 ml, sedangkan volume satu lilin B tiga kali lebih besar dari lilin A. Ranti telah menyiapkan 3 liter (1 liter = 1.000 ml) lilin cair siap cetak, Ia mencetak 15 lilin A dan 5 Lilin B. Jika Ranti menetapkan harga lilin A sebesar Rp15.000 dan harga lilin B sebesar Rp40.000, maka tentukan uang yang diperoleh Ranti jika semua lilinnya terjual?', 'max_score' => 25],

                    ['question' => 'Dalam rangka merayakan ulang tahunnya, Alya berencana membagikan 10 liter jus jeruk kepada 35 orang temannya di kelas. Ia menyiapkan dua jenis cup berbentuk tabung, yaitu cup berdiameter 7 cm dan tinggi 14 cm untuk 15 teman laki-laki, serta cup berdiameter 7 cm dan tinggi 12 cm untuk 20 teman perempuan. Agar tidak tumpah, setiap cup tidak diisi sampai penuh melainkan menyisakan jarak 1 cm dari bibir cup. Berdasarkan informasi tersebut, tentukan apakah 10 liter jus jeruk cukup untuk mengisi semua cup hingga batas tersebut, Jika tidak, berapa liter tambahan jus jeruk yang perlu disiapkan Alya?', 'max_score' => 25],

                    ['question' => 'Di sepanjang trotoar jalan, sering terlihat batu besar berbentuk bola yang disebut bollard. Fungsinya untuk mencegah kendaraan naik ke trotoar serta memperindah tampilan jalan. Pemerintah berencana membuat 20 bollard dengan diameter 56 cm yang akan diletakkan trotoar jalan. Jika diperkirakan biaya pembuatan satu liter bahan beton cair adalah Rp 1.500, berapakah biaya yang dibutuhkan untuk membuat 20 bollard tersebut?', 'max_score' => 25],

                    ['question' => 'Ibu Dita memiliki usaha pesanan nasi tumpeng, pada Hari Minggu ia mendapat pesanan 4 buah nasi tumpeng. Ia menyiapkan 10 liter beras mentah, setelah dimasak diketahui volume beras menjadi dua kali lipatnya. Cetakan nasi tumpeng yang digunakan memiliki diameter alas 28 cm dan tinggi 30 cm, dan setiap cetakan harus terisi penuh. Bantulah Ibu Dita untuk menghitung apakah 10 liter beras yang disediakan cukup untuk membuat 4 tumpeng, jika tidak, berapa liter beras tambahan yang perlu disiapkan Ibu Dita?', 'max_score' => 25],
                ]),
                'duration_minutes' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        FinalTest::insert($finalTests);
    }
}