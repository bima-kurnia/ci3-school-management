<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-user"></i> Teacher List</h4>
        <a href="<?= site_url('teachers/create') ?>" class="btn btn-add">
            <i class="fa fa-plus"></i> Add Teacher
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $i => $t): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $t->name ?></td>
                    <td><?= ucfirst($t->gender) ?></td>
                    <td><?= $t->phone ?? '-' ?></td>
                    <td>
                        <a href="<?= site_url('teachers/edit/' . $t->id) ?>"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('teachers/delete/' . $t->id) ?>"
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