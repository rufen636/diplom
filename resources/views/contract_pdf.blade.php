<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Договор {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 20mm;
            color: #1a1a1a;
        }
        .contract-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .contract-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .contract-number {
            font-size: 12pt;
        }
        .section {
            margin-bottom: 14px;
            text-align: justify;
        }
        h2 {
            font-size: 11pt;
            font-weight: bold;
            margin: 16px 0 8px;
        }
        .preamble {
            margin-bottom: 16px;
        }
        .signature-block {
            margin-top: 32px;
            font-size: 10pt;
        }
        .signature-block .party {
            margin-bottom: 20px;
        }
        .signature-block .party-name {
            font-weight: bold;
            margin-bottom: 4px;
        }
        .signature-line {
            margin-top: 24px;
        }
        table.requisites {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }
        table.requisites td {
            padding: 2px 8px 2px 0;
            vertical-align: top;
        }
    </style>
</head>
<body>
@php
    use App\Helpers\NumToStr;

    $sample = $contract->sampleContract;
    $client = $contract->providerClient;
    $detail = $client?->detail;
    $org = $organization ?? null;

    // Определяем город из адреса (юр. адрес организации или клиента)
    $city = '_____________';
    if ($org?->legal_address) {
        if (preg_match('/г\.\s*([^,\s]+)/u', $org->legal_address, $m)) {
            $city = $m[1];
        } elseif (preg_match('/^([^,]+)/u', $org->legal_address, $m)) {
            $city = trim($m[1]);
        }
    }
    if ($city === '_____________' && ($detail?->legal_address ?? $client?->address)) {
        $addr = $detail?->legal_address ?? $client?->address;
        if (preg_match('/г\.\s*([^,\s]+)/u', $addr, $m)) {
            $city = $m[1];
        }
    }

    $clientFullName = $detail?->full_name ?? $client?->name ?? '';
    $clientLegalAddress = $detail?->legal_address ?? $client?->address ?? '';
    $clientInn = $detail?->inn ?? $client?->inn ?? '';
    $clientKpp = $detail?->kpp ?? $client?->kpp ?? '';
    $clientInnKpp = trim(implode(' / ', array_filter([$clientInn, $clientKpp])), ' /');
    $clientBankDetails = $detail?->bank_details ?? '';

    $orgFullName = $org?->full_name ?? '';
    $orgLegalAddress = $org?->legal_address ?? '';
    $orgInn = $org?->providerClient?->inn ?? '';
    $orgKpp = $org?->providerClient?->kpp ?? '';
    $orgInnKpp = trim(implode(' / ', array_filter([$orgInn, $orgKpp])), ' /');
    $orgBankDetails = $org?->bank_details ?? '';

    $amount = (float) $contract->amount;
    $amountFormatted = number_format($amount, 2, ',', ' ');
    $amountWords = NumToStr::amountWordsOnly($amount);

    $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
    $startDate = $contract->start_date;
    $endDate = $contract->end_date;
    $startDateFormatted = $startDate ? '«' . $startDate->format('d') . '» ' . $months[(int)$startDate->format('n')] . ' ' . $startDate->format('Y') . ' г.' : '';
    $endDateFormatted = $endDate ? '«' . $endDate->format('d') . '» ' . $months[(int)$endDate->format('n')] . ' ' . $endDate->format('Y') . ' г.' : '';
    $contractDateFormatted = $startDate ? '«' . $startDate->format('d') . '» ' . $months[(int)$startDate->format('n')] . ' ' . $startDate->format('Y') . ' г.' : '"___" _________ 20__ г.';

    $replacements = [
        // Формат {{PLACEHOLDER}}
        '{{CONTRACT_NUMBER}}' => $contract->contract_number ?? '',
        '{{CONTRACT_TITLE}}' => $contract->title ?? '',
        '{{CLIENT_NAME}}' => $client?->name ?? '',
        '{{CLIENT_LEGAL_ADDRESS}}' => $clientLegalAddress,
        '{{CLIENT_INN}}' => $clientInn,
        '{{CLIENT_KPP}}' => $clientKpp,
        '{{CLIENT_FULL_NAME}}' => $clientFullName,
        '{{BANK_DETAILS}}' => $clientBankDetails,
        '{{AMOUNT}}' => $amountFormatted . ' руб.',
        '{{AMOUNT_WORDS}}' => $amountWords,
        '{{START_DATE}}' => $contract->start_date?->format('d.m.Y') ?? '',
        '{{END_DATE}}' => $contract->end_date?->format('d.m.Y') ?? '',
        '{{ACTUAL_ADDRESS}}' => $detail?->actual_address ?? $client?->address ?? '',
        '{{PHONE}}' => $detail?->phone ?? $client?->phone ?? '',
        '{{EMAIL}}' => $detail?->email ?? $client?->email ?? '',
        // Реквизиты организации (Исполнитель)
        '{{ORG_FULL_NAME}}' => $orgFullName,
        '{{ORG_LEGAL_ADDRESS}}' => $orgLegalAddress,
        '{{ORG_INN_KPP}}' => $orgInnKpp,
        '{{ORG_BANK_DETAILS}}' => $orgBankDetails,
        // Реквизиты клиента (Заказчик)
        '{{CLIENT_INN_KPP}}' => $clientInnKpp,
        // Плейсхолдеры из сидов шаблонов [Плейсхолдер]
        // Исполнитель = организация (ProviderDetail), Заказчик = клиент (ProviderClient + ClientDetail)
        '[Город]' => $city,
        '[Полное имя]' => $orgFullName,
        '[Полное наименование организации]' => $orgFullName,
        '[Должность, ФИО]' => $client?->contact_person ?? '',
        '[Устава/Доверенности]' => 'Устава',
        '[Наименование]' => $clientFullName ?: $client?->name ?? '',
        '________ (________________)' => $amountFormatted . ' (' . $amountWords . ')',
        '________ (________________) рублей' => $amountFormatted . ' (' . $amountWords . ') рублей',
        '«___» _________ 20__ г.' => $contractDateFormatted,
        '«___» _________ 20__ г. по «___» _________ 20__ г.' => $startDateFormatted . ' по ' . $endDateFormatted,
        'оказать услуги по __________________________________________________' => 'оказать услуги по ' . ($contract->title ?: $contract->description ?: '__________________________________________________'),
    ];

    // Доп. замены для блока подписей (Исполнитель / Заказчик)
    $signReplacements = array_merge($replacements, [
        'ИСПОЛНИТЕЛЬ:' => 'ИСПОЛНИТЕЛЬ:',
    ]);
