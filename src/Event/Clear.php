<?php

namespace QCubed\Plugin\Event;

use QCubed\Event\EventBase;

/**
 * Class Clear
 *
 * Detects the click event of the DateTimePicker button class "clear",
 * and can optionally trigger another event on other objects.
 *
 */

class Clear extends EventBase {
    const EVENT_NAME = 'clear';
}
