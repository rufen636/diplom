<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Акт приема-передачи №{{ $transferAct->act_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            margin: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-item {
            width: 45%;
        }
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>АКТ ПРИЕМА-ПЕРЕДАЧИ ОБОРУДОВАНИЯ</h1>
    <p>№ {{ $transferAct->act_number }} от {{ date('d.m.Y', strtotime($transferAct->transfer_date)) }}</p>
</div>

<table class="info-table">
    <tr>
        <td>Адрес установки:</td>
        <td>{{ $transferAct->installation_address ?? '—' }}</td>
    </tr>
    <tr>
        <td>Статус:</td>
        <td>{{ $transferAct->status ?? '—' }}</td>
    </tr>
    <tr>
        <td>Дата окончания:</td>
        <td>{{ $transferAct->expiration_date ? date('d.m.Y', strtotime($transferAct->expiration_date)) : '—' }}</td>
    </tr>
</table>

@if($transferAct->equipments && $transferAct->equipments->count())
    <h3>Оборудование:</h3>
    <table class="info-table">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>MAC-адрес</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transferAct->equipments as $equipment)
            <tr>
                <td>{{ $equipment->name ?? $equipment->model ?? '—' }}</td>
                <td>{{ $equipment->mac_address ?? '—' }}</td>
                <td>{{ $equipment->price ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<div class="signatures">
    <div class="signature-item">
        <div class="signature-line">_________________</div>
        <div>Подпись провайдера</div>
    </div>
    <div class="signature-item">
        <div class="signature-line">_________________</div>
        <div>Подпись клиента</div>
    </div>
</div>

<div class="footer">
    <p>Документ сформирован автоматически {{ date('d.m.Y H:i:s') }}</p>
</div>
</body>
</html>
