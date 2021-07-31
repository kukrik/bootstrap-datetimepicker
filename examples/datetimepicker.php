<?php
require('qcubed.inc.php');

use QCubed as Q;
use QCubed\Bootstrap as Bs;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase as Form;
use QCubed\Action\ActionParams;
use QCubed\Action\Ajax;
use QCubed\Event\Change;
use QCubed\Project\Application;

class ExamplesForm extends Form
{
    protected $datetimepicker1;
    protected $datetimepicker2;
    protected $datetimepicker3;
    protected $yearpicker;

    protected $label1;
    protected $label2;
    protected $label3;
    protected $label4;

    protected function formCreate()
    {
        $this->datetimepicker1 = new Q\Plugin\DateTimePicker($this);
        //$this->datetimepicker1->Language = 'ee';
        //$this->datetimepicker1->WeekStart = 1;
        $this->datetimepicker1->TodayHighlight = true;
        $this->datetimepicker1->TodayBtn = true;
        $this->datetimepicker1->ClearBtn = true;
        $this->datetimepicker1->AutoClose = true;
        $this->datetimepicker1->StartView = 2;
        $this->datetimepicker1->ForceParse = false;
        $this->datetimepicker1->ShowMeridian = true;
        $this->datetimepicker1->Format = 'dd MM yyyy - HH:ii P';
        $this->datetimepicker1->DateTimePickerType = Q\Plugin\DateTimePickerBase::DEFAULT_OUTPUT_DATETIME;
        $this->datetimepicker1->ActionParameter = $this->datetimepicker1->ControlId;
        $this->datetimepicker1->addAction(new Change(), new Ajax('setDate_1'));

        $this->label1 = new Bs\Label($this);
        $this->label1->setCssStyle('display', 'inline;');

        $this->datetimepicker2 = new Q\Plugin\DateTimePicker($this);
        //$this->datetimepicker2->Language = 'ee';
        //$this->datetimepicker2->WeekStart = 1;
        $this->datetimepicker2->TodayHighlight = true;
        $this->datetimepicker2->TodayBtn = true;
        $this->datetimepicker2->ClearBtn = true;
        $this->datetimepicker2->AutoClose = true;
        $this->datetimepicker2->StartView = 2;
        $this->datetimepicker2->MinView = 2;
        $this->datetimepicker2->ForceParse = false;
        $this->datetimepicker2->Format = 'dd.mm.yyyy';
        $this->datetimepicker2->DateTimePickerType = Q\Plugin\DateTimePickerBase::DEFAULT_OUTPUT_DATE;
        $this->datetimepicker2->ActionParameter = $this->datetimepicker2->ControlId;
        $this->datetimepicker2->addAction(new Change(), new Ajax('setDate_2'));

        $this->label2 = new Bs\Label($this);
        $this->label2->setCssStyle('display', 'inline;');

        $this->datetimepicker3 = new Q\Plugin\DateTimePicker($this);

        $this->datetimepicker3->Language = 'de';
        //$this->datetimepicker3->WeekStart = 1;
        $this->datetimepicker3->TodayBtn = true;
        $this->datetimepicker3->ClearBtn = true;
        $this->datetimepicker3->AutoClose = true;
        $this->datetimepicker3->StartView = 1;
        $this->datetimepicker3->MinView = 0;
        $this->datetimepicker3->MaxView = 4;
        $this->datetimepicker3->ForceParse = false;
        $this->datetimepicker3->Format = 'hh:ii:ss'; //'hh:ii';
        $this->datetimepicker3->DateTimePickerType = Q\Plugin\DateTimePickerBase::DEFAULT_OUTPUT_TIME;
        $this->datetimepicker3->ActionParameter = $this->datetimepicker3->ControlId;
        $this->datetimepicker3->addAction(new Change(), new Ajax('setDate_3'));


        $this->label3 = new Bs\Label($this);
        $this->label3->setCssStyle('display', 'inline;');

        $this->yearpicker = new Q\Plugin\YearPicker($this);
        $this->yearpicker->Language = 'de';
        $this->yearpicker->TodayBtn = true;
        $this->yearpicker->ClearBtn = true;
        $this->yearpicker->AutoClose = true;
        $this->yearpicker->ActionParameter = $this->yearpicker->ControlId;
        $this->yearpicker->addAction(new Change(), new Ajax('setYear'));
        //$this->yearpicker->Text = 2049;

        $this->label4 = new Bs\Label($this);
        $this->label4->setCssStyle('display', 'inline;');
    }

    protected function setDate_1(ActionParams $params)
    {
        $objControlToLookup = $this->getControl($params->ActionParameter);
        $this->label1->Text = $objControlToLookup->DateTime;
    }

    protected function setDate_2(ActionParams $params)
    {
        $objControlToLookup = $this->getControl($params->ActionParameter);
        $this->label2->Text = $objControlToLookup->DateTime;
    }

    protected function setDate_3(ActionParams $params)
    {
        $objControlToLookup = $this->getControl($params->ActionParameter);
        $this->label3->Text = $objControlToLookup->DateTime;
    }

    protected function setYear(ActionParams $params)
    {
        $objControlToLookup = $this->getControl($params->ActionParameter);
        $this->label4->Text = $objControlToLookup->Text;
    }

}
ExamplesForm::Run('ExamplesForm');
