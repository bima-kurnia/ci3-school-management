<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4>
            <i class="fa fa-sitemap"></i>
            Subjects for Class: <span style="color:#e94560"><?= $class->name ?></span>
        </h4>
        <a href="<?= site_url('class_subjects') ?>" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($assignments)): ?>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                No subjects assigned to this class yet.
                <a href="<?= site_url('class_subjects/create') ?>">Assign one now</a>.
            </div>
        <?php else: ?>
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $i => $a): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $a->subject_name ?></td>
                    <td><?= $a->teacher_name ?? '<span class="text-muted">Unassigned</span>' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>