<?php
/**
 * @name MissingActionArgumentException.php
 * @link https://alexkratky.cz                          Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/panx-framework/  Github Repository
 * @author Alex Kratky <info@alexkratky.cz>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Loads the files from Route. Part of panx-framework.
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
