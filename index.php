<?php

function hitungNilaiAkhir($tugas, $uts, $uas)
{
    $nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);
    return round($nilaiAkhir, 2); 
}


function tentukanGrade($nilaiAkhir)
{
    if ($nilaiAkhir >= 85) {
        return "A";
    } elseif ($nilaiAkhir >= 75) {
        return "B";
    } elseif ($nilaiAkhir >= 65) {
        return "C";
    } elseif ($nilaiAkhir >= 50) {
        return "D";
    } else {
        return "E";
    }
}


function tentukanStatus($nilaiAkhir)
{
    if ($nilaiAkhir >= 65) {
        return "Lulus";
    }
    return "Tidak Lulus";
}


function validasiNilai($nilai)
{
    return is_numeric($nilai) && $nilai >= 0 && $nilai <= 100;
}


function tentukanPredikat($nilaiAkhir)
{
    if ($nilaiAkhir >= 85) {
        return "Sangat Baik";
    } elseif ($nilaiAkhir >= 75) {
        return "Baik";
    } elseif ($nilaiAkhir >= 65) {
        return "Cukup";
    } elseif ($nilaiAkhir >= 50) {
        return "Kurang";
    } else {
        return "Sangat Kurang";
    }
}


function formatNilai($angka)
{
    $hasil = number_format($angka, 2, ',', '.');
    return rtrim(rtrim($hasil, '0'), ','); 
}


function prosesMahasiswa($mhs)
{
    $hasil = $mhs;
    $hasil['error'] = [];

    
    foreach (['tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'] as $key => $label) {
        if (!validasiNilai($mhs[$key])) {
            $hasil['error'][] = "Nilai $label harus berupa angka 0 sampai 100.";
        }
    }

   
    if (empty($hasil['error'])) {
        $hasil['nilaiAkhir'] = hitungNilaiAkhir($mhs['tugas'], $mhs['uts'], $mhs['uas']);
        $hasil['grade']      = tentukanGrade($hasil['nilaiAkhir']);
        $hasil['status']     = tentukanStatus($hasil['nilaiAkhir']);
        $hasil['predikat']   = tentukanPredikat($hasil['nilaiAkhir']);
    }
    return $hasil;
}

$nama = "Andi";
$nim  = "231234567";


$nilaiTugas = 80;
$nilaiUts   = 75;
$nilaiUas   = 90;


$nilaiAkhir = hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas);
$grade      = tentukanGrade($nilaiAkhir);
$status     = tentukanStatus($nilaiAkhir);


$daftarMahasiswa = [
    ["nama" => "Andi",  "nim" => "231234567", "tugas" => 80, "uts" => 75,  "uas" => 90],
    ["nama" => "Budi",  "nim" => "231234568", "tugas" => 90, "uts" => 88,  "uas" => 95],
    ["nama" => "Citra", "nim" => "231234569", "tugas" => 70, "uts" => 60,  "uas" => 68],
    ["nama" => "Dewi",  "nim" => "231234570", "tugas" => 40, "uts" => 55,  "uas" => 45],
    ["nama" => "Eko",   "nim" => "231234571", "tugas" => 85, "uts" => 120, "uas" => 80], 
];

$hasilSemua = [];
foreach ($daftarMahasiswa as $mhs) {
    $hasilSemua[] = prosesMahasiswa($mhs);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Nilai Mahasiswa</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 24px 16px;
        }
        .wadah { max-width: 900px; margin: 0 auto; }
        h1 { margin: 0 0 4px; font-size: 26px; }
        .sub { color: #64748b; margin: 0 0 24px; }
        .kartu {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }
        .kartu h2 { margin-top: 0; font-size: 18px; color: #0f4c81; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 9px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #0f4c81; color: #fff; font-weight: 600; }
        .lulus { color: #15803d; font-weight: 700; }
        .gagal { color: #b91c1c; font-weight: 700; }
        .judul-daftar { font-weight: 600; margin: 18px 0 6px; }
        .kartu ul { margin: 0; padding-left: 26px; line-height: 1.8; }
        .rumus-teks { margin: 0; font-family: Consolas, monospace; color: #15803d; }
        .tabel-geser { overflow-x: auto; }
        .error { color: #b91c1c; font-size: 13px; }
    </style>
</head>
<body>
<div class="wadah">

    <h1>Program Penghitung Nilai Mahasiswa</h1>
    <p class="sub">Tugas 2 - Pemrograman Berbasis Web (PHP)</p>

    
    <div class="kartu">

        <p class="judul-daftar">Data mahasiswa</p>
        <ul>
            <li>Nama: <?= $nama ?></li>
            <li>NIM: <?= $nim ?></li>
            <li>Nilai Tugas: <?= $nilaiTugas ?></li>
            <li>Nilai UTS: <?= $nilaiUts ?></li>
            <li>Nilai UAS: <?= $nilaiUas ?></li>
        </ul>

        <p class="judul-daftar">Hasil perhitungan</p>
        <ul>
            <li>Nilai Akhir: <?= formatNilai($nilaiAkhir) ?></li>
            <li>Grade: <?= $grade ?></li>
            <li>Status: <span class="<?= $status == 'Lulus' ? 'lulus' : 'gagal' ?>"><?= $status ?></span></li>
        </ul>

        <p class="judul-daftar">Nilai akhir diperoleh dari</p>
        <p class="rumus-teks">
            (<?= $nilaiTugas ?> &times; 0,3) + (<?= $nilaiUts ?> &times; 0,3) + (<?= $nilaiUas ?> &times; 0,4) = <?= formatNilai($nilaiAkhir) ?>.
        </p>
    </div>

    
    <div class="kartu">
        <h2>Tantangan Tambahan: Nilai Banyak Mahasiswa</h2>
        <div class="tabel-geser">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Predikat</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($hasilSemua as $i => $m): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $m['nama'] ?></td>
                        <td><?= $m['nim'] ?></td>
                        <td><?= $m['tugas'] ?></td>
                        <td><?= $m['uts'] ?></td>
                        <td><?= $m['uas'] ?></td>
                        <?php if (!empty($m['error'])): ?>
                            <td colspan="4" class="error">
                                <?= implode('<br>', $m['error']) ?>
                            </td>
                        <?php else: ?>
                            <td><strong><?= formatNilai($m['nilaiAkhir']) ?></strong></td>
                            <td><strong><?= $m['grade'] ?></strong></td>
                            <td><?= $m['predikat'] ?></td>
                            <td class="<?= $m['status'] == 'Lulus' ? 'lulus' : 'gagal' ?>"><?= $m['status'] ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <p class="error" style="margin-top:12px;">
            * Data Eko sengaja memakai nilai UTS 120 untuk menunjukkan validasi rentang 0 - 100.
        </p>
    </div>

</div>
</body>
</html>