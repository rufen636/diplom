<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Договор № {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 20mm;
            color: #1a1a1a;
        }
        .contract-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .contract-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .contract-number {
            font-size: 12pt;
            margin-bottom: 5px;
        }
        .contract-date {
            font-size: 11pt;
            color: #555;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 15px 0 10px;
            padding-bottom: 3px;
            border-bottom: 1px solid #ddd;
        }
        .clause {
            margin-bottom: 6px;
            align-items: flex-start;
            gap: 8px;
        }
        .clause-number {
            font-weight: bold;
            min-width: 35px;
            flex-shrink: 0;
        }
        .clause-content {
            flex: 1;
            text-align: justify;
        }
        .subclause {
            margin-left: 43px;
            margin-bottom: 6px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .subclause-number {
            font-weight: bold;
            min-width: 35px;
            flex-shrink: 0;
        }
        .subclause-content {
            flex: 1;
            text-align: justify;
        }
        .text-block {
            margin-bottom: 8px;
            text-align: justify;
        }
        .list-item {
            margin-left: 20px;
            margin-bottom: 3px;
        }
        .signature-block {
            margin-top: 50px;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .signature-item {
            width: 45%;
        }
        .signature-line {
            margin-top: 30px;
            border-top: 1px solid #000;
            width: 100%;
        }
        .signature-label {
            margin-top: 5px;
            font-size: 10pt;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 9pt;
            color: #999;
        }
        table.requisites {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table.requisites td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.requisites td:first-child {
            width: 140px;
            font-weight: bold;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

@php
    // Простая функция для суммы прописью
    function numToStr($num) {
        $nul = 'ноль';
        $ten = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];
        $a20 = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
        $tens = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
        $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
        $unit = [
            ['копейка', 'копейки', 'копеек', 1],
            ['рубль', 'рубля', 'рублей', 0],
            ['тысяча', 'тысячи', 'тысяч', 1],
            ['миллион', 'миллиона', 'миллионов', 0],
            ['миллиард', 'миллиарда', 'миллиардов', 0],
        ];

        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) continue;
                $uk = count($unit) - $uk - 1;
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                $out[] = $hundred[$i1];
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                } else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                }
                if ($uk > 1) $out[] = $unit[$uk][0] . ' ' . $unit[$uk][1] . ' ' . $unit[$uk][2];
            }
        } else {
            $out[] = $nul;
        }
        $out[] = $unit[1][0] . ' ' . $unit[1][1] . ' ' . $unit[1][2];
        $out[] = $kop . ' ' . $unit[0][0] . ' ' . $unit[0][1] . ' ' . $unit[0][2];
        return trim(preg_replace('/ {2,}/', ' ', implode(' ', $out)));
    }

    $client = $contract->providerClient;
    $detail = $client?->detail;
    $serviceRequest = $contract->serviceRequest;
    $sample = $contract->sampleContract;
    $org = $organization;

    // Город
    $city = 'Минск';
    if ($org?->legal_address && preg_match('/г\.\s*([^,\s]+)/u', $org->legal_address, $m)) {
        $city = $m[1];
    }

    // Форматирование дат
    $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
    $startDate = $contract->start_date;
    $contractDate = $startDate ? '«' . $startDate->format('d') . '» ' . $months[(int)$startDate->format('n')] . ' ' . $startDate->format('Y') . ' г.' : '"___" _________ 20__ г.';

    // Данные клиента
    $clientName = $detail?->full_name ?? $client?->name ?? '';
    $clientLegalAddress = $detail?->legal_address ?? $serviceRequest?->installation_address ?? '';
    $clientInn = $detail?->inn ?? '';
    $clientPhone = $detail?->phone ?? '';
    $clientEmail = $detail?->email ?? '';

    // Данные организации
    $orgName = $org?->full_name ?? 'ООО "Интернет-Провайдер"';
    $orgLegalAddress = $org?->legal_address ?? 'г. Минск, ул. Примерная, д. 1';
    $orgInn = $org?->providerClient?->inn ?? '123456789';
    $orgPhone = $org?->phone ?? '+375 (17) 123-45-67';
    $orgEmail = $org?->email ?? 'info@provider.by';

    // Услуга
    $serviceName = $contract->title ?? $serviceRequest?->title ?? 'Услуги доступа к сети Интернет';
    $serviceAddress = $serviceRequest?->installation_address ?? $clientLegalAddress;
    $amount = number_format((float) $contract->amount, 2, ',', ' ');
    $amountWords = numToStr($contract->amount);

    // Массив для замены плейсхолдеров
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

    // Функция для замены плейсхолдеров в тексте
    function replacePlaceholders($text, $replacements) {
        foreach ($replacements as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }
@endphp

    <!-- Шапка договора -->
<div class="contract-header">
    <div class="contract-title">ДОГОВОР НА ОКАЗАНИЕ УСЛУГ ДОСТУПА К СЕТИ ИНТЕРНЕТ</div>
    <div class="contract-number">№ {{ $contract->contract_number }}</div>
    <div class="contract-date">г. {{ $city }} {{ $contractDate }}</div>
</div>

<!-- Динамическое содержимое из шаблона -->
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
                    <div class="text-block">{!! nl2br(e($content)) !!}</div>
                @elseif($item['type'] === 'clause')
                    <div class="clause">
                        <div class="clause-number">{{ $item['title'] ?? $item['number'] ?? '' }}</div>
                        <div class="clause-content">{!! nl2br(e($content)) !!}</div>
                    </div>
                    @if(!empty($item['children']))
                        @foreach($item['children'] as $child)
                            @php
                                $childContent = replacePlaceholders($child['content'] ?? '', $replacements);
                            @endphp
                            <div class="subclause">
                                <div class="subclause-number">{{ $child['title'] ?? $child['number'] ?? '' }}</div>
                                <div class="subclause-content">{!! nl2br(e($childContent)) !!}</div>
                            </div>
                        @endforeach
                    @endif
                @elseif($item['type'] === 'list')
                    <div class="text-block">
                        @if($item['title'])
                            <div class="bold">{{ $item['title'] }}</div>
                        @endif
                        @foreach(explode("\n", $content) as $line)
                            @if(trim($line))
                                <div class="list-item">• {!! nl2br(e(trim($line))) !!}</div>
                            @endif
                        @endforeach
                    </div>
                @elseif($item['type'] === 'signature')
                    <div class="signature-block">
                        {!! nl2br(e($content)) !!}
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
@else
    <div class="section">
        <div class="text-block">Шаблон договора не найден</div>
    </div>
@endif

<!-- Реквизиты и подписи -->
<div class="signature-block">
    <div class="section-title">РЕКВИЗИТЫ И ПОДПИСИ СТОРОН</div>

    <div class="signature-row">
        <div class="signature-item">
            <div class="bold">ИСПОЛНИТЕЛЬ:</div>
            <table class="requisites">
                <tr><td>Наименование:</td><td>{{ $orgName }}</td></tr>
                <tr><td>Юридический адрес:</td><td>{{ $orgLegalAddress }}</td></tr>
                <tr><td>ИНН:</td><td>{{ $orgInn }}</td></tr>
                <tr><td>Телефон:</td><td>{{ $orgPhone }}</td></tr>
                <tr><td>Email:</td><td>{{ $orgEmail }}</td></tr>
            </table>
            <div class="signature-line"></div>
            <div class="signature-label">_________________ / _______________</div>
        </div>

        <div class="signature-item">
            <div class="bold">ЗАКАЗЧИК:</div>
            <table class="requisites">
                <tr><td>Наименование:</td><td>{{ $clientName }}</td></tr>
                <tr><td>Адрес:</td><td>{{ $clientLegalAddress }}</td></tr>
                <tr><td>ИНН:</td><td>{{ $clientInn }}</td></tr>
                <tr><td>Телефон:</td><td>{{ $clientPhone }}</td></tr>
                <tr><td>Email:</td><td>{{ $clientEmail }}</td></tr>
            </table>
            <div class="signature-line"></div>
            <div class="signature-label">_________________ / _______________</div>
        </div>
    </div>
</div>

<div class="footer">
    <p>Документ сформирован автоматически {{ date('d.m.Y H:i:s') }}</p>
</div>

</body>
</html>
