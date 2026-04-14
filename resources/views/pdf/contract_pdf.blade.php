<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Договор № {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            margin: 15mm;
            color: #1a1a1a;
        }
        .contract-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .contract-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .contract-number {
            font-size: 11pt;
            margin-bottom: 5px;
        }
        .contract-date {
            font-size: 10pt;
            color: #555;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 12px 0 8px;
            padding-bottom: 2px;
            border-bottom: 1px solid #ddd;
        }
        /* Измените эти стили в вашем <style> блоке */

        .clause {
            margin-bottom: 4px;
            display: flex; /* Используем flex для выравнивания */
            align-items: flex-start;
        }

        .clause-number {
            font-weight: bold;
            flex-shrink: 0; /* Чтобы номер не сжимался */
            width: 35px;    /* Фиксированная ширина вместо min-width */
        }

        .clause-content {
            text-align: justify;
            flex-grow: 1;
        }

        .subclause {
            margin-left: 35px;
            margin-bottom: 4px;
            display: flex; /* То же самое для подпунктов */
            align-items: flex-start;
        }

        .subclause-number {
            font-weight: bold;
            flex-shrink: 0;
            width: 45px; /* Немного увеличим для длинных номеров типа 1.1.1. */
        }

        .subclause-content {
            text-align: justify;
            flex-grow: 1;
        }
        .text-block {
            margin-bottom: 6px;
            text-align: justify;
        }
        .list-item {
            margin-left: 20px;
            margin-bottom: 2px;
        }
        .signature-block {
            margin-top: 40px;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .signature-item {
            width: 45%;
        }
        .signature-line {
            margin-top: 25px;
            border-top: 1px solid #000;
            width: 100%;
        }
        .signature-label {
            margin-top: 5px;
            font-size: 9pt;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 8pt;
            color: #999;
        }
        table.requisites {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 9pt;
        }
        table.requisites td {
            padding: 2px 0;
            vertical-align: top;
        }
        table.requisites td:first-child {
            width: 130px;
            font-weight: bold;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

@php
    // Функция для суммы прописью
    if (!function_exists('numToStr')) {
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
    }

    // Функция для замены плейсхолдеров
    if (!function_exists('replacePlaceholders')) {
        function replacePlaceholders($text, $replacements) {
            foreach ($replacements as $key => $value) {
                $text = str_replace($key, $value, $text);
            }
            return $text;
        }
    }

    // Получаем данные из отношений
    $client = $contract->providerClient;
    $detail = $client?->detail;
    $serviceRequest = $contract->serviceRequest;
    $sample = $contract->sampleContract;
    $service = $serviceRequest?->service;
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

    // Данные клиента (из ProviderClient и ClientDetail)
    $clientName = $detail?->full_name ?? $client?->name ?? '';
    $clientLegalAddress = $detail?->legal_address ?? $serviceRequest?->installation_address ?? '';
    $clientInn = $detail?->inn ?? '';
    $clientPhone = $detail?->phone ?? '';
    $clientEmail = $detail?->email ?? '';
    $clientPassport = $detail?->passport_data ?? '';

    // Данные организации (провайдера)
    $orgName = $org?->full_name ?? 'ООО "Интернет-Провайдер"';
    $orgLegalAddress = $org?->legal_address ?? 'г. Минск, ул. Примерная, д. 1';
    $orgInn = $org?->inn ?? '123456789';
    $orgPhone = $org?->phone ?? '+375 (17) 123-45-67';
    $orgEmail = $org?->email ?? 'info@provider.by';
    $orgBankDetails = $org?->bank_details ?? '';

    // Данные услуги (из Service через ServiceRequest)
    $serviceName = $service?->name ?? $contract->title ?? $serviceRequest?->title ?? 'Услуги доступа к сети Интернет';
    $serviceSpeed = $service?->internet_speed ?? '100';
    $servicePrice = $service?->price ?? $contract->amount ?? 0;
    $serviceDescription = $service?->description ?? '';

    // Данные договора
    $address = $serviceRequest?->installation_address ?? $clientLegalAddress;
    $amount = number_format((float) $contract->amount, 2, ',', ' ');
    $amountWords = numToStr($contract->amount);

    // Массив для замены плейсхолдеров
    $replacements = [
        // Формат [Плейсхолдер]
        '[Город]' => $city,
        '[Дата]' => $contractDate,
        '[Номер договора]' => $contract->contract_number,
        '[Наименование услуги]' => $serviceName,
        '[Адрес установки]' => $address,
        '[Сумма цифрами]' => $amount,
        '[Сумма прописью]' => $amountWords,
        '[ФИО клиента]' => $clientName,
        '[Юридический адрес клиента]' => $clientLegalAddress,
        '[ИНН клиента]' => $clientInn,
        '[Телефон клиента]' => $clientPhone,
        '[Email клиента]' => $clientEmail,
        '[Паспортные данные]' => $clientPassport,
        '[Наименование организации]' => $orgName,
        '[Юридический адрес организации]' => $orgLegalAddress,
        '[ИНН организации]' => $orgInn,
        '[Телефон организации]' => $orgPhone,
        '[Email организации]' => $orgEmail,
        '[Банковские реквизиты]' => $orgBankDetails,
        '[Скорость]' => $serviceSpeed . ' Мбит/с',
        '[Абонентская плата]' => number_format((float)$servicePrice, 2, ',', ' ') . ' руб.',

        // Формат {{плейсхолдер}}
        '{{client_name}}' => $clientName,
        '{{client_address}}' => $address,
        '{{client_phone}}' => $clientPhone,
        '{{client_email}}' => $clientEmail,
        '{{client_inn}}' => $clientInn,
        '{{client_passport}}' => $clientPassport,
        '{{tariff_name}}' => $serviceName,
        '{{tariff_speed}}' => $serviceSpeed,
        '{{tariff_price}}' => number_format((float)$servicePrice, 2, ',', ' '),
        '{{contract_number}}' => $contract->contract_number,
        '{{current_date}}' => now()->format('d.m.Y'),
    ];
@endphp

    <!-- Шапка договора -->
<div class="contract-header">
    <div class="contract-title">ДОГОВОР НА ОКАЗАНИЕ УСЛУГ ДОСТУПА К СЕТИ ИНТЕРНЕТ</div>
    <div class="contract-number">№ {{ $contract->contract_number }}</div>
    <div class="contract-date">г. {{ $city }} {{ $contractDate }}</div>
</div>

<!-- Динамическое содержимое из шаблона -->
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
                        <span class="clause-number">{{ $item['number'] ?? $item['title'] ?? '' }}</span>
                        <span class="clause-content">{!! nl2br(e($content)) !!}</span>
                    </div>
                    @if(!empty($item['children']))
                        @foreach($item['children'] as $child)
                            @php
                                $childContent = replacePlaceholders($child['content'] ?? '', $replacements);
                            @endphp
                            <div class="subclause">
                                <span class="subclause-number">{{ $child['number'] ?? $child['title'] ?? '' }}</span>
                                <span class="subclause-content">{!! nl2br(e($childContent)) !!}</span>
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
                @if($orgBankDetails)
                    <tr><td>Банковские реквизиты:</td><td>{{ $orgBankDetails }}</td></tr>
                @endif
            </table>
            <div class="signature-line"></div>
            <div class="signature-label">_________________ / _______________</div>
        </div>

        <div class="signature-item">
            <div class="bold">ЗАКАЗЧИК:</div>
            <table class="requisites">
                <tr><td>Наименование:</td><td>{{ $clientName }}</td></tr>
                <tr><td>Адрес:</td><td>{{ $clientLegalAddress }}</td></tr>
                @if($clientInn)<tr><td>ИНН:</td><td>{{ $clientInn }}</td></tr>@endif
                @if($clientPhone)<tr><td>Телефон:</td><td>{{ $clientPhone }}</td></tr>@endif
                @if($clientEmail)<tr><td>Email:</td><td>{{ $clientEmail }}</td></tr>@endif
                @if($clientPassport)<tr><td>Паспортные данные:</td><td>{{ $clientPassport }}</td></tr>@endif
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
