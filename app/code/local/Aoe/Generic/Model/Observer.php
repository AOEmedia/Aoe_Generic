<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_Model_Observer
{
    /**
     * Register SPL autoload function
     */
    public function addNamespaceAutoloader()
    {
        spl_autoload_register(function($class) {
            if (strrpos($class, '\\') !== false) {
                // namespaced class name
                $class = str_replace('\\', '_', ltrim($class, '\\'));
            }

            return @Varien_Autoload::instance()->autoload($class);
        }, true, true);
    }
}
