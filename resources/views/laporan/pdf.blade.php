<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harga Bahan Baku</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 30px;
            color: #333;
            font-size: 10pt;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 20px;
        }

        .header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18pt;
            margin: 5px 0;
            color: #1a5276;
            font-weight: bold;
        }

        .header h2 {
            font-size: 14pt;
            margin: 5px 0;
            color: #2874a6;
            font-weight: normal;
        }

        .header p {
            margin: 3px 0;
            font-size: 10pt;
        }

        .report-info {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #1a5276;
        }

        .report-info {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #1a5276;
            font-size: 10pt;
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px auto;
            margin-bottom: 8px;
            align-items: start;
        }

        .info-label {
            font-weight: bold;
            color: #1a5276;
            position: relative;
            padding-right: 15px;
        }

        .info-label::after {
            content: ":";
            position: absolute;
            right: 5px;
        }

        .info-value {
            word-break: break-word;
        }

        .pasar-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 2px;
        }

        .pasar-item {
            background-color: #eaf2f8;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9pt;
            white-space: nowrap;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-line {
            height: 1px;
            background-color: #333;
            margin: 50px 0 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9pt;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #1a5276;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .table-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 30px 0 10px;
            color: #1a5276;
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            font-size: 8pt;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .highlight {
            background-color: #fffde7;
            font-weight: bold;
        }

        .month-column {
            min-width: 60px;
        }
    </style>
</head>

@php
    $tahun = Carbon\Carbon::createFromFormat('F', $nama_bulan[0])->year;
@endphp

<body>
    <div class="header">
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
            <div>
                <h1>LAPORAN HARGA BAHAN BAKU</h1>
                <h2>TAHUN {{ $tahun }} - {{ implode(', ', $nama_bulan) }}</h2>
                <p>Dinas Perdagangan Kabupaten Banyuasin</p>
                <p>Provinsi Sumatera Selatan</p>
            </div>
        </div>
    </div>


    <div class="report-info">
        <div class="info-row">
            <div class="info-label">Provinsi</div>
            <div class="info-value">Sumatera Selatan</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kabupaten/Kota</div>
            <div class="info-value">Kabupaten Banyuasin</div>
        </div>
        <div class="info-row">
            <div class="info-label">Pasar Pantauan</div>
            <div class="info-value">
                <div class="pasar-list">
                    @foreach ($pasars as $pasar)
                        <span class="pasar-item">{{ ucfirst($pasar) }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Periode Laporan</div>
            <div class="info-value">{{ implode(' - ', $nama_bulan) }} {{ $tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Cetak</div>
            <div class="info-value">{{ date('d F Y') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35%;">Nama Bahan Baku</th>
                <th style="width: 15%;">Satuan</th>
                @foreach ($nama_bulan as $bulan)
                    <th class="month-column">{{ $bulan }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanData as $index => $data)
                <tr class="{{ $index % 5 == 0 ? 'highlight' : '' }}">
                    <td>{{ $data['nama'] }}</td>
                    <td class="text-center">{{ $data['satuan'] }}</td>
                    <td class="text-right">
                        {{ $data['bulan_3'] ? 'Rp' . number_format($data['bulan_3'], 0, ',', '.') : '-' }}</td>
                    <td class="text-right">
                        {{ $data['bulan_2'] ? 'Rp' . number_format($data['bulan_2'], 0, ',', '.') : '-' }}</td>
                    <td class="text-right">
                        {{ $data['bulan_1'] ? 'Rp' . number_format($data['bulan_1'], 0, ',', '.') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <h1 style="padding-bottom: 5px">Kesimpulan</h1>
        <p style="text-align: justify">{{$kesimpulan}}</p>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Pemantauan Harga Bahan Baku Dinas Perdagangan Kabupaten
        Banyuasin
        <br>
        {{ date('d F Y H:i:s') }}
    </div>

</body>

</html>
