<?php
require('qcubed.inc.php');

use QCubed as Q;
use QCubed\Bootstrap as Bs;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase as Form;

class ExamplesForm extends Form
{


    protected function formCreate()
    {

    }
}
ExamplesForm::Run('ExamplesForm');
