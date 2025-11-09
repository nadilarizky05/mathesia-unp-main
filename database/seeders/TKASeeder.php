<?php

namespace Database\Seeders;

use App\Models\TKA;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TKASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $tkas = [
            'title' => 'Tes Kemampuan Akademik',
            'description' => 'Melatih Kemampuan Akademik Kamu!',
            'questions' => 
            [
                [
                    "id" => Str::uuid(),
                    "text" => "Harga 7 1/2 kg beras adalah Rp90.000,00. Harga 3 kg beras adalah ...",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp32.000,00",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp36.000,00",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp40.000,00",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp42.000,00",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Bilangan 0,000045 dinyatakan dalam notasi ilmiah menjadi ....",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "4,5 x 10⁻³",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "4,5 x 10⁻⁴",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "4,5 x 10⁻⁵",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "4,5 x 10⁻⁶",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Sebuah mobil menempuh jarak 240 km dengan kecepatan rata-rata 80 km/jam. Jika mobil tersebut ingin menempuh jarak yang sama tetapi dengan waktu tempuh 1⁄2 jam lebih cepat, pilihlah pernyataan yang benar.",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "Kecepatan baru mobil tersebut adalah 96 km/jam.",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Kecepatan baru mobil tersebut meningkat sebesar 20% dari kecepatan semula.",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Jika bensin yang digunakan berbanding lurus dengan waktu tempuh, maka konsumsi bensin akan berkurang.",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Selisih waktu tempuh antara dua perjalanan adalah 30 menit.",
                            "is_correct" => true
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Diketahui (2x-3)/3 = (3x+1)/2. Nilai x yang memenuhi adalah ....",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "-9/5",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "2/3",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "9/5",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "-2/3",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Di toko alat tulis, Tuti membeli 2 pensil dan 3 buku tulis seharga Rp15.500,00, sedangkan Lina membeli 4 pensil dan 2 buku tulis seharga Rp13.500,00. Harga sebuah buku tulis adalah ....",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp3.000,00",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp3.500,00",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp4.000,00",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "Rp4.500,00",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Nilai x dari persamaan (x - 1)/(5x - 1) = (2x + 11) adalah ....",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "3",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "2",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "-3",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "-2",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
                    "id" => Str::uuid(),
                    "text" => "Volume bangun ruang di atas adalah ... cm³",
                    "options" => [
                        [
                            "id" => Str::uuid(),
                            "text" => "1.334,67",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "1.402,84",
                            "is_correct" => false
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "1.456,24",
                            "is_correct" => true
                        ],
                        [
                            "id" => Str::uuid(),
                            "text" => "1.584,36",
                            "is_correct" => false
                        ]
                    ]
                ],
                [
        "id" => Str::uuid(),
        "text" => "Sebuah mesin dapat memproduksi setengah kodi barang selama 3 jam. Pernyataan yang benar terkait jumlah produksi adalah ....",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "Satu mesin akan memproduksi 1 kodi barang dalam 6 jam.",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "Lima mesin bekerja bersama selama 5 jam akan menghasilkan 25/6 kodi barang.",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "Jumlah barang berbanding lurus dengan banyak mesin dan waktu kerja.",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "Jika waktu kerja digandakan, jumlah produksi akan menjadi empat kali lipat.",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Nilai p seharusnya adalah -13, -9, -5, p, 3, 7, 11. Nilai p adalah ....",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "1",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "0",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "-1",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "-2",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Seorang peternak kerbau memperkirakan bila persediaan makan cukup untuk 200 ekor dalam waktu 15 hari. Jika kerbau telah terjual 50 ekor, makanan ternak dapat cukup untuk .... hari.",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "20",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "18",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "24",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "22",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Asra berangkat pukul 07.00 naik sepeda dari kota A ke kota B dengan kecepatan 30 km/jam. Pukul 09.00 dari tempat yang sama, Riri menggunakan mobil dengan kecepatan tetap 60 km/jam. Riri dapat menyusul Asra pada pukul ....",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "10.00",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "10.30",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "11.00",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "11.30",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Perhatikan gambar berikut. Besar sudut y adalah ....",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "155°",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "125°",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "135°",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "25°",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Perbandingan volume tabung dengan bola adalah ....",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "2 : 3",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "3 : 1",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "1 : 3",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "3 : 2",
                "is_correct" => true
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Panjang BD adalah ... cm.",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "14,48",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "14,64",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "15,32",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "15,72",
                "is_correct" => false
            ]
        ]
    ],
    [
        "id" => Str::uuid(),
        "text" => "Pada sebuah segitiga siku-siku, jika kedua sisi yang tegak lurus memiliki panjang 24 cm dan 7 cm, maka panjang sisi yang ketiga adalah ... cm.",
        "options" => [
            [
                "id" => Str::uuid(),
                "text" => "21",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "25",
                "is_correct" => true
            ],
            [
                "id" => Str::uuid(),
                "text" => "31",
                "is_correct" => false
            ],
            [
                "id" => Str::uuid(),
                "text" => "35",
                "is_correct" => false
            ]
        ]
            ],
    [
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar bangun datar berikut. Luas bangun di atas adalah ... cm².",
    "options" => [
        [ "id" => Str::uuid(), "text" => "364", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "386", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "457", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "464", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar bangun berikut! Luas daerah segienam tersebut adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "412", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "385", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "358", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "328", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Relasi yang memasangkan pada himpunan {(1,2), (2,3), (3,4), (4,6)} adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "Kurang dari", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Setengah dari", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Lebih dari", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Kuadrat dari", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Penyelesaian dari (4x-2)/2 > (x-6)/4 adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "x > -2/7", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "x > 2/7", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "x < -2/7", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "x < 2/7", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Tinggi sebuah pesawat setelah t detik ditentukan dengan rumus f(t) = 4t - 2. Bila pesawat telah terbang selama 20 detik, ketinggian pesawat adalah ... meter.",
    "options" => [
        [ "id" => Str::uuid(), "text" => "78", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "84", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "96", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "102", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Grafik menunjukkan data tentang kebutuhan air keluarga Asra dan keluarga Bernard dalam satu bulan. Selisih rata-rata keperluan air keluarga Asra dan Bernard dalam 3 bulan adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "1 liter", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "1,2 liter", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "2 liter", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "3,4 liter", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar berikut! Keliling bangun di atas adalah ... cm.",
    "options" => [
        [ "id" => Str::uuid(), "text" => "28", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "22", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "50", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "36", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebuah mesin penggiling padi mampu menggiling 12 kuintal padi dari pukul 06.00–09.00. Setelah istirahat 1 jam, pekerjaan dilanjutkan hingga pukul 18.00 dengan kecepatan kerja yang sama. Pernyataan yang benar adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "Kecepatan kerja mesin adalah 4 kuintal per jam.", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Mesin bekerja selama total 11 jam.", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Total hasil gilingan seluruhnya adalah 44 kuintal.", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Jika dua mesin bekerja bersamaan selama waktu yang sama, hasilnya 88 kuintal.", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebuah peti berbentuk kubus memiliki panjang rusuk 25 cm. Dalam peti akan dimasukkan bola pejal dengan jari-jari 12,5 cm. Pernyataan yang benar adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "Volume kubus adalah 15.625 cm³.", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Volume bola adalah 4/3 πr³.", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Volume udara tersisa = 25³ - 4/3 πr³.", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Volume udara jika π = 3,14 adalah 7.200 cm³.", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar berikut! Nilai x pada gambar di atas adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "31°", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "34°", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "35°", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "42°", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebuah jajargenjang PQRS memiliki panjang PQ = (2x + 2) cm dan QR = (x + 3) cm. Jika kelilingnya 70 cm, maka nilai x adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "10", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "12", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "14,4", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "14,6", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan jaring-jaring berikut. Supaya jaring-jaring di atas dapat dibentuk menjadi balok, bagian yang harus dihilangkan pada nomor ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "1", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "3", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "4", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "9", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebuah kota memiliki 14 kartu merah, 25 kartu biru, dan 11 kartu kuning. Peluang terambilnya kartu berwarna biru secara acak adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "1/4", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "9/50", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "1/2", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "3/25", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar berikut! Pilihlah pasangan segitiga yang kongruen dari gambar di atas.",
    "options" => [
        [ "id" => Str::uuid(), "text" => "ΔDAF ≅ ΔEFB", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "ΔABF ≅ ΔABD", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "ΔCBD ≅ ΔCAE", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "ΔAEB ≅ ΔABD", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Rumus suku ke-n suatu barisan adalah Un = n² - 2n. Jumlah suku ke-10 dan suku ke-11 barisan itu adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "179", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "189", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "191", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "196", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Nilai rata-rata 7 orang peserta didik adalah 7,8. Seorang siswa baru masuk dan rata-rata mereka menjadi 7,6. Nilai peserta didik yang baru masuk adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "6,4", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "6,2", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "7,0", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "6,6", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebanyak 20 kartu berisi nomor 1–20. Peluang terambilnya kartu bernomor faktor dari 12 adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "3/10", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "1/2", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "4/5", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "1/5", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Fungsi g(x) = ½x + 9. Jika g(a) = 22, maka nilai a adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "22", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "24", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "26", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "28", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Sebuah gedung memiliki susunan kursi: baris pertama 15 kursi, baris kedua 17 kursi, baris ketiga 19 kursi, dan polanya bertambah 2 kursi tiap baris. Pernyataan yang benar adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "Banyak kursi pada baris ke-n dapat ditentukan dengan rumus Un = 15 + (n-1)x2.", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Jumlah kursi seluruhnya sampai baris ke-n adalah Sn = n/2 (15 + Un).", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "Jika ada 10 baris kursi, jumlah seluruhnya adalah 240 buah.", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Jika ada 15 baris kursi, jumlah seluruhnya adalah 345 buah.", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Ditentukan barisan geometri dengan rumus Un = 2n/3. Jumlah dari 6 suku pertama adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "64/3", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "32/3", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "128/3", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "154/3", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Bentuk sederhana dari √75 - √12 + √108 adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "9√3", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "6√3", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "5√3", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "7√3", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Seorang pedagang mendapatkan kiriman 40 mangga mudiak, 20 mangga golek, dan 60 mangga aromanis. Jika sebuah mangga diambil secara acak, peluang terambilnya bukan mangga mudiak adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "2/5", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "5/6", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "2/3", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "1/4", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Diketahui harga celana Rp80.000,00 per potong dengan diskon 30% dan harga kemeja Rp60.000,00 per potong dengan diskon 25%. Harga satu celana dan dua kemeja setelah diskon adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "Rp128.000,00", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Rp136.000,00", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Rp142.000,00", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Rp146.000,00", "is_correct" => true ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Perhatikan gambar bangun berikut! Pernyataan yang benar berdasarkan gambar di atas adalah ....",
    "options" => [
        [ "id" => Str::uuid(), "text" => "∠PQR = ∠RST", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "∠SRT = ∠PRQ", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "∠RPQ = ∠RTS", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "∠PRT = ∠QTS", "is_correct" => false ],
    ]
],
[
    "id" => Str::uuid(),
    "text" => "Dalam suatu tim sepak bola, rata-rata tinggi 10 pemain adalah 165 cm. Ketika penjaga gawang ikut bergabung, rata-rata tinggi menjadi 166 cm",
    "options" => [
        [ "id" => Str::uuid(), "text" => "1, 2 dan 3 benar", "is_correct" => true ],
        [ "id" => Str::uuid(), "text" => "1 dan 3 benar", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "2 dan 4 benar", "is_correct" => false ],
        [ "id" => Str::uuid(), "text" => "Hanya 4 yang benar", "is_correct" => false ],
    ]
],
            ]
        ];

        TKA::create($tkas);
    }
}