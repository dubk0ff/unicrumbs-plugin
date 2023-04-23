<div class="scoreboard-item title-value">
    <h4><?= e(trans('dubk0ff.unicrumbs::models.crumb.id')) ?></h4>
    <p><?= e(array_get($this->vars, 'formModel')->id) ?></p>
</div>

<div class="scoreboard-item title-value">
    <h4><?= e(trans('dubk0ff.unicrumbs::models.crumb.title')) ?></h4>
    <p><?= e(array_get($this->vars, 'formModel')->name) ?></p>
    <p class="description">
        <?= e(trans('dubk0ff.unicrumbs::models.crumb.parent')) ?>:
        <?php if(array_get($this->vars, 'formModel')->parent): ?>
            <a href="<?= Backend::url('dubk0ff/unicrumbs/crumbs/preview/' . array_get($this->vars, 'formModel')->parent_id) ?>">
                <?= e(array_get($this->vars, 'formModel')->parent->name) ?>
            </a>
        <?php else: ?>
            <?= e('') ?>
        <?php endif ?>
    </p>
</div>

<div class="scoreboard-item title-value">
    <h4><?= e(trans('dubk0ff.unicrumbs::models.crumb.type')) ?></h4>
    <p><?= e(array_get($this->vars, 'formModel')->type_info) ?></p>
</div>

<div class="scoreboard-item title-value">
    <h4><?= e(trans('dubk0ff.unicrumbs::models.updated_at')) ?></h4>
    <p><?= e(array_get($this->vars, 'formModel')->updated_at) ?></p>
    <p class="description">
        <?= e(trans('dubk0ff.unicrumbs::models.created_at')) ?>:
        <?= e(array_get($this->vars, 'formModel')->created_at) ?>
    </p>
</div>
