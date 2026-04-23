<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-6">
<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
    </div>
    <div class="card-body">
        <?= form_open(isset($class) ? 'classes/edit/' . $class->id : 'classes/create') ?>

            <div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
                <label>Class Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="e.g. Grade 10A"
                       value="<?= isset($class) ? $class->name : set_value('name') ?>">
                <?php if (form_error('name')): ?>
                    <span class="help-block"><?= form_error('name') ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="<?= site_url('classes') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>