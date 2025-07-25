<?php require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <style >
        body {font-size: medium;}
        p, footer {font-size: medium;}
    </style>

<?php $this->RenderBegin(); ?>

    <div class="instructions">
        <h1 class="instruction_title">Bootstrap DateTimePicker some usage examples</h1>
        <p>The DateTimePicker plugin allows you to use the DateTime Picker, which is a Bootstrap
            form component to handle date, time and year data, on your forms.</p>

        <p>The home page for the lib is <a href="https://github.com/smalot/bootstrap-datetimepicker">https://github.com/smalot/bootstrap-datetimepicker</a>
            and demo is at <a href="https://www.malot.fr/bootstrap-datetimepicker">https://www.malot.fr/bootstrap-datetimepicker</a>,
            where you can see an example of use.</p>

        <p>This QDateTime class takes care of converting the data to the correct format. Except for the YearPicker class,
            which converts a year to a numeric value.</p>
    </div>

    <div class="form-horizontal" style="padding-top: 25px;">

        <div class="form-group">
            <label class="col-sm-2 control-label">DateTime Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker1); ?>
            </div>
            <div class="col-sm-7">
                <span>Output the database through the QDateTime class in the datetime format: </span>
                <?= _r($this->label1); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Date Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker2); ?>
            </div>
            <div class="col-sm-7">
                <span>Output the database through the QDateTime class in the date format: </span>
                <?= _r($this->label2); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Time Picking</label>
            <div class="col-sm-3">
                <?= _r($this->datetimepicker3); ?>
            </div>
            <div class="col-sm-7">
                <span>Output the database through the QDateTime class in the time format: </span>
                <?= _r($this->label3); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Year Picking</label>
            <div class="col-sm-3">
                <?= _r($this->yearpicker); ?>
            </div>
            <div class="col-sm-7">
                <span>Output the database through the YearPicker class in the year format: </span>
                <?= _r($this->label4); ?>
            </div>
        </div>

    </div>

<?php $this->RenderEnd(); ?>

<?php require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>