<?php require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <style >
        body {font-size: medium;}
        p, footer {font-size: medium;}
    </style>

<?php $this->RenderBegin(); ?>

    <div class="instructions">
        <h1 class="instruction_title">Bootstrap DateTimePicker some usage examples</h1>
        <p>The DateTimePicker plugin allows to you use the DateTime Picker, which is a Bootstrap
            form component to handle date, time and year data, on your forms.</p>

        <p>Home page for the lib is <a href="https://github.com/smalot/bootstrap-datetimepicker">https://github.com/smalot/bootstrap-datetimepicker</a>
            and demo is at <a href="https://www.malot.fr/bootstrap-datetimepicker">https://www.malot.fr/bootstrap-datetimepicker</a>,
            where you can see example of use.</p>
    </div>

    <div class="form-horizontal" style="padding-top: 25px;">

        <div class="form-group">
            <label class="col-sm-3 control-label">DateTime Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker1); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output to database in the correct format: <?= _r($this->label1); ?></p>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Date Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker2); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output to database in the correct format: <?= _r($this->label2); ?></p>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Time Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker3); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output to database in the correct format: <?= _r($this->label3); ?></p>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Year Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker4); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output to database in the correct format: <?= _r($this->label4); ?></p>
        </div>

    </div>

<?php $this->RenderEnd(); ?>

<?php require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>