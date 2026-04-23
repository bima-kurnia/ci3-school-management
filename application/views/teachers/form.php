<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-6">
<div class="card">
    <div class="card-header"><h4><?= $title ?></h4></div>
    <div class="card-body">
        <?= form_open(isset($teacher) ? 'teachers/edit/' . $teacher->id : 'teachers/create') ?>

            <div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?= isset($teacher) ? $teacher->name : set_value('name') ?>">
                <span class="help-block"><?= form_error('name') ?></span>
            </div>

            <div class="form-group <?= form_error('gender') ? 'has-error' : '' ?>">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="male"   <?= (isset($teacher) && $teacher->gender == 'male')   ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= (isset($teacher) && $teacher->gender == 'female') ? 'selected' : '' ?>>Female</option>
                </select>
                <span class="help-block"><?= form_error('gender') ?></span>
            </div>

            <div class="form-group">
                <label>Phone <small class="text-muted">(optional)</small></label>
                <input type="text" name="phone" class="form-control"
                       value="<?= isset($teacher) ? $teacher->phone : set_value('phone') ?>">
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-save"></i> Save Teacher
            </button>
            <a href="<?= site_url('teachers') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>