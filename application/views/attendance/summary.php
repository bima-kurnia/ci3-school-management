<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Filter Form -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h4><i class="fa fa-filter"></i> Filter Summary</h4>
    </div>
    <div class="card-body">
        <?= form_open('attendance/summary', ['method' => 'get']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Class</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">-- Select Class --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c->id ?>"
                                <?= ($class && $class->id == $c->id) ? 'selected' : '' ?>>
                                <?= $c->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>From</label>
                    <input type="date" name="from" class="form-control"
                           value="<?= $from ?? date('Y-m-01') ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>To</label>
                    <input type="date" name="to" class="form-control"
                           value="<?= $to ?? date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-add btn-block">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<!-- Results -->
<?php if (!empty($summary)): ?>
<div class="card">
    <div class="card-header">
        <h4>
            <i class="fa fa-bar-chart"></i>
            Summary — <?= $class->name ?>
            <small class="text-muted">
                (<?= date('d M Y', strtotime($from)) ?>
                to <?= date('d M Y', strtotime($to)) ?>)
            </small>
        </h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th class="text-center" style="color:#2ecc71">Present</th>
                    <th class="text-center" style="color:#e74c3c">Absent</th>
                    <th class="text-center" style="color:#f39c12">Late</th>
                    <th class="text-center" style="color:#3498db">Excused</th>
                    <th class="text-center">Total Days</th>
                    <th class="text-center">Attendance %</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $i => $row): ?>
                <?php
                    $percentage = $row->total_days > 0
                        ? round(($row->total_present / $row->total_days) * 100, 1)
                        : 0;
                    $bar_class = $percentage >= 75 ? 'success'
                               : ($percentage >= 50 ? 'warning' : 'danger');
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= $row->student_name ?></strong></td>
                    <td class="text-center">
                        <span class="label label-success"><?= $row->total_present ?></span>
                    </td>
                    <td class="text-center">
                        <span class="label label-danger"><?= $row->total_absent ?></span>
                    </td>
                    <td class="text-center">
                        <span class="label label-warning"><?= $row->total_late ?></span>
                    </td>
                    <td class="text-center">
                        <span class="label label-info"><?= $row->total_excused ?></span>
                    </td>
                    <td class="text-center"><?= $row->total_days ?></td>
                    <td class="text-center">
                        <div class="progress" style="margin-bottom:0; height:18px;">
                            <div class="progress-bar progress-bar-<?= $bar_class ?>"
                                 style="width:<?= $percentage ?>%; line-height:18px; font-size:12px;">
                                <?= $percentage ?>%
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php elseif ($class): ?>
    <div class="alert alert-warning" role="alert">
        <i class="fa fa-warning"></i> No attendance records found for this filter.
    </div>
<?php endif; ?>

<?php $this->load->view('layouts/footer'); ?>