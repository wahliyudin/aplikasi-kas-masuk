<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kas Masuk</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            padding: 0;
            margin: 0;
        }

        table {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: #333333;
            border-width: none;
            /*border-color: #666666;*/
            border-collapse: collapse;
            width: 100%;
        }

        th {
            padding-bottom: 8px;
            padding-top: 8px;
            background-color: #dedede;
            /*border-bottom: solid;*/
            text-align: left;
        }

        td {
            text-align: left;
            border-color: #666666;
            background-color: #ffffff;
            line-height: 20px;
        }
    </style>
</head>

<body style="margin-top: 20px; padding: 0 20px;">
    <header style="text-align: center; padding: 10px 0;">
        <h2>Darul Ma'arif</h2>
        <h3 style="color: blue;">Jurnal Kas Masuk</h3>
        <span
            style="color: chocolate; line-height: 25px;">{{ \Carbon\Carbon::make($first_date)->isoFormat('DD MMMM Y') }}
            - {{ \Carbon\Carbon::make($last_date)->isoFormat('DD MMMM Y') }}</span>
    </header>
    <table>
        <thead>
            <tr>
                <th style="padding: 0 0 0 5px;">Tanggal</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cash_ins as $cash_in)
                <tr>
                    <td style="padding: 0 0 0 5px;">
                        {{ \Carbon\Carbon::make($cash_in->tanggal)->format('d/m/Y') }}
                    </td>
                    <td>
                        {{ $cash_in->memo }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 0 5px;">
                        {{ $cash_in->no_cek }}
                    </td>
                    <td>
                        {{ $cash_in->account->kode . ' ' . $cash_in->account->nama }}
                    </td>
                    <td>
                        Rp. {{ numberFormat($cash_in->sebesar) }}
                    </td>
                    <td></td>
                </tr>
                @foreach ($cash_in->cashInDetails as $key => $cashInDetail)
                    @if (count($cash_in->cashInDetails) == $key + 1)
                        <tr>
                            <td style="padding: 0 0 0 5px; border-bottom: 1px solid;">
                                {{ $cash_in->no_cek }}
                            </td>
                            <td style="border-bottom: 1px solid;">
                                {{ $cashInDetail->account->kode . ' ' . $cashInDetail->account->nama }}
                            </td>
                            <td style="border-bottom: 1px solid;"></td>
                            <td style="border-bottom: 1px solid;">
                                Rp. {{ numberFormat($cashInDetail->nominal) }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td style="padding: 0 0 0 5px;">
                                {{ $cash_in->no_cek }}
                            </td>
                            <td>
                                {{ $cashInDetail->account->kode . ' ' . $cashInDetail->account->nama }}
                            </td>
                            <td></td>
                            <td>
                                Rp. {{ numberFormat($cashInDetail->nominal) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
