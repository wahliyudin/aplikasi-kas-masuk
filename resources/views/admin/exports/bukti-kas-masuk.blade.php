<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet"> --}}
    <title>BUKTI KAS MASUK</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        table.data {
            border-collapse: collapse;
            width: 100%;
        }

        table.data th,
        table.data td {
            padding: 10px;
        }

        table.data th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body style="padding: 10px;">
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size: 25px; font-weight: 600;">BUKTI KAS MASUK</span>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table style="margin: 10px 0; width: 100%;">
        <tbody>
            <tr>
                <td align="left">
                    <table style="margin: 10px 0;">
                        <tbody>
                            <tr>
                                <td>Telah Diterima Dari</td>
                                <td style="padding: 0 10px;">:</td>
                                <td>{{ $cash_in->student->nama }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td style="padding: 0 10px;">:</td>
                                <td>{{ $cash_in->memo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td align="right">
                    <table style="margin: 10px 0; width: 100%;">
                        <tbody>
                            <tr align="right">
                                <td align="right">Nomor</td>
                                <td style="padding: 0 10px;">:</td>
                                <td align="left">{{ $cash_in->no_cek }}</td>
                            </tr>
                            <tr align="right">
                                <td align="right">Tanggal</td>
                                <td style="padding: 0 10px;">:</td>
                                <td align="left">{{ \Carbon\Carbon::make($cash_in->tanggal)->isoFormat('DD MMMM Y') }}
                                </td>
                            </tr>
                            <tr align="right">
                                <td align="right">Rekening Akun</td>
                                <td style="padding: 0 10px;">:</td>
                                <td align="left">{{ $cash_in->account->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


    <table class="data">
        <thead>
            <tr>
                <th align="left">Kode</th>
                <th align="left">Rekening</th>
                <th align="right">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cash_in->cashInDetails as $cashInDetail)
                <tr style="background-color: #538d552c;">
                    <td>{{ $cashInDetail->account->kode }}</td>
                    <td>{{ $cashInDetail->account->nama }}</td>
                    <td align="right">{{ numberFormat($cashInDetail->nominal, 'Rp.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
