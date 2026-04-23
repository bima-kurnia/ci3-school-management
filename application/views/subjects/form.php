<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-6">
<div class="card">
    <div class="card-header"><h4><?= $title ?></h4></div>
    <div class="card-body">
        <?= form_open(isset($subject) ? 'subjects/edit/' . $subject->id : 'subjects/create') ?>

            <div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
                <label>Subject Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="e.g. Mathematics"
                       value="<?= isset($subject) ? $subject->name : set_value('name') ?>">
                <span class="help-block"><?= form_error('name') ?></span>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="<?= site_url('subjects') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>