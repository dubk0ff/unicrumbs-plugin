<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('dubk0ff/unicrumbs/crumbs') ?>"><?= e(trans('dubk0ff.unicrumbs::controllers.crumbs.breadcrumb')) ?></a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?php if (array_get($this->vars, 'formModel')->trashed()): ?>
        <?= $this->makePartial('hint_trashed') ?>
    <?php endif; ?>

    <div class="scoreboard">
        <div data-control="toolbar">
            <?= $this->makePartial('preview_scoreboard') ?>
        </div>
    </div>

    <div class="form-buttons">
        <div class="loading-indicator-container">
            <?= $this->makePartial('preview_toolbar') ?>
        </div>
    </div>

    <div class="layout-row">
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('dubk0ff/unicrumbs/crumbs') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')) ?></a></p>

<?php endif ?>
