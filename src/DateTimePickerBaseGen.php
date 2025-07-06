<?php

namespace QCubed\Plugin;

use QCubed\ApplicationBase;
use QCubed\Bootstrap as Bs;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\ModelConnector\Param as QModelConnectorParam;
use QCubed\Project\Application;
use QCubed\Type;

/**
 * Class DateTimePickerGen
 *
 * @see DateTimePickerBase
 * @package QCubed\Plugin
 */

/**
 * All options that take a "Date" can handle a Date object; a String formatted according to the given format; or
 * a time delta relative today, e.g. '-1d', '+6m +1y', etc., where valid units are 'd' (day), 'w' (week), 'm' (month), and 'y' (year).
 *
 * You can also specify an ISO-8601 valid datetime, despite the given format:
 *                          yyyy-mm-dd
 *                          yyyy-mm-dd hh:ii
 *                          yyyy-mm-ddThh:ii
 *                          yyyy-mm-dd hh:ii:ss
 *                          yyyy-mm-ddThh:ii:ssZ
 *
 * @property string $Format Default: 'mm/dd/yyyy'. The date format, combination of p, P, h, hh, i, ii, s, ss, d, dd, m, mm, M, MM, yy, yyyy.
 *                          p : meridian in lower case ('am' or 'pm') - according to locale file
 *                          P : meridian in upper case ('AM' or 'PM') - according to locale file
 *                          s : seconds without leading zeros
 *                          ss : seconds, 2 digits with leading zeros
 *                          i : minutes without leading zeros
 *                          ii : minutes, 2 digits with leading zeros
 *                          h : hour without leading zeros - 24-hour format
 *                          hh : hour, 2 digits with leading zeros - 24-hour format
 *                          H : hour without leading zeros - 12-hour format
 *                          HH : hour, 2 digits with leading zeros - 12-hour format
 *                          d : day of the month without leading zeros
 *                          dd : day of the month, 2 digits with leading zeros
 *                          m : numeric representation of month without leading zeros
 *                          mm : numeric representation of the month, 2 digits with leading zeros
 *                          M : short textual representation of a month, three letters
 *                          MM : full textual representation of a month, such as January or March
 *                          yy : two digit representation of a year
 *                          yyyy : full numeric representation of a year, 4 digits
 *
 * @property string LinkField LinkField does not need to be defined by the user. It is already defined globally by default.
 * @property string LinkFormat To send correctly, the user must also define a LinkFormat.
 * Here you need to specify the LinkFormat format as you want to display either datetime or date or time or year.
 * Usage:
 * <code>
 * $this->dlg = new Q\Plugin\DateTimepicker($this);
 * $this->dlg->Language = 'fr';
 * $this->dlg->WeekStart = 1;
 * $this->dlg->TodayHighlight = true;
 * $this->dlg->..........etc.
 * $this->dlg->Format = 'dd.mm.yyyy'; // Please a see the instructions for using the Format.
 * $this->dlg->LinkFormat = Q\Plugin\DateTimePicker::DEFAULT_OUTPUT_DATETIME;
 * or
 * $this->dlg->LinkFormat = Q\Plugin\DateTimePicker::DEFAULT_OUTPUT_DATE;
 * or
 * $this->dlg->LinkFormat = Q\Plugin\DateTimePicker::DEFAULT_OUTPUT_TIME;
 * or
 * $this->dlg->LinkFormat = Q\Plugin\DateTimePicker::DEFAULT_OUTPUT_YEAR;
 * </code>
 *
 * @property integer $WeekStart Default: 0. Day of the week start. 0 (Sunday) to 6 (Saturday).
 * @property string $StartDate Date. Default: Beginning of time. The earliest date that may be selected; all earlier dates will be disabled.
 * @property string $EndDate Date. Default: End of time. The latest date that may be selected; all later dates will be disabled.
 * @property array $DaysOfWeekDisabled Default: []. Days of the week that should be disabled. Values are 0 (Sunday) to 6 (Saturday).
 *                              Multiple values should be comma-separated. Example: disable weekends: [0,6].
 * @property boolean $AutoClose Default: false. Whether or not to close the datetimepicker immediately when a date is selected.
 * @property integer $StartView Default: 2. The view that the datetimepicker should show when it is opened. Accepts values of :
 *                              0 for hour view
 *                              1 for the day view
 *                              2 for month view (the default)
 *                              3 for the 12-month overview
 *                              4 for the 10-year overview. Useful for date-of-birth datetimepickers.
 * @property integer $MinView Default: 0. The lowest view that the datetimepicker should show.
 * @property integer $MaxView Default: 4. The highest view that the datetimepicker should show.
 * @property boolean $TodayBtn Default: false. If true or "linked", displays a "Today" button at the bottom of
 *                              the datetimepicker to select the current date. If true, the "Today" button will
 *                              only move the current date into view; if "linked", the current date will also be selected.
 * @property boolean $TodayHighlight false. If true, highlights the current date.
 * @property boolean $ClearBtn Default: false. Whether or not to enable the date, selector clears the button.
 * @property boolean $KeyboardNavigation Default: true. Whether or not to allow date navigation by arrow keys.
 * @property string $Language Default: 'en'. The two-letter code of the language to use for a month and day names.
 *                              These will also be used as the input's value (and subsequently sent to the server in the
 *                              case of form submissions). Currently ships with English ('en'), German ('de'), Brazilian ('br'),
 *                              and Spanish ('es') translations, but others can be added (see I18N below). If an unknown
 *                              language code is given, English will be used.
 * @property boolean $ForceParse Default: true. Whether or not to force parsing of the input value when the picker is closed.
 *                              That is, when an invalid date is left in the input field by the user, the picker will forcibly
 *                              parse that value and set the input's value to the new, valid date, conforming to the given format.
 * @property integer $MinuteStep Default: 5. The increment used to build the hour view. A preset is created for each minuteStep minutes.
 * @property string $PickerPosition Default: 'bottom-right' (other value supported: 'bottom-left'). This option is current
 *                              only available in the component implementation. With it, you can place the picker just
 *                              under the input field.
 * @property string $ViewSelect Default: same as minView (supported values are: 'decade', 'year', 'month', 'day', 'hour').
 *                              With this option you can select the view from which the date will be selected. By default,
 *                              it's the last one, however, you can choose the first one, so at each click the date will be updated.
 * @property boolean $ShowMeridian Default: false. This option will enable meridian views for day and hour views.
 * @property string $InitialDate Default: new Date(). You can initialize the viewer with a date. By default, it's now.
 *                              so you could specify yesterday or today at midnight ...
 *
 * @see https://www.malot.fr/bootstrap-datetimepicker/ or https://github.com/smalot/bootstrap-datetimepicker
 * @package QCubed\Plugin
 */

