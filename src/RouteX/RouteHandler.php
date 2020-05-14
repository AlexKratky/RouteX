<?php
/**
 * @name RouteHandler.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/RouteX/          Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Loads the files from Route. Part of panx-framework.
 */
declare(strict_types = 1);

namespace AlexKratky;

use AlexKratky\Route;
use AlexKratky\RouteErrors;
use AlexKratky\MissingControllerException;
use AlexKratky\MissingActionException;
use AlexKratky\MissingActionArgumentException;

class RouteHandler {
    
    private $template_files;
    private $template_directory;
    private $controllers_directory;
    private $handlers_directory;
    private $handlers = array();

    /**
     * @param string|null $template_directory The path of template directory.
     * @param string|null $controllers_directory The path of controllers directory.
     * @param string|null $handlers_directory The path of handlers directory.
     */
    public function __construct($template_directory = null, $controllers_directory = null, $handlers_directory = null) {
        $this->setHandlers();
        $this->template_directory = ($template_directory ?? $_SERVER['DOCUMENT_ROOT'] . "/../template/");
        $this->controllers_directory = ($controllers_directory ?? $_SERVER['DOCUMENT_ROOT'] . "/../app/controllers/");
        $this->handlers_directory = ($handlers_directory ?? $_SERVER['DOCUMENT_ROOT'] . "/../app/handlers/");
    }

    /**
     * @param mixed $template_files
     */
    public function handle($template_files) {
        $this->template_files = $template_files;
        $include = $this->checkForErrors($template_files);

        if (is_callable($this->template_files)) {
            $x = $this->template_files;
            $x();
            return;
        }

        if($include && $this->template_files !== null) {
            if (!is_array($this->template_files)) {
                $this->template_files = array($this->template_files);
            }

            for ($i = 0; $i < count($this->template_files); $i++) {
                $ext = pathinfo($this->template_directory . $this->template_files[$i])["extension"] ?? null;
                if ($ext == "php" && !isset($this->handlers["php"])) {
                    require $this->template_directory . $this->template_files[$i];
                    continue;
                }
                //custom handler
                $h;
                $ext = ucfirst(strtolower($ext));
                $h = $ext . "Handler";
                if (!empty($this->handlers[$ext])) {
                    $h = $this->handlers[$ext];
                }

                if (file_exists($this->handlers_directory . $h . ".php")) {
                    require_once $this->handlers_directory . $h . ".php";
                    $controller = $this->getControllerAndAction()[0];
                    $action = $this->getControllerAndAction()[1];

                    if($controller !== null) {
                        $controller = $this->requireController($controller);
                        $controller::main($h);
                        $this->callAction($controller, $action);
                    }

                    $h::handle($this->template_files[$i]);
                }
            }
        } else {
            $controller = $this->getControllerAndAction()[0];

            $action = $this->getControllerAndAction()[1];
            if($controller !== null) {
                $controller = $this->requireController($controller);
                $controller::main(null);
                $this->callAction($controller, $action);
            }
        }
    }

    /**
     * Sets handlers for custom extensions like *.latte etc.
     */
    public function setHandlers($h = null) {
        if($h == null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/../app/core/handlers.php")) {
                require $_SERVER['DOCUMENT_ROOT'] . "/../app/core/handlers.php";
                $this->handlers = $handlers;
                return;
            }
        }
        if(is_array($h)) {
            $this->handlers = $h;
            return;
        }
        if(is_string($h)) {
            if (file_exists($h)) {
                require $h;
                $this->handlers = $handlers;
            }
        }
    }

    private function checkForErrors($template_files): bool {
        if(is_callable($template_files)) return true;
        $routeErrors = new \ReflectionClass(RouteErrors::Class);
        $routeErrors = $routeErrors->getConstants();
        foreach ($routeErrors as $routeError => $value) {
            if($template_files == $value) {
                $this->template_files = Route::searchError($value);
                if($value == Route::DO_NOT_INCLUDE_ANY_FILE) {
                    return false;
                }
                break;
            }
        }
        return true;
    }

    /**
     * @return array [0] => Controller (string|null), [1] => Action (string|null)
     */
    private function getControllerAndAction(): array {
        $controller = Route::getController();
        $action = null;
        if ($controller !== null && $controller === null) {
            $controller = Route::getRouteController();
        }
        if($controller !== null && strpos($controller, "#") !== false) {
            $c = explode("#", $controller, 2);
            $controller = $c[0];
            $action = $c[1];  
        }
        $action = $action ?? Route::getRouteAction();
        return array(
            $controller,
            $action
        );
    }

    /**
     * Requires controller file or throw MissingControllerException.
     */
    private function requireController(string $controller) {
        if (file_exists($this->controllers_directory . "$controller.php")) {
            require_once $this->controllers_directory . "$controller.php";
            return $controller;
        } else {
            $c = ucfirst(strtolower($controller)) . "Controller";
            if (file_exists($this->controllers_directory . "$c.php")) {
                require_once $this->controllers_directory . "$c.php";
                return $c;
            } else {
                throw new MissingControllerException($controller);
            }
        }
    }

    /**
     * Calls Controller's action or throw MissingActionException.
     */
    private function callAction(string $controller, ?string $action) {
        if ($action !== null) {
            if (method_exists($controller, $action)) {
                call_user_func_array(array($controller, $action), $this->getArrayOfParameters(new \ReflectionMethod($controller, $action)));
            } else {
                throw new MissingActionException([$controller, $action]);
            }
        }
    }

    /**
     * Returns array of parameters or throw MissingActionArgumentException.
     */
    private function getArrayOfParameters($r) {
        $a = array();
        $params = $r->getParameters();
        foreach ($params as $param) {
            if(Route::getValue($param->getName()) === false) {
                if($param->isOptional()) {
                    array_push($a, null);
                    continue;
                } else {
                    throw new MissingActionArgumentException($param->getName());
                }
            }
            array_push($a, Route::getValue($param->getName()));
            
        }
        return $a;
    }

}
