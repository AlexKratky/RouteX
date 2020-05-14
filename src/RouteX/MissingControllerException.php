<?php
/**
 * @name MissingControllerException.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/RouteX/          Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Missing Controller Exception. Part of panx-framework.
 */

namespace AlexKratky;

class MissingControllerException extends \Exception
{
    public function __construct($controller) {
        parent::__construct("Missing Controller file '{$controller}'", 0, null);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
