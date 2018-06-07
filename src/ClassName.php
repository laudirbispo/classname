<?php declare(strict_types=1);
namespace laudirbispo\ClassName;

/**
 * Copyright (c) Laudir Bispo  (laudirbispo@outlook.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     (c) Laudir Bispo  (laudirbispo@outlook.com)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 *
 * @package laudirbispo/classname - This file is part of the Uploader package. 
 */

final class ClassName 
{
	/**
	 * Full name the class
	 * @param object|string $object
	 * @return string
	 */
	public static function full ($object)
	{
		if (is_string($object)) 
			return str_replace('.', '\\', $object);
		
		if (is_object($object)) 
			return trim(get_class($object), '\\');
		
		throw new \InvalidArgumentException(sprintf("Esperado um objeto ou uma string, recebemos %s.", gettype($object)));
	}
	
	public static function namespace ($object)
	{
		if (!is_object($object))
			throw new \InvalidArgumentException(sprintf("s% não é um objeto.", $object));
		
		$parts = explode('\\', self::full($object));
		array_pop($parts);
		return implode('\\', $parts);
	}
	
	/**
	 * Canonical class name of an object, of the form "My.Namespace.MyClass"
	 * @param object|string $object
	 * @return string
	 */
	public static function canonical ($object)
	{
		return str_replace('\\', '.', self::full($object));
	}
	
	public static function short ($object)
	{
		$parts = explode('\\', self::full($object));
    	return end($parts);
	}
}