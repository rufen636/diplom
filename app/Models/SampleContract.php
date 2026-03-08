<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
 * @mixin \Eloquent
 */
class SampleContract extends Model
{
    use HasFactory;


    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
