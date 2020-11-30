<?php namespace Dubk0ff\UniCrumbs\Models;

use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Classes\Helpers\BaseHelper;
use Dubk0ff\UniCrumbs\Classes\Managers\CrumbManager;
use Model;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;


/**
 * Dubk0ff\UniCrumbs\Models\Crumb
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $title
 * @property string|null $link
 * @property string|null $segment
 * @property string|null $page
 * @property int|null $parent_id
 * @property int|null $nest_left
 * @property int|null $nest_right
 * @property int|null $nest_depth
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \October\Rain\Database\TreeCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb allChildren($includeSelf = false)
 * @method static \October\Rain\Database\TreeCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb getAllRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb getNested()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb leaves()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb listsNested($column, $key = null, $indent = '&nbsp;&nbsp;&nbsp;')
 * @method static \October\Rain\Database\Builder|Crumb newModelQuery()
 * @method static \October\Rain\Database\Builder|Crumb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb parents($includeSelf = false)
 * @method static \October\Rain\Database\Builder|Crumb query()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb siblings($includeSelf = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereNestDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereNestLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereNestRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereSegment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|Crumb withoutSelf()
 * @mixin \Eloquent
 */
class Crumb extends Model
{
    use NestedTree;
    use SoftDelete;
    use Validation;

    /** @var string */
    public $table = 'dubk0ff_unicrumbs_crumbs';

    /** @var array */
    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel'
    ];

    /** @var array */
    public $translatable = [
        'title'
    ];

    /** @var array */
    protected $guarded = ['*'];

    /** @var array */
    protected $fillable = [
        'name',
        'type',
        'page'
    ];

    /** @var array */
    public $rules = [
        'name'  => 'required',
        'type'  => 'required'
    ];

    /** @var array */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /***** EVENTS *****/

    /**
    * @return void
    */
    public function beforeValidate()
    {
        switch ($this->type) {
            case 'static':
                $this->rules['title'] = 'required';
                $this->rules['link'] = 'required';
                $this->segment = null;
                $this->page = null;
                break;

            case 'static_plus':
                $this->rules['title'] = 'required';
                $this->rules['segment'] = 'required';
                $this->link = null;
                $this->page = null;
                break;

            case 'cms':
                $this->rules['page'] = 'required';
                $this->title = null;
                $this->link = null;
                $this->segment = null;
                break;
        }
    }

    /**
    * @return void
    */
    public function beforeSave()
    {
        BaseHelper::clearCache();

        if ($this->link) {
            $this->link = trim($this->link, '/');
        }

        if ($this->segment) {
            $this->segment = trim($this->segment, '/');
        }
    }

    /**
    * @return void
    */
    public function forceDelete()
    {
        $childrens = $this->newQuery()->withTrashed()->whereParentId($this->id)->get();

        if ($childrens->isNotEmpty()) {
            $childrens->each(function ($item) {
                if ($isTrashed = $item->trashed()) {
                    $item->restore();
                }

                is_null($this->parent_id)
                    ? $item->makeRoot()
                    : $item->makeChildOf($this->parent_id);

                if ($isTrashed) {
                    $item->delete();
                }
            });
        }

        $this->forceDeleting = true;

        $this->delete();

        $this->forceDeleting = false;
    }

    /**
     * @param $fields
     * @param null $context
     */
    public function filterFields($fields, $context = null)
    {
        if (in_array($context, ['create', 'update'])) {
            switch ($fields->{'type'}->value) {
                case 'static':
                    $fields->{'title'}->hidden = false;
                    $fields->{'link'}->hidden = false;
                    $fields->{'segment'}->hidden = true;
                    $fields->{'page'}->hidden = true;
                    break;

                case 'static_plus':
                    $fields->{'title'}->hidden = false;
                    $fields->{'link'}->hidden = true;
                    $fields->{'segment'}->hidden = false;
                    $fields->{'page'}->hidden = true;
                    break;

                case 'cms':
                    $fields->{'title'}->hidden = true;
                    $fields->{'link'}->hidden = true;
                    $fields->{'segment'}->hidden = true;
                    $fields->{'page'}->hidden = false;
                    break;

                default:
                    $fields->{'title'}->hidden = true;
                    $fields->{'link'}->hidden = true;
                    $fields->{'segment'}->hidden = true;
                    $fields->{'page'}->hidden = true;
                    break;
            }
        }

        if ($context === 'preview') {
            if ($this->trashed()) {
                $fields->{'_information'}->hidden = true;
                $fields->{'_code'}->hidden = true;
            } else {
                $fields->{'_code'}->value = (new CrumbManager($this))->getConnectionCode();
            }
        }
    }

    /***** OPTIONS *****/

    /**
     * @return array
     */
    public function getPageOptions()
    {
        return Page::getNameList();
    }

    /**
     * @return array
     */
    public function getTypeOptions()
    {
        return trans('dubk0ff.unicrumbs::plugin.types');
    }
}