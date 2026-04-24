<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Filter -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h4><i class="fa fa-filter"></i> Filter</h4>
    </div>
    <div class="card-body">
        <?= form_open('grades/summary', ['method' => 'get']) ?>
        <div class="row">
            <div class="col-md-5">
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
            <div class="col-md-4">
                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="form-control" required>
                        <option value="">-- Select Semester --</option>
                        <?php foreach ($semesters as $sem): ?>
                            <option value="<?= $sem ?>"
                                <?= $semester === $sem ? 'selected' : '' ?>>
                                <?= $sem ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
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
            Grade Summary — <?= $class->name ?>
            <small class="text-muted">Semester <?= $semester ?></small>
        </h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>Rank</th>
                    <th>Student</th>
                    <th class="text-center">Subjects</th>
                    <th class="text-center">Lowest</th>
                    <th class="text-center">Highest</th>
                    <th class="text-center">Average</th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Report Card</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $rank => $row): ?>
                <?php $avg = round($row->average, 2); ?>
                <tr>
                    <td>
                        <?php if ($rank === 0): ?>
                            <span class="label label-warning">
                                <i class="fa fa-trophy"></i> 1st
                            </span>
                        <?php elseif ($rank === 1): ?>
                            <span class="label label-default">2nd</span>
                        <?php elseif ($rank === 2): ?>
                            <span class="label label-default">3rd</span>
                        <?php else: ?>
                            <?= $rank + 1 ?>th
                        <?php endif; ?>
                    </td>
                    <td><strong><?= $row->student_name ?></strong></td>
                    <td class="text-center"><?= $row->total_subjects ?></td>
                    <td class="text-center">
                        <span class="text-danger"><?= $row->lowest ?></span>
                    </td>
                    <td class="text-center">
                        <span class="text-success"><?= $row->highest ?></span>
                    </td>
                    <td class="text-center">
                        <strong><?= $avg ?></strong>
                    </td>
                    <td class="text-center">
                        <?= get_instance()->get_grade_label($avg) ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= site_url("grades/report_card/{$row->student_id}?semester={$semester}") ?>"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-file-text"></i> View
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php elseif ($class): ?>
    <div class="alert alert-warning" role="alert">
        <i class="fa fa-warning"></i> No grades found for this filter.
    </div>
<?php endif; ?>

<?php $this->load->view('layouts/footer'); ?>