<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            font-size: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        .status-selesai {
            color: #008000;
        }

        .status-terdaftar {
            color: #0000FF;
        }

        .belum-tersedia {
            color: rgb(142, 0, 0);
        }

        /* Header styling */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-content {
            flex-grow: 1;
            text-align: center;
        }

        .header-content h1,{
            margin-top: -5%;
            color: #0B2B8A;
        }

        .header-content h1 {
            margin: 0;
            font-size: 24px;
        }

        .header-content p {
            margin: 0;
            font-size: 12px;
        }

        .divider {
            border-top: 2px solid black;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Header section -->
    <div class="header">
        <div class="header-content">
            <h1 style="font-size: 30px">PT BARTECH MEDIA SOLUSI</h1>
            <p>Jalan Holis, Ruko, Jl. Holis Regency No.B-02, Babakan, Kec. Babakan Ciparay, Kota Bandung, <br> Jawa Barat 40222</p>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Judul berdasarkan data pelatihan dari salah satu sertifikat -->
    <h2>Data Peserta Professional Training Program <br>
        {{ $sertifikat->first()->training ? $sertifikat->first()->training->nama_training : '-' }}
    </h2>

    <!-- Table of data -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Penerima</th>
                <th>Nama Pelatihan</th>
                <th>Nomor Sertifikat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sertifikat as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->nama_penerima }}</td>
                    <td>{{ $data->training ? $data->training->nama_training : '-' }}</td>
                    <td>
                        @if ($data->status)
                            {{ sprintf('NO. %03d/%s/%s/%d', $data->id, $data->training->kode, 'IV', date('Y')) }}
                        @else
                            <span class="belum-tersedia">Belum Tersedia</span>
                        @endif
                    </td>
                    <td class="{{ $data->status ? 'status-selesai' : 'status-terdaftar' }}">
                        {{ $data->status ? 'Selesai Pelatihan' : 'Terdaftar' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
