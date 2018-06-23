<?php

namespace MyFramework;

class Core
{

    static protected $routes = [];
    static private $_render;
    static protected $pdo;
    public function __construct(){
try
{
    $pdo = new \PDO('mysql:host=localhost;dbname=my_framework', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
    }    

    private function router($controller, $action) 
    {
        self::$routes = [
        'controller' => $controller,
        'action' => $action,
        ];
    }
    private function routing()
    {
        if (!empty($this->request()))
        {
            $action = $this->controller();
            $controller = $this->action();
            $filename = ROOT . 'controllers/'.ucfirst($controller).'Controller.class.php';
            if (file_exists($filename) && method_exists(__NAMESPACE__ . '\\' . ucfirst($controller).'Controller', $action))
            {
                $this->router($controller,$action); 
            } else {
                $this->router('default','default');
            }
        } else {
            $this->router('default','default');
        }
    }
/* 
    Get the full URI.
    return ""
*/
    protected function request() 
        {
            return trim(preg_replace("#my_framework/#", "", $_SERVER['REQUEST_URI']), '/');
        }
/* 
    Pull the Controller.
*/
    protected function controller() 
        {
            return trim(strstr($this->request(), '/'), '/');
        }
/* 
    Pick up the Action.
*/
    protected function action() 
        {
            return trim(strstr($this->request(), '/', true), '/');
        }
    protected function render($params = [])
        {
            $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'views',
                self::$routes['controller'], self::$routes['action']]) . '.html';
            if (file_exists($f)) {
                $c = file_get_contents($f);
                foreach ($params as $k => $v) 
                {
                    $c = preg_replace("/\{\{\s*$k\s*\}\}/", $v, $c);
                }
                self::$_render = $c;
            }
            else {
                self::$_render = "Impossible de trouver la vue" . PHP_EOL;
            }
        }
/*

*/ 
public function run()
{
    $this->routing();
    $controller = __NAMESPACE__ . '\\' . ucfirst(self::$routes['controller']) .
    'Controller';
    $controller = new $controller();
    if (method_exists($controller, $action = self::$routes['action'])) {
        $controller->$action();
    }
    else {
        self::$_render = "Impossible de trouver la methode" . PHP_EOL;
    }
    echo self::$_render;
}
}