class DateTimePickerBaseGen extends Bs\TextBox
{
    /** @var string|null */
    protected ?string $strLinkField = null;
    /** @var string|null */
    protected ?string $strLinkFormat = null;
    /** @var string */
    protected string $strFormat;
    /** @var integer|null */
    protected ?int $intWeekStart = null;
    /** @var string|null */
    protected ?string $strStartDate = null;
    /** @var string|null */
    protected ?string $strEndDate = null;
    /** @var array|null */
    protected ?array $arrDaysOfWeekDisabled = null;
    /** @var boolean */
    protected ?bool $blnAutoClose = null;
    /** @var integer|null */
    protected ?int $intStartView = null;
    /** @var integer|null */
    protected ?int $intMinView = null;
    /** @var integer|null */
    protected ?int $intMaxView = null;
    /** @var boolean */
    protected ?bool $blnTodayBtn = null;
    /** @var boolean */
    protected ?bool $blnClearBtn = null;
    /** @var boolean */
    protected ?bool $blnTodayHighlight = null;
    /** @var boolean */
    protected ?bool $blnKeyboardNavigation = null;
    /** @var string|null */
    protected ?string $strLanguage = null;
    /** @var boolean */
    protected ?bool $blnForceParse = null;
    /** @var integer|null */
    protected ?int $intMinuteStep = null;
    /** @var string|null */
    protected ?string $strPickerPosition = null;
    /** @var string|null */
    protected ?string $strViewSelect = null;
    /** @var boolean */
    protected ?bool $blnShowMeridian = null;
    /** @var string|null */
    protected ?string $strInitialDate = null;

