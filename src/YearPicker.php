<?php

namespace QCubed\Plugin;

use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Type;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Project\Application;

/**
 * Class YearPicker
 *
 * @package QCubed\Plugin
 */

class YearPicker extends DateTimePickerBaseGen
{
    //protected $strText = null;

    public function __construct($objParentObject, $strControlId = null) {
        parent::__construct($objParentObject, $strControlId);
        $this->StartView = 4;
        $this->MinView = 4;
        $this->ForceParse = false;
        $this->Format = 'yyyy';
    }

    public function __set($strName, $mixValue)
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