@endphp

<div class="contract-header">
    <div class="contract-title">Договор № {{ $contract->contract_number }}</div>
    <div class="contract-number">{{ $contract->title }}</div>
</div>

@if($sample)
    @if($sample->preamble)
        @php
            $preamble = str_replace(array_keys($replacements), array_values($replacements), $sample->preamble);
            $longBlank = '__________________________________________________';
            $shortBlank = '__________________________________';
            $longCount = 0;
            $preamble = preg_replace_callback(
                '/' . preg_quote($longBlank, '/') . '|' . preg_quote($shortBlank, '/') . '/',
                function ($m) use (&$longCount, $clientFullName, $client) {
                    $isLong = strlen($m[0]) > 30;
                    if ($isLong) {
                        $longCount++;
                        if ($longCount === 1) return $clientFullName ?: $client?->name ?? $m[0];
                        if ($longCount === 2) return $client?->contact_person ?? $m[0];
                    } else {
                        return 'Устава';
                    }
                    return $m[0];
                },
                $preamble
            );
        @endphp
        <div class="section preamble">{!! $preamble !!}</div>
    @endif
    @if($sample->subject_of_contract)
        <h2>1. Предмет договора</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->subject_of_contract) !!}</div>
    @endif
    @if(($sample->rights ?? $sample->rights_and_obligations ?? null))
        <h2>2. Права и обязанности сторон</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->rights ?? $sample->rights_and_obligations ?? '') !!}</div>
    @endif
    @if($sample->payment_terms)
        <h2>3. Условия оплаты</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->payment_terms) !!}</div>
    @endif
    @if($sample->liability)
        <h2>4. Ответственность сторон</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->liability) !!}</div>
    @endif
    @if($sample->force_majeure)
        <h2>5. Форс-мажор</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->force_majeure) !!}</div>
    @endif
    @if($sample->dispute_resolution)
        <h2>6. Разрешение споров</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->dispute_resolution) !!}</div>
    @endif
    @if($sample->confidentiality)
        <h2>7. Конфиденциальность</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->confidentiality) !!}</div>
    @endif
    @if($sample->other_conditions)
        <h2>8. Прочие условия</h2>
        <div class="section">{!! str_replace(array_keys($replacements), array_values($replacements), $sample->other_conditions) !!}</div>
    @endif
    @if($sample->signatures_block)
        <div class="signature-block section">
            @php
                $sigBlock = str_replace(array_keys($replacements), array_values($replacements), $sample->signatures_block);
                if (str_contains($sigBlock, 'ИСПОЛНИТЕЛЬ:') && str_contains($sigBlock, 'ЗАКАЗЧИК:')) {
                    $sections = preg_split('/(ЗАКАЗЧИК:)/', $sigBlock, 2, PREG_SPLIT_DELIM_CAPTURE);
                    $executorPart = $sections[0] ?? '';
                    $clientPart = ($sections[1] ?? '') . ($sections[2] ?? '');
                    $executorPart = str_replace(
                        ['[Наименование]', 'Адрес: __________________', 'ИНН/КПП: ________________', 'Р/с: ____________________', 'БИК: ____________________'],
                        [$orgFullName ?: '[Наименование]', 'Адрес: ' . ($orgLegalAddress ?: '__________________'), 'ИНН/КПП: ' . ($orgInnKpp ?: '________________'), 'Р/с: ' . ($orgBankDetails ?: '____________________'), 'БИК: ' . ($orgBankDetails ?: '____________________')],
                        $executorPart
                    );
                    $clientPart = str_replace(
                        ['[Наименование]', 'Адрес: __________________', 'ИНН/КПП: ________________', 'Р/с: ____________________', 'БИК: ____________________'],
                        [$clientFullName ?: $client?->name ?: '[Наименование]', 'Адрес: ' . ($clientLegalAddress ?: '__________________'), 'ИНН/КПП: ' . ($clientInnKpp ?: '________________'), 'Р/с: ' . ($clientBankDetails ?: '____________________'), 'БИК: ' . ($clientBankDetails ?: '____________________')],
                        $clientPart
                    );
                    $sigBlock = $executorPart . $clientPart;
                } else {
                    $sigBlock = str_replace(
                        ['[Наименование]', 'Адрес: __________________', 'ИНН/КПП: ________________', 'Р/с: ____________________', 'БИК: ____________________'],
                        [$orgFullName ?: $clientFullName ?: '[Наименование]', 'Адрес: ' . ($orgLegalAddress ?: $clientLegalAddress ?: '__________________'), 'ИНН/КПП: ' . ($orgInnKpp ?: $clientInnKpp ?: '________________'), 'Р/с: ' . ($orgBankDetails ?: $clientBankDetails ?: '____________________'), 'БИК: ' . ($orgBankDetails ?: $clientBankDetails ?: '____________________')],
                        $sigBlock
                    );
                }
            @endphp
            {!! $sigBlock !!}
        </div>
    @endif
@else
    <div class="section">
        <p><strong>Договор №</strong> {{ $contract->contract_number }}</p>
        <p><strong>Название:</strong> {{ $contract->title }}</p>
        <p><strong>Клиент:</strong> {{ $client?->name ?? '-' }}</p>
        <p><strong>Сумма:</strong> {{ number_format((float) $contract->amount, 2, ',', ' ') }} руб.</p>
        <p><strong>Период:</strong> {{ $contract->start_date?->format('d.m.Y') }} — {{ $contract->end_date?->format('d.m.Y') }}</p>
        @if($contract->description)
            <p><strong>Описание:</strong> {{ $contract->description }}</p>
        @endif
    </div>
@endif
</body>
</html>
