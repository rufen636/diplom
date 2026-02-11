<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $billing_number
 * @property float $amount
 * @property int $client_id
 * @property string $status
 * @property string|null $description
 * @property string|null $note
 * @property float|null $tax_amount
 * @property int $tariff_id
 * @property int $accountant_id
 * @property int $contract_id
 * @property string|null $billing_date Дата формирования счета
 * @property string|null $invoice_url
 * @property string|null $due_date Срок оплаты
 * @property string|null $paid_date Дата оплаты
 * @property string|null $period_start Начало расчетного периода
 * @property string|null $period_end Конец расчетного периода
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereAccountantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereBillingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereInvoiceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTariffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUpdatedAt($value)
 */
	class Billing extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $act_number
 * @property string $act_date
 * @property string $act_type
 * @property string $status
 * @property string|null $description
 * @property int $client_id
 * @property int $contract_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereUpdatedAt($value)
 */
	class BuhAct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $request_number
 * @property string $priority Приоритет заявки
 * @property string $status Статус заявки
 * @property string $requested_at Дата и время создания заявки
 * @property string|null $closed_at Дата и время закрытия
 * @property int $client_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereUpdatedAt($value)
 */
	class ClientRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $contract_number
 * @property string $title
 * @property int $client_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property numeric $amount
 * @property string $status
 * @property int $service_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_color
 * @property-read string $status_label
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereContractNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUserId($value)
 */
	class Contract extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property numeric|null $price
 * @property string|null $description
 * @property string|null $mac_address
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereMacAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereUpdatedAt($value)
 */
	class Equipment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereUpdatedAt($value)
 */
	class EquipmentCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $imageable_type
 * @property int $imageable_id
 * @property string|null $small_uri
 * @property string|null $big_uri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereBigUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereSmallUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereUpdatedAt($value)
 */
	class NetworkMap extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $company_name
 * @property string $contact_person
 * @property string $email
 * @property string $phone
 * @property string $type
 * @property string|null $address
 * @property string|null $inn
 * @property string|null $kpp
 * @property string $status
 * @property string|null $notes
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereUserId($value)
 */
	class ProviderClient extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $template_code
 * @property string $name
 * @property string|null $description
 * @property string $contract_type
 * @property string $status
 * @property string $version
 * @property int $is_default
 * @property string|null $preamble
 * @property string|null $subject_of_contract
 * @property string|null $rights_and_obligations
 * @property string|null $payment_terms
 * @property string|null $liability
 * @property string|null $force_majeure
 * @property string|null $dispute_resolution
 * @property string|null $confidentiality
 * @property string|null $other_conditions
 * @property string|null $signatures_block
 * @property string|null $clauses
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereClauses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereConfidentiality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereContractType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereDisputeResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereForceMajeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereLiability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereOtherConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract wherePreamble($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereRightsAndObligations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereSignaturesBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereSubjectOfContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereTemplateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleContract whereVersion($value)
 */
	class SampleContract extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceCategory whereUpdatedAt($value)
 */
	class ServiceCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name Название услуги
 * @property string $code Внутренний код услуги
 * @property string|null $description Описание услуги
 * @property numeric $price Базовая цена
 * @property int $is_active Активна ли услуга
 * @property int $static_ip Статический IP
 * @property int $service_category_id
 * @property int|null $parent_id
 * @property numeric|null $internet_speed Скорость скачивания (Мбит/с)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereInternetSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereStaticIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereUpdatedAt($value)
 */
	class Services extends \Eloquent {}
}

namespace App\Models{
/**
 * @OA\Schema (
 *     schema="Tariff",
 *     title="Тариф",
 *     description="Модель тарифа",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Базовый тариф"),
 *     @OA\Property(property="description", type="string", example="Базовый пакет услуг", nullable=true),
 *     @OA\Property(property="price", type="number", format="float", example=1000.50),
 *     @OA\Property(property="speed", type="integer", example=100),
 *     @OA\Property(property="duration_months", type="integer", example=12),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="sort_order", type="integer", example=1, nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property numeric $price
 * @property int $speed
 * @property int $duration_months
 * @property bool $is_active
 * @property int $sort_order
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereDurationMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereUserId($value)
 */
	class Tariff extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProviderClient> $providerClients
 * @property-read int|null $provider_clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tariff> $tariff
 * @property-read int|null $tariff_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

