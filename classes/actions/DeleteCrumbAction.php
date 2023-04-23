<?php namespace Dubk0ff\UniCrumbs\Classes\Actions;

use Dubk0ff\UniCrumbs\Models\Crumb;
use Flash;

final class DeleteCrumbAction
{
    public function run(int $id): void
    {
        Crumb::query()->whereId($id)->firstOrFail()->delete();

        Flash::success(trans('dubk0ff.unicrumbs::messages.crumb_delete_success'));
    }
}
