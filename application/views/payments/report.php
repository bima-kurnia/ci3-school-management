<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<!-- Filter -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h4><i class="fa fa-filter"></i> Filter by Month</h4>
    </div>
    <div class="card-body">
        <?= form_open('payments/report', ['method' => 'get']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Month</label>
                    <select name="month" class="form-control">
                        <?php foreach ($months as $num => $name): ?>
                            <option value="<?= $num ?>"
                                <?= $month == $num ? 'selected' : '' ?>>
                                <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Year</label>
                    <select name="year" class="form-control">
                        <?php foreach ($years as $y): ?>
                            <option value="<?= $y ?>"
                                <?= $year == $y ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-add btn-block">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button onclick="window.print()"
                            type="button"
                            class="btn btn-default btn-block">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<div class="row">

    <!-- Monthly Payments Table -->
    <div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="fa fa-list"></i>
                <?= $months[(int)$month] ?? '' ?> <?= $year ?> Payments
            </h4>
        </div>
        <div class="card-body">
            <?php if (empty($payments)): ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i>
                    No payments found for this period.
                </div>
            <?php else: ?>
            <table class="table table-bordered table-hover datatable">
                <thead style="background:#1a1a2e; color:#fff;">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <a href="<?= site_url('payments/student/' . $p->student_id) ?>">
                                <?= $p->student_name ?>
                            </a>
                            <br><small class="text-muted"><?= $p->class_name ?></small>
                        </td>
                        <td>
                            <span class="label label-info"><?= $p->description ?></span>
                        </td>
                        <td style="color:#27ae60; font-weight:700;">
                            Rp <?= number_format($p->amount, 0, ',', '.') ?>
                        </td>
                        <td><?= date('d M Y', strtotime($p->payment_date)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background:#f8f9fa;">
                        <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                        <td colspan="2">
                            <strong style="color:#27ae60; font-size:15px;">
                                Rp <?= number_format($subtotal, 0, ',', '.') ?>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?>
        </div>
    </div>
    </div>

    <!-- Right Column: Breakdown -->
    <div class="col-md-4">

        <!-- Income by Type -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h4><i class="fa fa-pie-chart"></i> Income by Type</h4>
            </div>
            <div class="card-body" style="padding:10px;">
                <?php if (empty($by_desc)): ?>
                    <p class="text-muted text-center">No data yet.</p>
                <?php else: ?>
                <?php
                    $grand = array_sum(array_column(
                                array_map(fn($r) => (array)$r, $by_desc), 'total'));
                ?>
                <?php foreach ($by_desc as $row): ?>
                <?php $pct = $grand > 0 ? round(($row->total / $grand) * 100) : 0; ?>
                <div style="margin-bottom:12px;">
                    <div style="display:flex;
                                justify-content:space-between;
                                margin-bottom:3px;">
                        <span><?= $row->description ?>
                            <small class="text-muted">(<?= $row->count ?>x)</small>
                        </span>
                        <span style="color:#27ae60; font-weight:600;">
                            <?= $pct ?>%
                        </span>
                    </div>
                    <div class="progress" style="height:10px; margin-bottom:0;">
                        <div class="progress-bar progress-bar-success"
                             style="width:<?= $pct ?>%">
                        </div>
                    </div>
                    <small class="text-muted">
                        Rp <?= number_format($row->total, 0, ',', '.') ?>
                    </small>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Last 12 Months Chart -->
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-bar-chart"></i> Last 12 Months</h4>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="220"></canvas>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
var labels  = <?= json_encode(array_column(
    array_map(fn($r) => (array)$r, $monthly), 'month_label')) ?>;
var amounts = <?= json_encode(array_column(
    array_map(fn($r) => (array)$r, $monthly), 'total')) ?>;

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Income (Rp)',
            data: amounts,
            backgroundColor: '#e94560',
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>

<!-- Print styles -->
<style>
@media print {
    /* Hide UI chrome */
    .sidebar,
    .top-navbar,
    .flash-message,
    .btn,
    form { display: none !important; }

    /* Reset layout — this is the main culprit */
    body { background: #fff !important; }
    .main-wrapper {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .content-area {
        padding: 10px !important;
    }

    /* Fix Bootstrap column collapsing on print */
    .col-md-8,
    .col-md-4,
    .col-md-3,
    .col-md-2 {
        float: none !important;
        width: 100% !important;
        display: block !important;
    }

    /* Hide the right column (chart + breakdown) */
    .col-md-4 { display: none !important; }

    /* Remove shadows */
    .card { box-shadow: none !important; }
}
</style>

<?php $this->load->view('layouts/footer'); ?>