<div data-control="toolbar">
    <a
        href="<?= Backend::url('dubk0ff/unicrumbs/crumbs/create') ?>"
        class="btn btn-primary oc-icon-plus">
        <?= e(trans('backend::lang.list.create_button', ['name' => trans('dubk0ff.unicrumbs::controllers.crumbs.name_create_button')])) ?>
    </a>

    <button
        class="btn btn-danger oc-icon-trash-o"
        data-request="onDelete"
        data-list-checked-trigger
        data-list-checked-request
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')) ?>
    </button>

    <?php if($this->isShowImportButton()): ?>
        <button
            type="button"
            class="btn btn-outline-info oc-icon-download"
            data-request="onImportPages"
            data-load-indicator="<?= e(trans('dubk0ff.unicrumbs::controllers.crumbs.import_pages_indicator')) ?>"
            data-request-confirm="<?= e(trans('dubk0ff.unicrumbs::controllers.crumbs.import_pages_confirm')) ?>">
            <?= e(trans('dubk0ff.unicrumbs::controllers.crumbs.import_pages')) ?>
        </button>
    <?php endif; ?>
</div>
