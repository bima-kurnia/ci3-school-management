<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-building"></i> Class List</h4>
        <a href="<?= site_url('classes/create') ?>" class="btn btn-add">
            <i class="fa fa-plus"></i> Add Class
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Class Name</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $i => $class): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $class->name ?></td>
                    <td>
                        <a href="<?= site_url('classes/edit/' . $class->id) ?>"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('classes/delete/' . $class->id) ?>"
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