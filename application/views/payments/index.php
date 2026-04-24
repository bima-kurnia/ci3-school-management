<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Stat Cards -->
<div class="row" style="margin-bottom:20px;">
    <div class="col-md-4">
        <div class="stat-card green">
            <i class="fa fa-money stat-icon"></i>
            <div class="stat-number">
                Rp <?= number_format($total_income, 0, ',', '.') ?>
            </div>
            <div class="stat-label">
                <i class="fa fa-money"></i> Total Income (All Time)
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card blue">
            <i class="fa fa-calendar stat-icon"></i>
            <div class="stat-number">
                Rp <?= number_format($this_month, 0, ',', '.') ?>
            </div>
            <div class="stat-label">
                <i class="fa fa-calendar"></i> Income This Month
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <i class="fa fa-list stat-icon"></i>
            <div class="stat-number"><?= $total_count ?></div>
            <div class="stat-label">
                <i class="fa fa-list"></i> Total Transactions
            </div>
        </div>
    </div>
</div>

<!-- Payment Table -->
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-money"></i> Payment Records</h4>
        <div>
            <a href="<?= site_url('payments/report') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-file-text"></i> Monthly Report
            </a>
            <a href="<?= site_url('payments/create') ?>" class="btn btn-add btn-sm">
                <i class="fa fa-plus"></i> Add Payment
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <a href="<?= site_url('payments/student/' . $p->student_id) ?>">
                            <strong><?= $p->student_name ?></strong>
                        </a>
                    </td>
                    <td><?= $p->class_name ?? '-' ?></td>
                    <td>
                        <span class="label label-info"><?= $p->description ?></span>
                    </td>
                    <td>
                        <strong style="color:#27ae60;">
                            Rp <?= number_format($p->amount, 0, ',', '.') ?>
                        </strong>
                    </td>
                    <td><?= date('d M Y', strtotime($p->payment_date)) ?></td>
                    <td>
                        <a href="<?= site_url('payments/edit/' . $p->id) ?>"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('payments/delete/' . $p->id) ?>"
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