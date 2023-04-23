<?php namespace Dubk0ff\UniCrumbs\Classes\Actions;

use Dubk0ff\UniCrumbs\Models\Crumb;
use Flash;

final class RestoreCrumbAction
{
    public function run(int $id): void
    {
        $crumb = Crumb::query()->withTrashed()->whereId($id)->firstOrFail();
        $crumb->_path = $crumb->type_value;
        $crumb->_cms = $crumb->type_value;
        $crumb->restore();

        Flash::success(trans('dubk0ff.unicrumbs::messages.crumb_restore_success'));
    }

}
