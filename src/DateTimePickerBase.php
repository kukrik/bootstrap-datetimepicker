<?php

namespace QCubed\Plugin;

use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\QDateTime;
use QCubed\Type;

/**
 * Class DateTimePickerBase
 *
 * @property null|QDateTime $DateTime
 * @property string $DateTimePickerType
 *
 * @package QCubed\Plugin
 */

class DateTimePickerBase extends DateTimePickerBaseGen
{
    /**
     * Using these constants makes it easier to send the date and time to the database in the correct format.
     */
    const DEFAULT_OUTPUT_DATETIME = 'Datetime';
    const DEFAULT_OUTPUT_DATE = 'Date';
    const DEFAULT_OUTPUT_TIME = 'Time';

    /** @var QDateTime|null */
    protected $dttDateTime = null;
    protected $strDateTimePickerType;

    public function parsePostData()
    {
        // Check to see if this Control's Value was passed in via the POST data
        switch ($this->strDateTimePickerType) {
            case self::DEFAULT_OUTPUT_DATETIME:
                if (array_key_exists($this->strControlId, $_POST)) {
                    parent::parsePostData();
                    $this->dttDateTime = new QDateTime($this->strText, null, QDateTime::DATE_AND_TIME_TYPE);
                    if ($this->dttDateTime->isNull()) {
                        $this->dttDateTime = null;
                    }
                }
                break;

            case self::DEFAULT_OUTPUT_DATE:
                if (array_key_exists($this->strControlId, $_POST)) {
                    parent::parsePostData();
                    $this->dttDateTime = new QDateTime($this->strText, null, QDateTime::DATE_ONLY_TYPE);
                    if ($this->dttDateTime->isDateNull()) {
                        $this->dttDateTime = null;
                    }
                }
                break;

            case self::DEFAULT_OUTPUT_TIME:
                if (array_key_exists($this->strControlId, $_POST)) {
                    parent::parsePostData();
                    $this->dttDateTime = new QDateTime($this->strText, null, QDateTime::TIME_ONLY_TYPE);
                    if ($this->dttDateTime->isTimeNull()) {
                        $this->dttDateTime = null;
                    }
                }
                break;
        }
    }

    public function validate()
    {
        return true;
    }

    /**
     * @param string $strName
     * @return bool|mixed|null|string
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'DateTime': return $this->dttDateTime ? clone($this->dttDateTime) : null;
            case "DateTimePickerType": return $this->strDateTimePickerType;

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
            case 'DateTime':
                try {
                    $dtt = Type::cast($mixValue, Type::DATE_TIME);
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

                if ($dtt->DateTime) {
                    $this->Text = $dtt->qFormat("Y-m-d H:i:s");
                } elseif($dtt->Date) {
                    $this->Text = $dtt->qFormat("Y-m-d");
                } elseif($dtt->Time) {
                    $this->Text = $dtt->qFormat("h:mm z");
                } else {
                    $this->Text = '';
                }
                break;

            case "DateTimePickerType":
                try {
                    $this->strDateTimePickerType = Type::cast($mixValue, Type::STRING);
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