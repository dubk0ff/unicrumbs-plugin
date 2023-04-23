<div data-control="toolbar">
    <a
        href="<?= Backend::url('dubk0ff/unicrumbs/templates/create') ?>"
        class="btn btn-primary oc-icon-plus">
        <?= e(trans('backend::lang.list.create_button', ['name' => trans('dubk0ff.unicrumbs::controllers.templates.name_create_button')])) ?>
    </a>

    <button
        class="btn btn-danger oc-icon-trash-o"
        data-request="onDelete"
        data-list-checked-trigger
        data-list-checked-request
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')) ?>
    </button>
</div>
