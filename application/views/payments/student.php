<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Student Info Banner -->
<div class="card" style="margin-bottom:20px;
     border-left:4px solid #e94560; padding:15px 20px;">
    <div class="row">
        <div class="col-md-8">
            <h4 style="margin:0;">
                <i class="fa fa-user-circle"></i>
                <?= $student->name ?>
            </h4>
            <p style="color:#6c757d; margin:5px 0 0;">
                Class: <strong><?= $student->class_name ?? '-' ?></strong>
            </p>
        </div>
        <div class="col-md-4 text-right">
            <div style="font-size:24px; font-weight:700; color:#27ae60;">
                Rp <?= number_format($total, 0, ',', '.') ?>
            </div>
            <small class="text-muted">Total Paid</small>
        </div>
    </div>
</div>

<!-- Payment History Table -->
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-history"></i> Payment History</h4>
        <div>
            <a href="<?= site_url('payments/create') ?>" class="btn btn-add btn-sm">
                <i class="fa fa-plus"></i> Add Payment
            </a>
            <a href="<?= site_url('payments') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($payments)): ?>
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i>
                No payment records found for this student.
            </div>
        <?php else: ?>
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
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
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="<?= site_url('payments/delete/' . $p->id) ?>"
                           class="btn btn-xs btn-danger btn-delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="2" class="text-right"><strong>Total</strong></td>
                    <td colspan="3">
                        <strong style="color:#27ae60; font-size:16px;">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>