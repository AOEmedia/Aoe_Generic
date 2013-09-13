<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_Helper_Mage
{
    /**
     * Get model class instance
     *
     * @param string $className
     * @param array $constructorArguments
     * @return Mage_Core_Model_Abstract|false
     */
    public function getClassInstance($className, array $constructorArguments = array())
    {
        if (class_exists($className)) {
            Varien_Profiler::start('CORE::create_object_of::' . $className);
            if (empty($constructorArguments)) {
                return new $className();
            } else {
                $reflectionCLass = new ReflectionClass($className);
                $object          = $reflectionCLass->newInstanceArgs($constructorArguments);
            }
            Varien_Profiler::stop('CORE::create_object_of::' . $className);

            return $object;
        } else {
            return false;
        }
    }

    /**
     * Retrieve model object
     *
     * @param  string $modelClass
     * @param  array $constructorArguments
     * @return object|false
     */
    public function getModel($modelClass = '', array $constructorArguments = array())
    {
        return $this->getClassInstance(Mage::getConfig()->getModelClassName($modelClass), $constructorArguments);
    }

    /**
     * Retrieve model object singleton
     *
     * @param  string $modelClass
     * @param  array $constructorArguments
     * @return object|false
     */
    public function getSingleton($modelClass = '', array $constructorArguments = array())
    {
        $registryKey = '_singleton/' . $modelClass;
        if (!Mage::registry($registryKey)) {
            Mage::register($registryKey, $this->getModel($modelClass, $constructorArguments));
        }

        return Mage::registry($registryKey);
    }

    /**
     * Retrieve object of resource model
     *
     * @param  string $modelClass
     * @param  array $constructorArguments
     * @return object|false
     */
    public function getResourceModel($modelClass, $constructorArguments = array())
    {
        return $this->getClassInstance(Mage::getConfig()->getResourceModelClassName($modelClass),
            $constructorArguments
        );
    }

    /**
     * Retrieve resource model object singleton
     *
     * @param  string $modelClass
     * @param  array $constructorArguments
     * @return object|false
     */
    public function getResourceSingleton($modelClass = '', array $constructorArguments = array())
    {
        $registryKey = '_resource_singleton/' . $modelClass;
        if (!Mage::registry($registryKey)) {
            Mage::register($registryKey, $this->getResourceModel($modelClass, $constructorArguments));
        }

        return Mage::registry($registryKey);
    }

    /**
     * Check whether singleton already exists
     *
     * @param  string $modelClass
     * @return bool
     */
    public function hasSingleton($modelClass)
    {
        return (bool) Mage::registry('_singleton/' . $modelClass);
    }

    /**
     * Check whether resource singleton already exists
     *
     * @param  string $modelClass
     * @return bool
     */
    public function hasResourceSingleton($modelClass)
    {
        return (bool) Mage::registry('_resource_singleton/' . $modelClass);
    }
}
