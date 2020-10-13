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

    /**
     * Returns the current state of the control to be able to restore it later.
     * @return mixed
     */
    protected function getState()
    {
        return array('text' => $this->Text);
    }

    /**
     * Restore the state of the control.
     * @param mixed $state Previously saved state as returned by GetState above.
     */
    protected function putState($state)
    {
        if (isset($state['text'])) {
            $this->Text = $state['text'];
        }
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

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    /**
     * PHP magic method implementation
     *
     * @param string $strName Property name
     * @param string $mixValue Property value to be set
     *
     * @throws Caller|InvalidCast
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case "Text":
            case "Value":
                try {
                    $val = Type::cast($mixValue, Type::STRING);
                    if ($val !== $this->strText) {
                        $this->strText = $val;
                        $this->addAttributeScript('val', $val);
                    }
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            default:
                try {
                    parent::__set($strName, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;
        }
    }
}

