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
	public static function full($object)
	{
		if (is_string($object)) 
			return str_replace('.', '\\', $object);
		
		if (is_object($object)) 
			return trim(get_class($object), '\\');
		
		throw new \InvalidArgumentException(
			sprintf("[%s]: Esperavamos um objeto ou uma string, recebemos um(a) %s.", __CLASS__, gettype()($object))
		);
	}
	
	public static function namespace($object)
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
	public static function canonical($object) 
	{
        if (null === $object || empty($object)) {
           throw new \InvalidArgumentException(
                sprintf("[%s]: Esperavamos um objeto ou uma string, recebemos um(a) %s.", __CLASS__, gettype()($object))
            ); 
        }
		return str_replace('\\', '.', self::full($object));
	}
	
	public static function short($object) 
	{
        if (null === $object || empty($object)) {
           throw new \InvalidArgumentException(
                sprintf("[%s]: Esperavamos um objeto ou uma string, recebemos um(a) %s.", __CLASS__, gettype()($object))
            ); 
        }
        
		$parts = explode('\\', self::full($object));
    	return end($parts);
	}
    
    /**
	 * Path to class file "namespace1/namespace2/MyClass"
	 * @param object|string $object
	 * @return string
	 */
    public static function path($object) 
    {
        if (null === $object || empty($object)) {
           throw new \InvalidArgumentException(
                sprintf("[%s]: Esperavamos um objeto ou uma string, recebemos um(a) %s.", __CLASS__, gettype()($object))
            ); 
        }
        return str_replace('\\', '/', self::full($object));
    }
    
    /**
	 * Retrieves the name of the parent class for object or class
	 * @param object|string $object
	 * @return string|null
	 */
    public static function getParent($object, string $returns = 'full') 
    {
        if (null === $object || empty($object)) {
           throw new \InvalidArgumentException(
                sprintf("[%s]: Esperavamos um objeto ou uma string, recebemos um(a) %s.", __CLASS__, gettype()($object))
            ); 
        }
        $parent = trim(get_parent_class($object), '\\');
        if ($returns === 'full') {
            return self::full($parent);
        } else if ($returns === 'short') {
            return self::short($parent);
        } else if ($returns === 'canonical') {
            return self::canonical($parent);
        } else if ($returns === 'namespace') {
            return self::namespace($object);
        } else {
            return $parent;
        }
    }
    
}
