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
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Arduino",
            'tipe'          => "Uno",
            'stock'         => 51,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'gambar'        => 'arduino.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Arduino",
            'tipe'          => "Mega",
            'stock'         => 40,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'gambar'        => 'mega.webp',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Sensor Cahaya",
            'tipe'          => "Module LDR Photoresistor",
            'stock'         => 100,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 2,
            'kategori_id'   => 1,
            'gambar'        => 'cahaya.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "LCD",
            'tipe'          => "16x2",
            'stock'         => 100,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'gambar'        => 'ldc.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Obeng",
            'tipe'          => "Negatif",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 2,
            'gambar'        => 'o-.webp',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Obeng",
            'tipe'          => "Positif",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 2,
            'gambar'        => 'o+.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Sensor Ultrasonik",
            'tipe'          => "HC-SR04",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'gambar'        => 'ultrasonic.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Resistor",
            'tipe'          => "10k",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 2,
            'kategori_id'   => 1,
            'gambar'        => 'r10k.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Solder Uap",
            'tipe'          => "Yihua 878D",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Sistem Tertanam dan Robotika",
            'kategori_lab'  => 1,
            'satuan_id'     => 1,
            'kategori_id'   => 1,
            'gambar'        => 'uap.jpg',
        ]);

        // RPL
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Flashdisk",
            'tipe'          => "12GB",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'kategori_lab'  => 2,
            'satuan_id'     => 3,
            'kategori_id'   => 5,
            'gambar'        => 'flashdisk.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Monitor",
            'tipe'          => "24inc",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'kategori_lab'  => 2,
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'gambar'        => 'lcd.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Keyboard",
            'tipe'          => "Logitech USB",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'kategori_lab'  => 2,
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'gambar'        => 'keyboard.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Mouse",
            'tipe'          => "Logitech Wireless",
            'stock'         => 15,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'kategori_lab'  => 2,
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'gambar'        => 'mouse.webp',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Laptop",
            'tipe'          => "Asus E410",
            'stock'         => 5,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Rekayasa Perangkat Lunak",
            'kategori_lab'  => 2,
            'satuan_id'     => 3,
            'kategori_id'   => 4,
            'gambar'        => 'laptop.png',
        ]);
        // Jarkom
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Router",
            'tipe'          => "WR840N-1",
            'stock'         => 25,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'kategori_lab'  => 3,
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'gambar'        => 'router.webp',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Repeater",
            'tipe'          => "AC-1200",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'kategori_lab'  => 3,
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'gambar'        => 'repeater.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Switch",
            'tipe'          => "RoHS",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Jaringan dan Keamanan Komputer",
            'kategori_lab'  => 3,
            'satuan_id'     => 4,
            'kategori_id'   => 6,
            'gambar'        => 'repeater.jpg',
        ]);
        // Mulmed
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Virtual Reality",
            'tipe'          => "Oculus",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'kategori_lab'  => 4,
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'info'          => 'Hibah Universitas',
            'gambar'        => 'vr.webp',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Kamera Video",
            'tipe'          => "C200",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'kategori_lab'  => 4,
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'info'          => 'Hibah Department',
            'gambar'        => 'kv.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Kamera Digital",
            'tipe'          => "20MP",
            'stock'         => 10,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'kategori_lab'  => 4,
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'info'          => 'Hibah Department',
            'gambar'        => 'kf.jpg',
        ]);
        Barang::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'nama'          => "Scan",
            'tipe'          => "Epson V39",
            'stock'         => 3,
            'tgl_masuk'     => date('Y-m-d'),
            'show'          => 1,
            'lokasi'        => "Laboratorium Multimedia",
            'kategori_lab'  => 4,
            'satuan_id'     => 5,
            'kategori_id'   => 8,
            'info'          => 'Hibah Department',
            'gambar'        => 'scan.png',
        ]);
    }
}
