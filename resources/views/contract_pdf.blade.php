<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Договор № {{ $contract->contract_number }}</title>
    <style>
        @page {
            margin: 20mm 25mm 20mm 25mm;
            @bottom-center {
                content: "Страница " counter(page) " из " counter(pages);
                font-size: 9pt;
                color: #666;
            }
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: white;
            position: relative;
        }

        .header-line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 0;
            margin: 20px 0;
            text-align: center;
        }

        .contract-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .contract-title {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .contract-number {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .contract-city-date {
            font-size: 12pt;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 30px 0 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(to right, #000 70%, transparent 70%);
        }

        .clause {
            margin-bottom: 12px;
            text-align: justify;
        }

        .clause-number {
            font-weight: bold;
            display: inline-block;
            min-width: 25px;
            vertical-align: top;
        }

        .subclause {
            margin: 8px 0 8px 30px;
            text-align: justify;
        }

        .subclause-number {
            font-weight: bold;
            display: inline-block;
            min-width: 20px;
            vertical-align: top;
        }

        .list-item {
            margin: 6px 0 6px 40px;
            text-align: justify;
        }

        .list-number {
            font-weight: bold;
            display: inline-block;
            min-width: 20px;
            vertical-align: top;
        }

        table.requisites {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11pt;
        }

        table.requisites td {
            padding: 4px 8px 4px 0;
            vertical-align: top;
            border-bottom: 1px dotted #999;
        }

        table.requisites td:first-child {
            width: 160px;
            font-weight: bold;
            color: #000;
        }

        .signature-block {
            margin-top: 60px;
            page-break-inside: avoid;
        }

        .signature-section {
            margin-top: 40px;
        }

        .signature-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            text-decoration: underline;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            gap: 60px;
            margin-top: 40px;
        }

        .signature-item {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            height: 25px;
            border-bottom: 1px solid #000;
            margin: 20px 0;
            position: relative;
        }

        .signature-line::after {
            content: '';
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            height: 1px;
            border-bottom: 1px solid #999;
        }

        .signature-label {
            font-size: 11pt;
            margin-top: 8px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .double-space {
            margin-bottom: 24pt;
        }

        .caps {
            font-variant: small-caps;
            letter-spacing: 0.5px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        @media print {
            body { margin: 0; }
            .signature-row { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

@php
    use App\Helpers\NumToStr;

    $client = $contract->providerClient;
    $detail = $client?->detail;
    $serviceRequest = $contract->serviceRequest;
    $sample = $contract->sampleContract;
    $org = $organization;

    $city = 'Минск';
    if ($org?->legal_address && preg_match('/г\.\s*([^,\s]+)/u', $org->legal_address, $m)) {
        $city = $m[1];
    }

    $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
    $startDate = $contract->start_date;
    $contractDate = $startDate ? '«' . $startDate->format('d') . '» ' . $months[(int)$startDate->format('n')] . ' ' . $startDate->format('Y') . ' г.' : '"___" _________ 20__ г.';

    $clientName = $detail?->full_name ?? $client?->name ?? '';
    $clientLegalAddress = $detail?->legal_address ?? $serviceRequest?->installation_address ?? '';
    $clientInn = $detail?->inn ?? '';
    $clientPhone = $detail?->phone ?? '';
    $clientEmail = $detail?->email ?? '';

    $orgName = $org?->full_name ?? 'ООО "Интернет-Провайдер"';
    $orgLegalAddress = $org?->legal_address ?? 'г. Минск, ул. Примерная, д. 1';
    $orgInn = $org?->providerClient?->inn ?? '123456789';
    $orgPhone = $org?->phone ?? '+375 (17) 123-45-67';
    $orgEmail = $org?->email ?? 'info@provider.by';

    $serviceName = $contract->title ?? $serviceRequest?->title ?? 'Услуги доступа к сети Интернет';
    $serviceAddress = $serviceRequest?->installation_address ?? $clientLegalAddress;
    $amount = number_format((float) $contract->amount, 2, ',', ' ');
    $amountWords = NumToStr::numToStr($contract->amount);

    $replacements = [
        '[Город]' => $city,
        '[Дата]' => $contractDate,
        '[Номер договора]' => $contract->contract_number,
        '[Наименование услуги]' => $serviceName,
        '[Адрес установки]' => $serviceAddress,
        '[Сумма цифрами]' => $amount,
        '[Сумма прописью]' => $amountWords,
        '[ФИО клиента]' => $clientName,
        '[Юридический адрес клиента]' => $clientLegalAddress,
        '[ИНН клиента]' => $clientInn,
        '[Телефон клиента]' => $clientPhone,
        '[Email клиента]' => $clientEmail,
        '[Наименование организации]' => $orgName,
        '[Юридический адрес организации]' => $orgLegalAddress,
        '[ИНН организации]' => $orgInn,
        '[Телефон организации]' => $orgPhone,
        '[Email организации]' => $orgEmail,
        '[Скорость]' => '100 Мбит/с',
        '[Абонентская плата]' => $amount,
    ];

    function replacePlaceholders($text, $replacements) {
        foreach ($replacements as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }
@endphp

<div class="header-line"></div>

<div class="contract-header">
    <div class="contract-title">ДОГОВОР<br>НА ОКАЗАНИЕ УСЛУГ ДОСТУПА К СЕТИ ИНТЕРНЕТ</div>
    <div class="contract-number">№ {{ $contract->contract_number }}</div>
    <div class="contract-city-date">г. {{ $city }} «{{ $contractDate }}»</div>
</div>

@if($sample && $sample->sections)
    @foreach($sample->sections as $section)
        <div class="section">
            @if(!empty($section['title']))
                <div class="section-title">{{ $section['title'] }}</div>
            @endif

            @foreach($section['items'] as $item)
                @php
                    $content = replacePlaceholders($item['content'] ?? '', $replacements);
                @endphp

                @if($item['type'] === 'text')
                    <div class="clause double-space">asfda{!! nl2br(e($content)) !!}</div>
                @elseif($item['type'] === 'clause')
                    <div class="clause">
                        2222
                        <span class="clause-number">{{ $item['title'] ?? $item['number'] ?? '' }}</span>
                        <span >{!! nl2br(e($content)) !!}</span>
                    </div>
                    @if(!empty($item['children']))
                        @foreach($item['children'] as $child)
                            @php
                                $childContent = replacePlaceholders($child['content'] ?? '', $replacements);
                            @endphp
                            <div class="subclause">
                                3333
                                <span class="subclause-number">{{ $child['title'] ?? $child['number'] ?? '' }}</span>
                                <span >{!! nl2br(e($childContent)) !!}</span>
                            </div>
                        @endforeach
                    @endif
                @elseif($item['type'] === 'list')
                    <div class="clause">
                        @if($item['title'])
                            <div class="caps" style="margin-bottom: 10px;">{{ $item['title'] }}</div>
                        @endif
                        @foreach(explode("\n", $content) as $line)
                            @if(trim($line))
                                <div class="list-item">
                                    <span class="list-number">{{ $loop->iteration }}.</span>
                                    {!! nl2br(e(trim($line))) !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
@else
    <div class="section">
        <div class="clause">Шаблон договора не найден</div>
    </div>
@endif

<div class="signature-block">
    <div class="signature-section">
        <div class="signature-title">РЕКВИЗИТЫ И ПОДПИСИ СТОРОН</div>

        <div class="signature-row">
            <div class="signature-item">
                <div style="font-weight: bold; margin-bottom: 15px;">ИСПОЛНИТЕЛЬ:</div>
                <table class="requisites">
                    <tr><td>Наименование:</td><td>{{ $orgName }}</td></tr>
                    <tr><td>Юридический адрес:</td><td>{{ $orgLegalAddress }}</td></tr>
                    <tr><td>УНП:</td><td>{{ $orgInn }}</td></tr>
                    <tr><td>Телефон:</td><td>{{ $orgPhone }}</td></tr>
                    <tr><td>E-mail:</td><td>{{ $orgEmail }}</td></tr>
                </table>
                <div class="signature-line"></div>
                <div class="signature-label caps">_______________________ / ________________</div>
            </div>

            <div class="signature-item">
                <div style="font-weight: bold; margin-bottom: 15px;">ЗАКАЗЧИК:</div>
                <table class="requisites">
                    <tr><td>ФИО / Наименование:</td><td>{{ $clientName }}</td></tr>
                    <tr><td>Адрес регистрации / нахождения:</td><td>{{ $clientLegalAddress }}</td></tr>
                    @if($clientInn)
                        <tr><td>УНП / ИНН:</td><td>{{ $clientInn }}</td></tr>
                    @endif
                    <tr><td>Телефон:</td><td>{{ $clientPhone }}</td></tr>
                    <tr><td>E-mail:</td><td>{{ $clientEmail }}</td></tr>
                </table>
                <div class="signature-line"></div>
                <div class="signature-label caps">_______________________ / ________________</div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    Документ сформирован автоматически {{ date('d.m.Y г. H:i:s') }}
</div>

</body>
</html>
