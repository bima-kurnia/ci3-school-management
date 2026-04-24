<?php $this->load->view('layouts/header', ['title' => $title, 'icon' => $icon]); ?>

<div class="row">
<div class="col-md-7">
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-pencil-square-o"></i> Input Grades</h4>
    </div>
    <div class="card-body">
        <?= form_open('grades/input', ['method' => 'get']) ?>

            <div class="form-group">
                <label>Class</label>
                <select name="class_id" id="class_id" class="form-control" required>
                    <option value="">-- Select Class --</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class->id ?>"><?= $class->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Subject</label>
                <select name="subject_id" id="subject_id" class="form-control" required>
                    <option value="">-- Select Class First --</option>
                </select>
            </div>

            <div class="form-group">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="">-- Select Semester --</option>
                    <?php foreach ($semesters as $sem): ?>
                        <option value="<?= $sem ?>"><?= $sem ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-add">
                <i class="fa fa-arrow-right"></i> Proceed
            </button>

        <?= form_close() ?>
    </div>
</div>
</div>

<div class="col-md-5">
<div class="card">
    <div class="card-header">
        <h4><i class="fa fa-bar-chart"></i> Grade Summary</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">View average scores and rankings per class.</p>
        <a href="<?= site_url('grades/summary') ?>" class="btn btn-add">
            <i class="fa fa-bar-chart"></i> View Summary
        </a>
    </div>
</div>
</div>
</div>

<?php $this->load->view('layouts/partials/footer_libraries'); ?>

<script>
    // Reset input on page load
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || (typeof window.performance != 'undefined' && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });

    // Dynamically load subjects when class changes.
    $('#class_id').on('change', function() {
        var class_id = $(this).val();
        var $subject = $('#subject_id');

        $subject.html('<option value="">Loading...</option>');

        if (!class_id) {
            $subject.html('<option value="">-- Select Class First --</option>');
            return;
        }

        $.getJSON('<?= site_url("grades/get_subjects") ?>/' + class_id, function(data) {
            var options = '<option value="">-- Select Subject --</option>';
            if (data.length === 0) {
                options = '<option value="">No subjects assigned</option>';
            }
            $.each(data, function(i, subject) {
                options += '<option value="' + subject.id + '">' + subject.name + '</option>';
            });
            $subject.html(options);
        });
    });
</script>

<?php $this->load->view('layouts/partials/footer_scripts'); ?>