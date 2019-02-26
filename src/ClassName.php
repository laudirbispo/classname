<?php declare(strict_types=1);
namespace libs\laudirbispo\Route;
/**
 * Copyright (c) Laudir Bispo  (laudirbispo@outlook.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     (c) Laudir Bispo  (laudirbispo@outlook.com)
 * @version       1.1.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @package       laudirbispo\Route
 */
use laudirbispo\classname\ClassName;

class EasyRouter 
{
	/**
	 * Routes pattern
	 *
	 * @var array
	 */
	protected $routes = [];
	
	protected $baseDir;
	
	public function __construct ($baseDir = null) 
	{
		if (null === $baseDir)
			$baseDir = $_SERVER['DOCUMENT_ROOT'];
		
		$this->baseDir = $baseDir;
	}
	
	/**
	 * Add to Routes
	 *
	 * @param $patterns (mixed) string|array
	 * @param $callback (mixed) string|closure
	 * @return void
	 */
	public function add($patterns, $callback) : void
	{
		if (is_array($patterns)) {
			foreach ($patterns as $pattern) {
				$this->addRoute($pattern, $callback);
			}
		} else if (is_string($patterns)) {
			$this->addRoute($patterns, $callback);
		}
		return;
	}
	
	/**
	 * Add Route
	 */
	private function addRoute($pattern, $callback)
	{
		if (!is_string($pattern)) 
			throw new Exceptions\InvalidRoute('Rota inválida: ' . $pattern);
		
		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
		if (!isset($this->routes[$pattern]))
			$this->routes[$pattern] = $callback;
	}
	
	/**
	 * Check if exists Route pattern
	 *
	 * @param $route (string) 
	 */
	public function hasRoute(string $pattern) : bool
	{
		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
		return isset($this->routes[$pattern]);
	}
	
	/**
	 * Execute the Route
	 *
	 * @param $url (string) - 
	 * 
	 */
	public function execute(string $url = '/') 
    {
		foreach ($this->routes as $pattern => $callback) 
        {	
			if (preg_match($pattern, $url, $params)) {
                if (is_string($callback) && strpos($callback, '::'))  {
                    list($controller, $method) = explode('::', $callback);
					// Check if controllers exists
					$classname = ClassName::path($controller);
					$filename = $this->baseDir .'/'. $classname . '.php';
					if (!is_readable($filename)) {
                        throw new Exceptions\ControllerDoesNotExists(
							sprintf("Controller [%s] não existe ou não foi encontrado.", $controller)
						);
                    }
					if (!method_exists($controller, $method)) {
						throw new Exceptions\MethodDoesNotExists(
							sprintf("Método [%s], não existe no controller [%s].", $method, $controller)
						);
                    }
                    $callback = array(new $controller, $method);
                }
				array_shift($params);
				return call_user_func_array($callback, array_values($params));
			}
		}
		
		throw new Exceptions\RouteNotFound('Nenhuma rota registrada para o endereço atual.');
	}

}
