<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-sitemap"></i> Class Subject Assignments</h4>
        <a href="<?= site_url('class_subjects/create') ?>" class="btn btn-add">
            <i class="fa fa-plus"></i> Assign Subject
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $i => $a): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><span class="label label-primary"><?= $a->class_name ?></span></td>
                    <td><?= $a->subject_name ?></td>
                    <td><?= $a->teacher_name ?? '<span class="text-muted">Unassigned</span>' ?></td>
                    <td>
                        <a href="<?= site_url('class_subjects/edit/' . $a->id) ?>"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('class_subjects/delete/' . $a->id) ?>"
                           class="btn btn-xs btn-danger btn-delete">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>