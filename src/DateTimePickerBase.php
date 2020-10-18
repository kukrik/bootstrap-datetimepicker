<?php

namespace QCubed\Plugin;

use QCubed as Q;
use QCubed\Bootstrap as Bs;
use QCubed\Exception\Caller;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Project\Application;
use QCubed\QDateTime;

/**
 * Class DateTimePickerBase
 *
 * @property string $Text is the contents of the textbox, itself.
 * @property string|null $Value Returns the value of the text. If the text is empty, will return null.
 *
 * @package QCubed\Plugin
 */

class DateTimePickerBase extends DateTimePickerBaseGen
{
    /**
     * Using these constants makes it easier to send the date and time to the database in the correct format.
     */
    const DEFAULT_OUTPUT_DATETIME = 'yyyy-mm-dd hh:ii:ss';
    const DEFAULT_OUTPUT_DATE = 'yyyy-mm-dd';
    const DEFAULT_OUTPUT_TIME = 'hh:ii:ss';
    const DEFAULT_OUTPUT_YEAR = 'yyyy';

    /** @var string|null */
    protected $strText = null;

    /**
     * DateTimePickerBase constructor
     *
     * @param ControlBase|FormBase|null $objParentObject
     * @param null|string $strControlId
     */
    public function __construct($objParentObject, $strControlId = null) {
        parent::__construct($objParentObject, $strControlId);
        $this->registerFiles();
        $this->LinkField = $this->ControlId . '_mirror';
        $this->setHtmlAttribute('autocomplete', 'off');
    }

    /**
     * @throws Caller
     */
    protected function registerFiles() {
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/bootstrap-datetimepicker.js");
        $this->addCssFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/css/bootstrap-datetimepicker.css");
        $this->AddCssFile(QCUBED_BOOTSTRAP_CSS); // make sure they know
        $this->AddCssFile(QCUBED_FONT_AWESOME_CSS); // make sure they know
    }

    public function parsePostData()
    {
        $strKey = $this->strControlId . '_mirror';
        if (array_key_exists($strKey, $_POST)) {
            $strText = $_POST[$strKey];
            $this->strText = $strText;
        }
    }

    protected function getControlHtml()
    {
        $strToReturn = parent::getControlHtml();

        $strToReturn .= _nl() . sprintf('<input  id="%s" name="%s" value="%s" type="hidden" />',
                $this->strControlId . '_mirror',
                $this->strControlId . '_mirror',
                $this->strText);

        return $strToReturn;
    }

    public function validate()
    {
        return true;
    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "Text": return $this->strText;
            case 'Value': return empty($this->strText) ? null : $this->strText;

            default:
                try {
                    return parent::__get($strName);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }
}

