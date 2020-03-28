<?php
/**
 * @name MissingActionException.php
 * @link https://alexkratky.cz                          Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/panx-framework/  Github Repository
 * @author Alex Kratky <info@alexkratky.cz>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Loads the files from Route. Part of panx-framework.
 */

namespace AlexKratky;

class MissingActionException extends \Exception
{
    public function __construct($controller_and_action) {
        parent::__construct("Missing Controller's action. (" . $controller_and_action[0] . "#" . $controller_and_action[1]. ")", 0, null);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
