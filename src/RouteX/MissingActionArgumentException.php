<?php
/**
 * @name MissingActionArgumentException.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/RouteX/          Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Missing Action Argument Exception. Part of panx-framework.
 */

namespace AlexKratky;

class MissingActionArgumentException extends \Exception
{
    public function __construct($argument) {
        parent::__construct("Missing action's argument. (" . $argument . ")", 0, null);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
