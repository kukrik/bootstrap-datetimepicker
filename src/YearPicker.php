<?php

namespace QCubed\Plugin;

use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Type;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;

/**
 * Class YearPicker
 *
 * @package QCubed\Plugin
 */

class YearPicker extends DateTimePickerBaseGen
{
    protected ?string $strText = null;

    public function __construct(ControlBase|FormBase $objParentObject, ?string $strControlId = null) {
        parent::__construct($objParentObject, $strControlId);
        $this->StartView = 4;
        $this->MinView = 4;
        $this->ForceParse = false;
        $this->Format = 'yyyy';
        $this->setHtmlAttribute('autocomplete', 'off');
        $this->registerFiles();
    }

    /**
     * Registers the required JavaScript and CSS files for the datetime picker functionality.
     *
     * @return void
     * @throws Caller
     */
    protected function registerFiles(): void
    {
        $this->AddJavascriptFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/js/bootstrap-datetimepicker.js");
        $this->addCssFile(QCUBED_DATETIMEPICKER_ASSETS_URL . "/css/bootstrap-datetimepicker.css");
        $this->AddCssFile(QCUBED_BOOTSTRAP_CSS); // make sure they know
        $this->AddCssFile(QCUBED_FONT_AWESOME_CSS); // make sure they know
    }

    /**
     * Magic method to get the value of a property dynamically.
     *
     * @param string $strName The name of the property to retrieve.
     *
     * @return mixed The value of the requested property if it exists.
     *               Throws an exception if the property is not defined.
     * @throws Caller
     */
    public function __get(string $strName): mixed
    {
        switch ($strName) {
            case 'Text': return $this->strText;

            default:
                try {
                    return parent::__get($strName);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * Magic method to set the value of a property dynamically.
     *
     * @param string $strName The name of the property to set.
     * @param mixed $mixValue The value to assign to the property.
     *
     * @return void
     * @throws InvalidCast if the value cannot be cast to the required type.
     * @throws Caller if the property is not defined or cannot be set.
     */
    public function __set(string $strName, mixed $mixValue): void
    {
        switch ($strName) {
            case 'Text':
                try {
                    $this->strText = Type::cast($mixValue, Type::INTEGER);
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            default:
                try {
                    parent::__set($strName, $mixValue);
                    break;
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }
}

