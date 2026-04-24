<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-7">
<div class="card">
    <div class="card-header"><h4><?= $title ?></h4></div>
    <div class="card-body">
        <?= form_open(isset($payment)
            ? 'payments/edit/' . $payment->id
            : 'payments/create') ?>

            <div class="form-group <?= form_error('student_id') ? 'has-error' : '' ?>">
                <label>Student</label>
                <select name="student_id" class="form-control" required>
                    <option value="">-- Select Student --</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s->id ?>"
                            <?= (isset($payment) && $payment->student_id == $s->id)
                                || set_value('student_id') == $s->id ? 'selected' : '' ?>>
                            <?= $s->name ?>
                            <?= $s->class_name ? "({$s->class_name})" : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block"><?= form_error('student_id') ?></span>
            </div>

            <div class="form-group <?= form_error('description') ? 'has-error' : '' ?>">
                <label>Payment Type / Description</label>
                <select name="description" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <?php
                    $types = [
                        'Monthly Fee', 'Registration Fee',
                        'Exam Fee', 'Uniform Fee',
                        'Book Fee', 'Other'
                    ];
                    foreach ($types as $type):
                        $selected = (isset($payment) && $payment->description === $type)
                                 || set_value('description') === $type
                                 ? 'selected' : '';
                    ?>
                        <option value="<?= $type ?>" <?= $selected ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block"><?= form_error('description') ?></span>
            </div>

            <div class="form-group <?= form_error('amount') ? 'has-error' : '' ?>">
                <label>Amount (Rp)</label>
                <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="number"
                           name="amount"
                           class="form-control"
                           min="0"
                           step="1000"
                           placeholder="e.g. 500000"
                           value="<?= isset($payment)
                               ? $payment->amount
                               : set_value('amount') ?>">
                </div>
                <span class="help-block"><?= form_error('amount') ?></span>
            </div>

            <div class="form-group <?= form_error('payment_date') ? 'has-error' : '' ?>">
                <label>Payment Date</label>
                <input type="date"
                       name="payment_date"
                       class="form-control"
                       value="<?= isset($payment)
                           ? $payment->payment_date
                           : set_value('payment_date', date('Y-m-d')) ?>">
                <span class="help-block"><?= form_error('payment_date') ?></span>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-save"></i> Save Payment
            </button>
            <a href="<?= site_url('payments') ?>" class="btn btn-default">Cancel</a>

        <?= form_close() ?>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>