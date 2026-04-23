<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-7">
<div class="card">
    <div class="card-header"><h4><?= $title ?></h4></div>
    <div class="card-body">
        <?= form_open(isset($assignment)
            ? 'class_subjects/edit/' . $assignment->id
            : 'class_subjects/create') ?>

            <div class="form-group <?= form_error('class_id') ? 'has-error' : '' ?>">
                <label>Class</label>
                <select name="class_id" class="form-control">
                    <option value="">-- Select Class --</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class->id ?>"
                            <?= (isset($assignment) && $assignment->class_id == $class->id)
                                || set_value('class_id') == $class->id ? 'selected' : '' ?>>
                            <?= $class->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block"><?= form_error('class_id') ?></span>
            </div>

            <div class="form-group <?= form_error('subject_id') ? 'has-error' : '' ?>">
                <label>Subject</label>
                <select name="subject_id" class="form-control">
                    <option value="">-- Select Subject --</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject->id ?>"
                            <?= (isset($assignment) && $assignment->subject_id == $subject->id)
                                || set_value('subject_id') == $subject->id ? 'selected' : '' ?>>
                            <?= $subject->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block"><?= form_error('subject_id') ?></span>
            </div>

            <div class="form-group <?= form_error('teacher_id') ? 'has-error' : '' ?>">
                <label>Teacher</label>
                <select name="teacher_id" class="form-control">
                    <option value="">-- Select Teacher --</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?= $teacher->id ?>"
                            <?= (isset($assignment) && $assignment->teacher_id == $teacher->id)
                                || set_value('teacher_id') == $teacher->id ? 'selected' : '' ?>>
                            <?= $teacher->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block"><?= form_error('teacher_id') ?></span>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-save"></i> Save Assignment
            </button>
            <a href="<?= site_url('class_subjects') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>