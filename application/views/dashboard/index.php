<?php $this->load->view('layouts/header', ['title' => 'Dashboard', 'icon' => 'dashboard']); ?>

<div class="row">
    <div class="col-md-3">
        <div class="stat-card red">
            <i class="fa fa-users stat-icon"></i>
            <div class="stat-number"><?= $total_students ?></div>
            <div class="stat-label"><i class="fa fa-user-circle"></i> Total Students</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card blue">
            <i class="fa fa-users stat-icon"></i>
            <div class="stat-number"><?= $total_teachers ?></div>
            <div class="stat-label"><i class="fa fa-user"></i> Total Teachers</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <i class="fa fa-building stat-icon"></i>
            <div class="stat-number"><?= $total_classes ?></div>
            <div class="stat-label"><i class="fa fa-building"></i> Total Classes</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <i class="fa fa-book stat-icon"></i>
            <div class="stat-number"><?= $total_subjects ?></div>
            <div class="stat-label"><i class="fa fa-book"></i> Total Subjects</div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>