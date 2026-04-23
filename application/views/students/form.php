<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-8">
<div class="card">
    <div class="card-header"><h4><?= $title ?></h4></div>
    <div class="card-body">
        <?= form_open(isset($student) ? 'students/edit/' . $student->id : 'students/create') ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= isset($student) ? $student->name : set_value('name') ?>">
                    <span class="help-block"><?= form_error('name') ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?= form_error('class_id') ? 'has-error' : '' ?>">
                    <label>Class</label>
                    <select name="class_id" class="form-control">
                        <option value="">-- Select Class --</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class->id ?>"
                                <?= (isset($student) && $student->class_id == $class->id)
                                    || set_value('class_id') == $class->id ? 'selected' : '' ?>>
                                <?= $class->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="help-block"><?= form_error('class_id') ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group <?= form_error('gender') ? 'has-error' : '' ?>">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">-- Select Gender --</option>
                        <option value="male"   <?= (isset($student) && $student->gender == 'male')   || set_value('gender') == 'male'   ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= (isset($student) && $student->gender == 'female') || set_value('gender') == 'female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <span class="help-block"><?= form_error('gender') ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group <?= form_error('birth_date') ? 'has-error' : '' ?>">
                    <label>Birth Date</label>
                    <input type="date" name="birth_date" class="form-control"
                           value="<?= isset($student) ? $student->birth_date : set_value('birth_date') ?>">
                    <span class="help-block"><?= form_error('birth_date') ?></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3"
                      placeholder="Optional"><?= isset($student) ? $student->address : set_value('address') ?></textarea>
        </div>

        <button type="submit" class="btn btn-add">
            <i class="fa fa-save"></i> Save Student
        </button>
        <a href="<?= site_url('students') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>