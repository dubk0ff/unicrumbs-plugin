<?php namespace Dubk0ff\UniCrumbs\Models;

use Dubk0ff\UniCrumbs\Classes\Helpers\StubHelper;
use Model;
use October\Rain\Database\Traits\Validation;
use October\Rain\Element\ElementHolder;

class Template extends Model
{
    use Validation;

    public $table = 'dubk0ff_unicrumbs_templates';

    public $rules = [
        'title' => 'required',
        'code'  => 'required'
    ];

    protected $casts = [
        'is_active' => 'bool'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function filterFields(ElementHolder $fields, string $context = null): void
    {
        if ($context === 'create') {
            $fields->code->value = StubHelper::getStub('template');
        }
    }
}
