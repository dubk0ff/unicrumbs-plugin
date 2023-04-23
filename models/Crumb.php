<?php namespace Dubk0ff\UniCrumbs\Models;

use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Classes\Helpers\BreadcrumbsConnectionCodeHelper;
use Model;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\Purgeable;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;
use October\Rain\Element\ElementHolder;

class Crumb extends Model
{
    use NestedTree;
    use SoftDelete;
    use Validation;
    use Purgeable;

    public $implement = ['@'.\RainLab\Translate\Behaviors\TranslatableModel::class];

    public $translatable = ['title'];

    public $table = 'dubk0ff_unicrumbs_crumbs';

    public $rules = [
        'name' => 'required',
        'title' => 'required',
        'type' => 'required',
        'type_value' => 'required'
    ];

    public array $attributeNames = [
        'type_value' => 'dubk0ff.unicrumbs::models.crumb.type_value'
    ];

    protected $fillable = [
        'name',
        'title',
        'type',
        'type_value',
        '_cms'
    ];

    protected $purgeable = [
        '_cms',
        '_path'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function beforeValidate(): void
    {
        $this->type_value = match ($this->type) {
            'static', 'segment' => $this->_path === '/'
                ? $this->_path
                : trim($this->_path, '/'),
            'cms' => $this->_cms,
            default => ''
        };
    }

    public function filterFields(ElementHolder $fields, string $context = null): void
    {
        if (in_array($context, ['create', 'update', 'refresh'])) {
            switch ($fields->type->value) {
                case 'static':
                case 'segment':
                    $fields->_path->hidden = false;
                    $fields->_path->value = in_array($this->getOriginal('type'), ['static', 'segment'])
                        ? $this->type_value
                        : null;
                    $fields->_cms->hidden = true;
                    break;

                case 'cms':
                    $fields->_path->hidden = true;
                    $fields->_cms->hidden = false;
                    $fields->_cms->value = $this->getOriginal('type') === 'cms'
                        ? $this->type_value
                        : null;
                    break;

                default:
                    $fields->_path->hidden = true;
                    $fields->_cms->hidden = true;
                    break;
            }
        }

        if ($context === 'preview') {
            if ($this->trashed()) {
                $fields->_information->hidden = true;
                $fields->_code->hidden = true;
            } else {
                $fields->_code->value = BreadcrumbsConnectionCodeHelper::renderConnectionCode($this->getParentsAndSelf());
            }
        }
    }

    public function getTypeInfoAttribute(): string
    {
        return trans("dubk0ff.unicrumbs::models.crumb.type_options.$this->type");
    }

    public function getCmsOptions(): array
    {
        return Page::getNameList();
    }

    public function getTypeOptions(): array
    {
        return trans('dubk0ff.unicrumbs::models.crumb.type_options');
    }
}
