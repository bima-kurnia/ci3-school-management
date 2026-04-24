<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Semester switcher -->
<div class="card" id="semesters" style="margin-bottom:20px;">
    <div class="card-body">
        <strong>Semester:</strong>&nbsp;
        <?php foreach ($semesters as $sem): ?>
            <a href="<?= site_url("grades/report_card/{$student->id}?semester={$sem}") ?>"
               class="btn btn-sm <?= $semester === $sem ? 'btn-add' : 'btn-default' ?>">
                <?= $sem ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="card">
    <div class="card-header" style="background:#1a1a2e; color:#fff; border-radius:8px 8px 0 0;">
        <div class="row">
            <div class="col-md-8">
                <h3 style="margin:0;">
                    <i class="fa fa-file-text"></i> Report Card
                </h3>
                <p style="margin:5px 0 0; opacity:.7;">Semester <?= $semester ?></p>
            </div>
            <div class="col-md-4 text-right" style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                <button onclick="window.print()" class="btn btn-sm btn-light" style="font-weight: 600;">
                    <i class="fa fa-print"></i> Print
                </button>
                <a href="<?= site_url('grades/summary') ?>" class="btn btn-sm btn-danger" style="font-weight: 600;">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <!-- Student Info -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-6">
                <table class="table table-condensed" style="background:transparent;">
                    <tr>
                        <td width="130"><strong>Student Name</strong></td>
                        <td>: <?= $student->name ?></td>
                    </tr>
                    <tr>
                        <td><strong>Class</strong></td>
                        <td>: <?= $student->class_name ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Semester</strong></td>
                        <td>: <?= $semester ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 text-right">
                <?php if ($average !== null): ?>
                <div style="display:inline-block; background:#f8f9fa;
                            border-radius:8px; padding:15px 30px; text-align:center;">
                    <div style="font-size:48px; font-weight:700; color:#1a1a2e;
                                line-height:1;">
                        <?= $average ?>
                    </div>
                    <div style="margin-top:5px;">
                        <?= get_instance()->get_grade_label($average) ?>
                    </div>
                    <div style="color:#6c757d; font-size:12px; margin-top:5px;">
                        Overall Average
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grades Table -->
        <?php if (empty($grades)): ?>
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i>
                No grades recorded for this semester yet.
            </div>
        <?php else: ?>
        <table class="table table-bordered">
            <thead style="background:#1a1a2e; color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th class="text-center" width="150">Score</th>
                    <th class="text-center" width="100">Grade</th>
                    <th class="text-center" width="150">Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $i => $grade): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $grade->subject_name ?></td>
                    <td class="text-center">
                        <strong><?= $grade->score ?></strong>
                        <!-- Score bar -->
                        <div class="progress" style="height:6px; margin:5px 0 0;">
                            <div class="progress-bar
                                <?= $grade->score >= 70
                                    ? 'progress-bar-success'
                                    : 'progress-bar-danger' ?>"
                                 style="width:<?= $grade->score ?>%">
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <?= get_instance()->get_grade_label($grade->score) ?>
                    </td>
                    <td class="text-center">
                        <?php
                            if      ($grade->score >= 90) echo '<span class="text-success">Excellent</span>';
                            else if ($grade->score >= 80) echo '<span class="text-info">Very Good</span>';
                            else if ($grade->score >= 70) echo '<span class="text-primary">Good</span>';
                            else if ($grade->score >= 60) echo '<span class="text-warning">Satisfactory</span>';
                            else                          echo '<span class="text-danger">Need Improvement</span>';
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="2" class="text-right"><strong>Overall Average</strong></td>
                    <td class="text-center"><strong><?= $average ?></strong></td>
                    <td class="text-center"><?= get_instance()->get_grade_label($average) ?></td>
                    <td class="text-center">
                        <?php
                            if      ($average >= 90) echo '<strong class="text-success">Excellent</strong>';
                            else if ($average >= 80) echo '<strong class="text-info">Very Good</strong>';
                            else if ($average >= 70) echo '<strong class="text-primary">Good</strong>';
                            else if ($average >= 60) echo '<strong class="text-warning">Satisfactory</strong>';
                            else                     echo '<strong class="text-danger">Need Improvement</strong>';
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>
    </div>
</div>

<!-- Print styles -->
<style>
/* 1. Atur baris header agar judul dan tombol saling menjauh */
.card-header .row {
    display: flex !important;
    justify-content: space-between !important; /* Mendorong kiri dan kanan ke ujung */
    align-items: center !important;
    width: 100%;
}

/* 2. Pastikan kolom judul tetap di kiri */
.card-header .col-md-8 {
    flex: 1;
}

/* 3. Pastikan kolom tombol tetap di kanan dan rapi */
.card-header .col-md-4.text-right {
    display: flex !important;
    justify-content: flex-end !important; /* Tombol menempel ke ujung kanan */
    align-items: center !important;
    gap: 10px !important; /* Jarak antar tombol */
    flex: 0 0 auto; /* Mencegah kolom tombol melebar tak tentu */
}

/* Style tombol agar muncul, rapi, dan tidak mepet */
.card-header .btn {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 8px !important; /* Memberi jarak antara ICON dan TULISAN */   
    visibility: visible !important;
    opacity: 1 !important;
    color: #333 !important;
    background-color: #fff !important;
    padding: 8px 16px !important; /* Padding lebih lega: atas-bawah 8px, kiri-kanan 16px */
    border-radius: 5px !important;
    white-space: nowrap;
    text-decoration: none !important;
    font-weight: 500;
}

.btn:hover {
    filter: brightness(90%);
    transform: translateY(-1px);
}


@media print {
    .sidebar, .top-navbar, .btn, .card-header .btn, #semesters { display: none !important; }
    .main-wrapper { margin-left: 0 !important; }
    .card { box-shadow: none !important; }
}
</style>

<?php $this->load->view('layouts/footer'); ?>