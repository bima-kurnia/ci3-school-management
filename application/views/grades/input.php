<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4>
            <i class="fa fa-pencil-square-o"></i>
            Grades —
            <span style="color:#e94560"><?= $class->name ?></span>
            · <span style="color:#3498db"><?= $subject->name ?></span>
            · <small class="text-muted">Semester <?= $semester ?></small>
        </h4>
        <a href="<?= site_url('grades') ?>" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <?= form_open('grades/save') ?>
        <input type="hidden" name="class_id"   value="<?= $class->id ?>">
        <input type="hidden" name="subject_id" value="<?= $subject->id ?>">
        <input type="hidden" name="semester"   value="<?= $semester ?>">

        <table class="table table-bordered table-hover">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th width="50">#</th>
                    <th>Student Name</th>
                    <th width="200">Score <small>(0 – 100)</small></th>
                    <th width="120">Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $i => $student): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= $student->student_name ?></strong></td>
                    <td>
                        <input type="number"
                               name="scores[<?= $student->student_id ?>]"
                               class="form-control score-input"
                               min="0" max="100" step="0.01"
                               value="<?= $student->score ?? '' ?>"
                               placeholder="Enter score">
                    </td>
                    <td class="grade-label text-center">
                        <?php if ($student->score !== null): ?>
                            <?= get_instance()->_get_grade_label($student->score) ?>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-add">
            <i class="fa fa-save"></i> Save Grades
        </button>
        <?= form_close() ?>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>