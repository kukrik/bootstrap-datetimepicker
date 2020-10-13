<?php

/**
 * The DateTimePicker override file. This file gets installed into project/includes/plugins duing the initial installation
 * of the plugin. After that, it is not touched. Feel free to modify this file as needed.
 */

namespace QCubed\Plugin;


class DateTimePicker extends DateTimePickerBase
{
    public function  __construct($objParentObject, $strControlId = null) {
    parent::__construct($objParentObject, $strControlId);
    $this->registerFiles();
    $this->LinkField = $this->ControlId . '_mirror';
}

    protected function registerFiles() {
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/bootstrap-datetimepicker.js");
        $this->addCssFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/css/bootstrap-datetimepicker.css");
        $this->AddCssFile(QCUBED_BOOTSTRAP_CSS); // make sure they know
        $this->AddCssFile(QCUBED_FONT_AWESOME_CSS); // make sure they know

        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/locales/bootstrap-datetimepicker.ee.js");
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/locales/bootstrap-datetimepicker.de.js");
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/locales/bootstrap-datetimepicker.fr.js");
    }
}
