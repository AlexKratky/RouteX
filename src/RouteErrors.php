<?php
/**
 * @name RouteErrors.php
 * @link https://alexkratky.cz                          Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/panx-framework/  Github Repository
 * @author Alex Kratky <info@alexkratky.cz>
 * @copyright Copyright (c) 2019 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Contains custom errors. Part of panx-framework.
 */

namespace AlexKratky;

interface RouteErrors {
    /**
     * @var string Example custom error.
     */
    const ERROR_NOT_LOGGED_IN = "NOT_LOGGED_IN";

    /**
     * @var int This error will not include any files.
     */
    const DO_NOT_INCLUDE_ANY_FILE = -1;
    /**
     * @var int Middleware error (When middleware decline request).
     */
    const ERROR_MIDDLEWARE = 1;
    /**
     * @var int Error 400 - Bad Request.
     */
    const ERROR_BAD_REQUEST = 400;
    /**
     * @var int Error 403 - Forbidden.
     */
    const ERROR_FORBIDDEN = 403;
    /**
     * @var int Error 404 - Not found.
     */
    const ERROR_NOT_FOUND = 404;
    /**
     * @var int Error 500 - Internal server error.
     */
    const ERROR_INTERNAL_SERVER = 500;

}