    /**
     * Constructs an array of jQuery options by combining parent options with additional properties.
     *
     * Each property is checked for existence and non-null value before being added to the option array.
     *
     * @return array An associative array of jQuery options to be passed to a jQuery widget.
     */
    protected function makeJqOptions(): array
    {
        $jqOptions = parent::MakeJqOptions();
        if (!is_null($val = $this->LinkField)) {$jqOptions['linkField'] = $val;}
        if (!is_null($val = $this->LinkFormat)) {$jqOptions['linkFormat'] = $val;}
        if (!is_null($val = $this->Format)) {$jqOptions['format'] = $val;}
        if (!is_null($val = $this->WeekStart)) {$jqOptions['weekStart'] = $val;}
        if (!is_null($val = $this->StartDate)) {$jqOptions['startDate'] = $val;}
        if (!is_null($val = $this->EndDate)) {$jqOptions['endDate'] = $val;}
        if (!is_null($val = $this->DaysOfWeekDisabled)) {$jqOptions['daysOfWeekDisabled'] = $val;}
        if (!is_null($val = $this->AutoClose)) {$jqOptions['autoclose'] = $val;}
        if (!is_null($val = $this->StartView)) {$jqOptions['startView'] = $val;}
        if (!is_null($val = $this->MinView)) {$jqOptions['minView'] = $val;}
        if (!is_null($val = $this->MaxView)) {$jqOptions['maxView'] = $val;}
        if (!is_null($val = $this->TodayBtn)) {$jqOptions['todayBtn'] = $val;}
        if (!is_null($val = $this->ClearBtn)) {$jqOptions['clearBtn'] = $val;}
        if (!is_null($val = $this->TodayHighlight)) {$jqOptions['todayHighlight'] = $val;}
        if (!is_null($val = $this->KeyboardNavigation)) {$jqOptions['keyboardNavigation'] = $val;}
        if (!is_null($val = $this->Language)) {$jqOptions['language'] = $val;}
        if (!is_null($val = $this->ForceParse)) {$jqOptions['forceParse'] = $val;}
        if (!is_null($val = $this->MinuteStep)) {$jqOptions['minuteStep'] = $val;}
        if (!is_null($val = $this->PickerPosition)) {$jqOptions['pickerPosition'] = $val;}
        if (!is_null($val = $this->ViewSelect)) {$jqOptions['viewSelect'] = $val;}
        if (!is_null($val = $this->ShowMeridian)) {$jqOptions['showMeridian'] = $val;}
        if (!is_null($val = $this->InitialDate)) {$jqOptions['initialDate'] = $val;}
        return $jqOptions;
    }

    /**
     * Retrieves the jQuery setup function name associated with the control.
     *
     * @return string The name of the jQuery setup function.
     */
    public function getJqSetupFunction(): string
    {
        return 'datetimepicker';
    }

