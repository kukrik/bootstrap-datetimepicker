<?php

namespace QCubed\Plugin;

use QCubed as Q;
use QCubed\Bootstrap as Bs;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Project\Application;
use QCubed\Type;

/**
 * Class DateTimePickerBase
 *
 * @package QCubed\Plugin
 */

class DateTimePickerBase extends DateTimePickerBaseGen
{
    /**
     * DateTimePickerBase constructor
     *
     * @param ControlBase|FormBase|null $objParentObject
     * @param null|string $strControlId
     */
    public function __construct($objParentObject, $strControlId = null) {
        parent::__construct($objParentObject, $strControlId);
        $this->registerFiles();
    }

    /**
     * @throws Caller
     */

    protected function registerFiles() {
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/bootstrap-datetimepicker.js");
        $this->addCssFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/css/bootstrap-datetimepicker.css");
        $this->AddCssFile(QCUBED_BOOTSTRAP_CSS); // make sure they know
        //$this->AddCssFile(QCUBED_FONT_AWESOME_CSS); // make sure they know
    }
}

