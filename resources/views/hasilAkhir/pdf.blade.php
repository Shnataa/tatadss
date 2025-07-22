<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Akhir Perhitungan</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #0508B4;
            font-size: 2rem;
        }
        h3 {
            color: #444;
            margin-bottom: 10px;
        }

        /* Table Styles */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background-color: #0508B4;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        td {
            background-color: #f9f9f9;
        }

        /* Hover effect */
        tr:hover {
            background-color: #f1f8ff;
        }

        /* Styled Paragraphs */
        p {
            text-align: center;
            font-size: 1.1rem;
            color: #555;
            margin-top: 20px;
        }
        
        .highlight {
            color: #FFC928;
            font-weight: bold;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            table {
                width: 90%;
            }
            h2 {
                font-size: 1.6rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <h2>Hasil Akhir Perhitungan SMART</h2>

    <!-- Menampilkan Periode -->
    <p>Periode: <span class="highlight">{{ $periode->nama ?? 'Data Periode Tidak Ditemukan' }}</span></p>
    
    @if($hasilTerendah && $hasilTerendah->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Nama Jalan</th>
                    <th>Skor</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilTerendah as $hasil)
                    <tr>
                        <td>{{ $hasil->alternatif->nama ?? 'Nama Alternatif Tidak Ditemukan' }}</td>
                        <td>{{ number_format($hasil->skor, 2) }}</td>
                        <td>{{ $loop->iteration }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Data hasil perhitungan atau alternatif tidak ditemukan.</p>
    @endif
</body>
</html>
