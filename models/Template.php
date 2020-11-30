<?php namespace Dubk0ff\UniCrumbs\Models;

use Dubk0ff\UniCrumbs\Classes\Managers\TemplateManager;
use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Validation;

/**
 * Dubk0ff\UniCrumbs\Models\Template
 *
 * @property int $id
 * @property string $title
 * @property bool $is_active
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \October\Rain\Database\Collection|static[] all($columns = ['*'])
 * @method static \October\Rain\Database\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Template isActive()
 * @method static Builder|Template newModelQuery()
 * @method static Builder|Template newQuery()
 * @method static Builder|Template query()
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Template extends Model
{
    use Validation;

    /** @var string */
    public $table = 'dubk0ff_unicrumbs_templates';

    /** @var array */
    protected $guarded = ['*'];

    /** @var array */
    public $rules = [
        'title' => 'required',
        'code'  => 'required'
    ];

    /** @var array */
    protected $casts = [
        'is_active' => 'bool'
    ];

    /** @var array */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /***** EVENTS *****/

    /**
     * @param $fields
     * @param null $context
     */
    public function filterFields($fields, $context = null)
    {
        if ($context === 'create') {
            $fields->{'code'}->value = TemplateManager::getDefaultCode();
        }
    }

    /***** SCOPES *****/

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsActive(Builder $query)
    {
        return $query->whereIsActive(true);
    }
}