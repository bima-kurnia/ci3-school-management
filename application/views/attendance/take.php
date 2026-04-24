<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="card">
    <div class="card-header">
        <h4>
            <i class="fa fa-calendar-check-o"></i>
            Attendance — <span style="color:#e94560"><?= $class->name ?></span>
            <small class="text-muted"><?= date('l, d F Y', strtotime($date)) ?></small>
        </h4>
        <a href="<?= site_url('attendance') ?>" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">

        <?php if ($is_taken): ?>
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i>
                Attendance already recorded for this class and date.
                You can update it below.
            </div>
        <?php endif; ?>

        <?= form_open('attendance/save') ?>
        <input type="hidden" name="class_id" value="<?= $class->id ?>">
        <input type="hidden" name="date"     value="<?= $date ?>">

        <table class="table table-bordered table-hover">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th width="50">#</th>
                    <th>Student Name</th>
                    <th class="text-center" style="color:#27ae60">Present</th>
                    <th class="text-center" style="color:#e74c3c">Absent</th>
                    <th class="text-center" style="color:#f39c12">Late</th>
                    <th class="text-center" style="color:#3498db">Excused</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $i => $student): ?>
                <?php $status = $student->status ?? 'present'; ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= $student->student_name ?></strong></td>

                    <!-- Present -->
                    <td class="text-center">
                        <input type="radio"
                               name="attendance[<?= $student->student_id ?>]"
                               value="present"
                               <?= $status === 'present' ? 'checked' : '' ?>>
                    </td>
                    <!-- Absent -->
                    <td class="text-center">
                        <input type="radio"
                               name="attendance[<?= $student->student_id ?>]"
                               value="absent"
                               <?= $status === 'absent' ? 'checked' : '' ?>>
                    </td>
                    <!-- Late -->
                    <td class="text-center">
                        <input type="radio"
                               name="attendance[<?= $student->student_id ?>]"
                               value="late"
                               <?= $status === 'late' ? 'checked' : '' ?>>
                    </td>
                    <!-- Excused -->
                    <td class="text-center">
                        <input type="radio"
                               name="attendance[<?= $student->student_id ?>]"
                               value="excused"
                               <?= $status === 'excused' ? 'checked' : '' ?>>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Quick-select all buttons -->
        <div style="margin-bottom:15px;">
            <strong>Mark all as:</strong>&nbsp;
            <button type="button" class="btn btn-xs btn-success mark-all" data-status="present">
                <i class="fa fa-check"></i> Present
            </button>
            <button type="button" class="btn btn-xs btn-danger mark-all" data-status="absent">
                <i class="fa fa-times"></i> Absent
            </button>
            <button type="button" class="btn btn-xs btn-warning mark-all" data-status="late">
                <i class="fa fa-clock-o"></i> Late
            </button>
            <button type="button" class="btn btn-xs btn-info mark-all" data-status="excused">
                <i class="fa fa-check-circle"></i> Excused
            </button>
        </div>

        <button type="submit" class="btn btn-add">
            <i class="fa fa-save"></i> Save Attendance
        </button>

        <?= form_close() ?>
    </div>
</div>

<?php $this->load->view('layouts/partials/footer_libraries'); ?>

<script>
    // Mark all students with a single status.
    $('.mark-all').on('click', function() {
        var status = $(this).data('status');
        $('input[type="radio"][value="' + status + '"]').prop('checked', true);
    });
</script>

<?php $this->load->view('layouts/partials/footer_scripts'); ?>