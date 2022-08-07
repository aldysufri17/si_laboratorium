<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Date('ymd');
        Barang::create([
            'kode_barang'   => "EM-1" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Arduino",
            'tipe'          => "Uno",
            'stock'         => 51,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'pengadaan_id'  => 1,
            'gambar'        => 'arduino.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-2" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Arduino",
            'tipe'          => "Mega",
            'stock'         => 40,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'mega.webp',
        ]);
        Barang::create([
            'kode_barang'   => "EM-3" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Sensor Cahaya",
            'tipe'          => "Module LDR Photoresistor",
            'stock'         => 100,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 2,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'cahaya.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-4" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "LCD",
            'tipe'          => "16x2",
            'stock'         => 100,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'lcd162.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-5" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Obeng",
            'tipe'          => "Negatif",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 2,
            'pengadaan_id'          => 1,
            'gambar'        => 'o-.webp',
        ]);
        Barang::create([
            'kode_barang'   => "EM-6" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Obeng",
            'tipe'          => "Positif",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 2,
            'pengadaan_id'          => 1,
            'gambar'        => 'positif.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-7" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Sensor Ultrasonik",
            'tipe'          => "HC-SR04",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'ultrasonic.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-8" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Resistor",
            'tipe'          => "10k",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 2,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'r10k.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "EM-9" . $date,
            'laboratorium_id'  => 1,
            'nama'          => "Solder Uap",
            'tipe'          => "Yihua 878D",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'pengadaan_id'          => 1,
            'gambar'        => 'uap.jpg',
        ]);

        // RPL
        Barang::create([
            'kode_barang'   => "RL-10" . $date,
            'laboratorium_id'  => 2,
            'nama'          => "Flashdisk",
            'tipe'          => "12GB",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'satuan_id'     => 3,
            'kategori_id'   => 5,
            'pengadaan_id'          => 1,
            'gambar'        => 'flashdisk.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "RL-11" . $date,
            'laboratorium_id'  => 2,
            'nama'          => "Monitor",
            'tipe'          => "24inc",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'pengadaan_id'          => 1,
            'gambar'        => 'lcd.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "RL-12" . $date,
            'laboratorium_id'  => 2,
            'nama'          => "Keyboard",
            'tipe'          => "Logitech USB",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'pengadaan_id'          => 1,
            'gambar'        => 'keyboard.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "RL-13" . $date,
            'laboratorium_id'  => 2,
            'nama'          => "Mouse",
            'tipe'          => "Logitech Wireless",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'pengadaan_id'          => 1,
            'gambar'        => 'mouse.webp',
        ]);
        Barang::create([
            'kode_barang'   => "RL-14" . $date,
            'laboratorium_id'  => 2,
            'nama'          => "Laptop",
            'tipe'          => "Asus E410",
            'stock'         => 5,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'pengadaan_id'          => 1,
            'gambar'        => 'laptop.png',
        ]);
        // Jarkom
        Barang::create([
            'kode_barang'   => "JK-15" . $date,
            'laboratorium_id'  => 3,
            'nama'          => "Router",
            'tipe'          => "WR840N-1",
            'stock'         => 25,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'pengadaan_id'          => 1,
            'gambar'        => 'router.webp',
        ]);
        Barang::create([
            'kode_barang'   => "JK-16" . $date,
            'laboratorium_id'  => 3,
            'nama'          => "Repeater",
            'tipe'          => "AC-1200",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'pengadaan_id'          => 1,
            'gambar'        => 'repeater.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "JK-17" . $date,
            'laboratorium_id'  => 3,
            'nama'          => "Switch",
            'tipe'          => "RoHS",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'pengadaan_id'          => 1,
            'gambar'        => 'repeater.jpg',
        ]);
        // Mulmed
        Barang::create([
            'kode_barang'   => "MD-18" . $date,
            'laboratorium_id'  => 4,
            'nama'          => "Virtual Reality",
            'tipe'          => "Oculus",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'pengadaan_id'          => 'Hibah Universitas',
            'pengadaan_id'          => 1,
            'gambar'        => 'vr.webp',
        ]);
        Barang::create([
            'kode_barang'   => "MD-19" . $date,
            'laboratorium_id'  => 4,
            'nama'          => "Kamera Video",
            'tipe'          => "C200",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'pengadaan_id'          => 'Hibah Departemen',
            'pengadaan_id'          => 1,
            'gambar'        => 'kv.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "MD-20" . $date,
            'laboratorium_id'  => 4,
            'nama'          => "Kamera Digital",
            'tipe'          => "20MP",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'pengadaan_id'          => 'Hibah Departemen',
            'pengadaan_id'          => 1,
            'gambar'        => 'kf.jpg',
        ]);
        Barang::create([
            'kode_barang'   => "MD-21" . $date,
            'laboratorium_id'  => 4,
            'nama'          => "Scan",
            'tipe'          => "Epson V39",
            'stock'         => 3,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'pengadaan_id'          => 'Hibah Departemen',
            'pengadaan_id'          => 1,
            'gambar'        => 'scan.png',
        ]);
    }
}
