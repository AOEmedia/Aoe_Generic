<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_PHPUnitTest_Helper_Mage extends Aoe_Generic_Helper_Mage
{
    /**
     * Add EcomDev_PHPUnit support.
     * EcomDev_PHPUnit_Model_Config has possibility to replace model with mock
     *
     * @param string $type
     * @param string $modelClass
     * @return object|false
     */
    protected function _getReplacedInstance($type, $modelClass)
    {
        $config = Mage::getConfig();
        $reflectionClass = new ReflectionClass(get_class($config));

        if ($reflectionClass->hasProperty("_replaceInstanceCreation")) {
            $property = $reflectionClass->getProperty("_replaceInstanceCreation");
            $property->setAccessible(true);

            $replaceInstanceCreation = $property->getValue($config);

            if (isset($replaceInstanceCreation[$type][$modelClass])) {
                return $replaceInstanceCreation[$type][$modelClass];
            }
        }

        return false;
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
        $replacedInstance = $this->_getReplacedInstance('model', $modelClass);
        if ($replacedInstance) {
            return $replacedInstance;
        } else {
            return parent::getModel($modelClass, $constructorArguments);
        }
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
        $replacedInstance = $this->_getReplacedInstance('resource_model', $modelClass);
        if ($replacedInstance) {
            return $replacedInstance;
        } else {
            return parent::getResourceModel($modelClass, $constructorArguments);
        }
    }
}
