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

class YearPickerBase extends DateTimePickerBaseGen
{
    protected $strText = null;

    public function __get($strName)
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

