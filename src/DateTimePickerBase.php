<?php

namespace QCubed\Plugin;

use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use DateMalformedStringException;
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
    const string DEFAULT_OUTPUT_DATETIME = 'Datetime';
    const string DEFAULT_OUTPUT_DATE = 'Date';
    const string DEFAULT_OUTPUT_TIME = 'Time';

    /** @var QDateTime|null */
    protected ?QDateTime $dttDateTime = null;
    protected string $strDateTimePickerType;

    /**
     * Parses the posted data for the control based on its type and populates the corresponding
     * date or time value into the control's property if provided in the POST data.
     *
     * @return void
     * @throws DateMalformedStringException
     * @throws Caller
     */
    public function parsePostData(): void
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

    /**
     * Validates the current state or value of the object or data and returns the result of the validation.
     *
     * @return bool Indicates whether the validation was successful (true) or not (false).
     */
    public function validate(): bool
    {
        return true;
    }

    /**
     * Retrieves the value of a property based on its name. Handles specific properties
     * and delegates to the parent class for others. Throws an exception if the property
     * does not exist or is inaccessible.
     *
     * @param string $strName The name of the property to retrieve.
     *
     * @return mixed The value of the requested property or null if it does not exist.
     * @throws Caller If the property does not exist or is inaccessible.
     */
    public function __get(string $strName): mixed
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

    /**
     * Sets the value of a property for the object. Handles specific cases for 'DateTime'
     * and 'DateTimePickerType', casting the provided value and applying the appropriate
     * transformations. Delegates to the parent method for other property names.
     *
     * @param string $strName The name of the property to set.
     * @param mixed $mixValue The value to be set for the specified property.
     *
     * @return void
     * @throws InvalidCast If the provided value cannot be cast to the expected type.
     * @throws Caller If an invalid property name is specified and cannot be handled by the parent class.
     */
    public function __set(string $strName, mixed $mixValue): void
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