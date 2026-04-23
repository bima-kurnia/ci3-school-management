<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-6">
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-calendar"></i> Take Attendance</h4>
    </div>
    <div class="card-body">
        <?= form_open('attendance/take', ['method' => 'get']) ?>

            <div class="form-group">
                <label>Select Class</label>
                <select name="class_id" class="form-control" required>
                    <option value="">-- Select Class --</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class->id ?>"><?= $class->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control"
                       value="<?= date('Y-m-d') ?>" required>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-arrow-right"></i> Proceed
            </button>

        <?= form_close() ?>
    </div>
</div>
</div>

<!-- Quick link to summary -->
<div class="col-md-6">
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-bar-chart"></i> Attendance Summary</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">View attendance summary per student for a date range.</p>
        <a href="<?= site_url('attendance/summary') ?>" class="btn btn-add">
            <i class="fa fa-bar-chart"></i> View Summary
        </a>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/footer'); ?>