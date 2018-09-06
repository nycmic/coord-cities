<?php
/**
 * Created by PhpStorm.
 * User: itinium
 * Date: 05.09.18
 * Time: 23:44
 */

namespace app\interfaces;

/**
 * This interface is define which class instances can be calculated and define events to it.
 * Interface CalculateEventInterface
 * @package app\interfaces
 */
interface CalculateEventInterface
{
	const EVENT_CALCULATE_FROM = 'eventCalculateFrom';
	const EVENT_CALCULATE_TO = 'eventCalculateTo';
}