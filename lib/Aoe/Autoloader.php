<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Autoloader extends Varien_Autoload
{
    /**
     * Register SPL autoload function
     */
    public static function register()
    {
        spl_autoload_unregister(array(Varien_Autoload::instance(), 'autoload'));

        self::$_instance = self::_objectToObject(Varien_Autoload::instance(), get_called_class());

        spl_autoload_register(array(static::instance(), 'autoload'));
    }

    /**
     * Type cast from one PHP class to another
     *
     * @param object $instance
     * @param string $className
     * @return object
     */
    protected static function _objectToObject($instance, $className)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }

    /**
     * Load class source code
     * Add namespaced class name handing
     *
     * @param string $class
     * @return mixed
     */
    public function autoload($class)
    {
        if (strrpos($class, '\\') !== false) {
            // namespaced class name
            $class = str_replace('\\', '_', ltrim($class, '\\'));
        }

        return parent::autoload($class);
    }
}
