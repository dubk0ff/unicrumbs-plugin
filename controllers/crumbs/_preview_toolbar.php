<a
    href="<?= Backend::url('dubk0ff/unicrumbs/crumbs') ?>"
    class="btn btn-default oc-icon-chevron-left">
    <?= e(trans('backend::lang.form.return_to_list')) ?>
</a>
<a
    href="<?= Backend::url('dubk0ff/unicrumbs/crumbs/update/' . array_get($this->vars, 'formModel')->id) ?>"
    class="btn btn-primary oc-icon-pencil">
    <?= e(trans('dubk0ff.unicrumbs::controllers.crumbs.update_data')) ?>
</a>
<?php if (array_get($this->vars, 'formModel')->trashed()): ?>
    <button
        type="button"
        data-request="onRestoreCrumb"
        data-load-indicator="<?= e(trans('backend::lang.form.restoring')) ?>"
        class="btn btn-outline-success oc-icon-heartbeat"
        data-request-confirm="<?= e(trans('backend::lang.form.confirm_restore')) ?>">
        <?= e(trans('backend::lang.form.restore')) ?>
    </button>
<?php else: ?>
    <button
        type="button"
        data-request="onDeleteCrumb"
        data-load-indicator="<?= e(trans('backend::lang.form.deleting')) ?>"
        class="btn btn-outline-danger oc-icon-trash-o"
        data-request-confirm="<?= e(trans('backend::lang.form.confirm_delete')) ?>">
        <?= e(trans('backend::lang.form.delete')) ?>
    </button>
<?php endif ?>
