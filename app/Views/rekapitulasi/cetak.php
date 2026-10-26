<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekapitulasi LHP</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 30px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
        }

        .line {
            border-bottom: 2px solid #222;
            margin-top: 15px;
        }

        .info {
            margin-bottom: 15px;
            line-height: 1.7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 35px;
            text-align: right;
        }

        .print-button {
            margin-bottom: 20px;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }

        @media print {
            body {
                margin: 15mm;
            }

            .print-button {
                display: none;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <button
        class="print-button"
        onclick="window.print()"
    >
        Cetak / Simpan PDF
    </button>

    <div class="header">
        <h2>BADAN PENGAWAS PEMILIHAN UMUM</h2>
        <h2>KABUPATEN SUBANG</h2>
        <p>Rekapitulasi Laporan Hasil Pengawasan</p>

        <div class="line"></div>
    </div>

    <div class="info">
        <div>
            <strong>Periode:</strong>
            <?= esc($bulan ?: 'Semua Bulan') ?>
            <?= esc($tahun ?: 'Semua Tahun') ?>
        </div>

        <div>
            <strong>Tanggal Cetak:</strong>
            <?= esc($tanggalCetak) ?>
        </div>

        <div>
            <strong>Jumlah Data:</strong>
            <?= count($lhp) ?> LHP
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px;">No.</th>
                <th>Nomor LHP</th>
                <th>Tanggal</th>
                <th>Wilayah</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($lhp)): ?>

                <tr>
                    <td colspan="4" class="center">
                        Tidak ada data LHP.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach ($lhp as $index => $item): ?>
                    <tr>
                        <td class="center">
                            <?= $index + 1 ?>
                        </td>

                        <td>
                            <?= esc($item['nomor_lhp'] ?? '-') ?>
                        </td>

                        <td>
                            <?= !empty($item['waktu_pengawasan'])
                                ? esc(date('d-m-Y H:i', strtotime($item['waktu_pengawasan'])))
                                : '-' ?>
                        </td>

                        <td>
                            <?= esc($item['desa'] ?? '-') ?>
                        </td>

                    </tr>
                <?php endforeach; ?>

            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Subang, <?= esc($tanggalCetak) ?>
        <br><br><br><br>
        <strong>Bawaslu Kabupaten Subang</strong>
    </div>

</body>
</html>