    /**
     * Remove the datetimepicker. Removes attached events, internal attached objects, and added HTML elements.
     *
     * This method does not accept any arguments.
     */
    public function remove(): void
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "remove", ApplicationBase::PRIORITY_LOW);
    }

    /**
     * Show the datetimepicker.
     *
     * This method does not accept any arguments.
     */
    public function show(): void
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "show", ApplicationBase::PRIORITY_LOW);
    }

    /**
     * Hide the datetimepicker.
     *
     * This method does not accept any arguments.
     */
    public function hide(): void
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "hide", ApplicationBase::PRIORITY_LOW);
    }

    /**
     * Update the datetimepicker with the current input value.
     *
     * This method does not accept any arguments.
     */
    public function update(): void
    {
        Application::executeControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "update", ApplicationBase::PRIORITY_LOW);
    }

    /**
     * Magic method to retrieve the value of a property by name.
     *
     * This method fetches the value of the specified property if it exists in the defined cases.
     * If the property is not defined within the class, it attempts to access it using the parent's
     * __get method. Throws an exception if the property is not found.
     *
     * @param string $strName The name of the property to retrieve.
     *
     * @return mixed The value of the requested property or the parent's property value if defined, otherwise throws an exception.
     * @throws Caller If the property does not exist in the class or parent class.
     */
    public function __get(string $strName): mixed
    {
        switch ($strName) {
            case 'LinkField': return $this->strLinkField;
            case 'LinkFormat': return $this->strLinkFormat;
            case 'Format': return $this->strFormat;
            case 'WeekStart': return $this->intWeekStart;
            case 'StartDate': return $this->strStartDate;
            case 'EndDate': return $this->strEndDate;
            case 'DaysOfWeekDisabled': return $this->arrDaysOfWeekDisabled;
            case 'AutoClose': return $this->blnAutoClose;
            case 'StartView': return $this->intStartView;
            case 'MinView': return $this->intMinView;
            case 'MaxView': return $this->intMaxView;
            case 'TodayBtn': return $this->blnTodayBtn;
            case 'ClearBtn': return $this->blnClearBtn;
            case 'TodayHighlight': return $this->blnTodayHighlight;
            case 'KeyboardNavigation': return $this->blnKeyboardNavigation;
            case 'Language': return $this->strLanguage;
            case 'ForceParse': return $this->blnForceParse;
            case 'MinuteStep': return $this->intMinuteStep;
            case 'PickerPosition': return $this->strPickerPosition;
            case 'ViewSelect': return $this->strViewSelect;
            case 'ShowMeridian': return $this->blnShowMeridian;
            case 'InitialDate': return $this->strInitialDate;

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
     * Magic method to set property values for the class.
     *
     * Valid property names include:
     * - LinkField
     * - LinkFormat
     * - Format
     * - WeekStart
     * - StartDate
     * - EndDate
     * - DaysOfWeekDisabled
     * - AutoClose
     * - StartView
     * - MinView
     * - MaxView
     * - TodayBtn
     * - ClearBtn
     * - TodayHighlight
     * - KeyboardNavigation
     * - Language
     * - ForceParse
     * - MinuteStep
     * - PickerPosition
     * - ViewSelect
     * - ShowMeridian
     *
     * Each property name must be set to a corresponding value of a valid type. If an invalid type is provided,
     * an InvalidCast exception will be thrown during the casting process.
     *
     * @param string $strName The name of the property to be set.
     * @param mixed $mixValue The value to assign to the property.
     *
     * @return void
     * @throws InvalidCast If $mixValue does not match the expected type of the property specified by $strName.
     * @throws \QCubed\Exception\Caller
     */
    public function __set(string $strName, mixed $mixValue): void
    {
        switch ($strName) {
            case 'LinkField':
                try {
                    $this->strLinkField = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'linkField', $this->strLinkField);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'LinkFormat':
                try {
                    $this->strLinkFormat = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'linkFormat', $this->strLinkFormat);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Format':
                try {
                    $this->strFormat = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'format', $this->strFormat);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'WeekStart':
                try {
                    $this->intWeekStart = Type::cast($mixValue, Type::INTEGER);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'weekStart', $this->intWeekStart);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'StartDate':
                try {
                    $this->strStartDate = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'startDate', $this->strStartDate);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'EndDate':
                try {
                    $this->strEndDate = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'endDate', $this->strEndDate);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'DaysOfWeekDisabled':
                try {
                    $this->arrDaysOfWeekDisabled = Type::cast($mixValue, Type::ARRAY_TYPE);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'daysOfWeekDisabled', $this->arrDaysOfWeekDisabled);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'AutoClose':
                try {
                    $this->blnAutoClose = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'autoclose', $this->blnAutoClose);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'StartView':
                try {
                    $this->intStartView = Type::cast($mixValue, Type::INTEGER);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'startView', $this->intStartView);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'MinView':
                try {
                    $this->intMinView = Type::cast($mixValue, Type::INTEGER);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'minView', $this->intMinView);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'MaxView':
                try {
                    $this->intMaxView = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'maxView', $this->intMaxView);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'TodayBtn':
                try {
                    $this->blnTodayBtn = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'todayBtn', $this->blnTodayBtn);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'ClearBtn':
                try {
                    $this->blnClearBtn = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'clearBtn', $this->blnClearBtn);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'TodayHighlight':
                try {
                    $this->blnTodayHighlight = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'todayHighlight', $this->blnTodayHighlight);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'KeyboardNavigation':
                try {
                    $this->blnKeyboardNavigation = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'keyboardNavigation', $this->blnKeyboardNavigation);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'Language':
                try {
                    $this->strLanguage = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'language', $this->strLanguage);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'ForceParse':
                try {
                    $this->blnForceParse = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'forceParse', $this->blnForceParse);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'MinuteStep':
                try {
                    $this->intMinuteStep = Type::cast($mixValue, Type::INTEGER);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'minuteStep', $this->intMinuteStep);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'PickerPosition':
                try {
                    $this->strPickerPosition = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'pickerPosition', $this->strPickerPosition);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'ViewSelect':
                try {
                    $this->strViewSelect = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'viewSelect', $this->strViewSelect);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'ShowMeridian':
                try {
                    $this->blnShowMeridian = Type::cast($mixValue, Type::BOOLEAN);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'showMeridian', $this->blnShowMeridian);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

            case 'InitialDate':
                try {
                    $this->strInitialDate = Type::cast($mixValue, Type::STRING);
                    $this->addAttributeScript($this->getJqSetupFunction(), 'option', 'initialDate', $this->strInitialDate);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }

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

    /**
     * If this control is attachable to a codegenerated control in a ModelConnector, this function will be
     * used by the ModelConnector designer dialog to display a list of options for the control.
     * @return QModelConnectorParam[]
     *
     * @throws Caller
     */
    public static function getModelConnectorParams(): array
    {
        return array_merge(parent::getModelConnectorParams(), array());
    }
}


