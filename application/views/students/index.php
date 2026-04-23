<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-user-circle"></i> Student List</h4>
        <a href="<?= site_url('students/create') ?>" class="btn btn-add">
            <i class="fa fa-plus"></i> Add Student
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $i => $s): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $s->name ?></td>
                    <td><?= $s->class_name ?? '<span class="label label-default">No Class</span>' ?></td>
                    <td><?= ucfirst($s->gender) ?></td>
                    <td><?= date('d M Y', strtotime($s->birth_date)) ?></td>
                    <td>
                        <a href="<?= site_url('students/edit/' . $s->id) ?>"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('students/delete/' . $s->id) ?>"
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