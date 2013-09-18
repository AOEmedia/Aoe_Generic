<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_Test_Helper_MageTest extends EcomDev_PHPUnit_Test_Case
{
    /**@+
     * Test aliases
     *
     * @var string
     */
    const CLASS_NAME                            = 'Mage_Core_Exception';
    const GET_SINGLETON_MODEL_EXISTING          = 'get/singleton';
    const MODEL_NEW                             = 'core/store';
    const MODEL_NEW_CLASS                       = 'Mage_Core_Model_Store';
    const GET_RESOURCE_SINGLETON_MODEL_EXISTING = 'get/resource_singleton';
    const RESOURCE_MODEL_NEW                    = 'core/store';
    const RESOURCE_MODEL_NEW_CLASS              = 'Mage_Core_Model_Resource_Store';

    const HAS_SINGLETON_MODEL          = 'core/store';
    const HAS_RESOURCE_SINGLETON_MODEL = 'core/store';
    /**@-*/

    /**
     * @var Aoe_Generic_Helper_Mage
     */
    protected $_helper;

    protected function setUp()
    {
        $this->_helper = Mage::helper('aoe_generic/mage');
    }

    protected function tearDown()
    {
        $this->_helper = null;
        Mage::unregister('_singleton/' . self::HAS_SINGLETON_MODEL);
        Mage::unregister('_resource_singleton/' . self::HAS_RESOURCE_SINGLETON_MODEL);
    }

    public function testGetClassInstance()
    {
        $code = rand();
        $message = "Message " . $code;
        $previousException = new Exception();
        /** @var Mage_Core_Exception $exception */
        $exception = $this->_helper->getClassInstance(self::CLASS_NAME, array($message, $code, $previousException));

        $this->assertInstanceOf(self::CLASS_NAME, $exception);
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($previousException, $exception->getPrevious());
    }

    public function testGetModel()
    {
        $this->assertInstanceOf(self::MODEL_NEW_CLASS, $this->_helper->getModel(self::MODEL_NEW));
    }

    public function testGetSingletonExisting()
    {
        $registryKey = '_singleton/' . self::GET_SINGLETON_MODEL_EXISTING;
        Mage::register($registryKey, self::GET_SINGLETON_MODEL_EXISTING);
        $this->assertSame(self::GET_SINGLETON_MODEL_EXISTING,
            $this->_helper->getSingleton(self::GET_SINGLETON_MODEL_EXISTING)
        );
        $this->assertSame(self::GET_SINGLETON_MODEL_EXISTING, Mage::registry($registryKey));
    }

    public function testGetResourceModel()
    {
        $this->assertInstanceOf(self::RESOURCE_MODEL_NEW_CLASS,
            $this->_helper->getResourceModel(self::RESOURCE_MODEL_NEW)
        );
    }

    public function testGetSingletonNew()
    {
        $registryKey = '_singleton/' . self::MODEL_NEW;
        $this->assertEmpty(Mage::registry($registryKey));

        $this->assertInstanceOf(self::MODEL_NEW_CLASS, $this->_helper->getSingleton(self::MODEL_NEW));
        $this->assertNotEmpty(Mage::registry($registryKey));
    }

    public function testGetResourceSingletonExisting()
    {
        $registryKey = '_resource_singleton/' . self::GET_RESOURCE_SINGLETON_MODEL_EXISTING;
        Mage::register($registryKey, self::GET_RESOURCE_SINGLETON_MODEL_EXISTING);
        $this->assertSame(self::GET_RESOURCE_SINGLETON_MODEL_EXISTING,
            $this->_helper->getResourceSingleton(self::GET_RESOURCE_SINGLETON_MODEL_EXISTING)
        );
        $this->assertSame(self::GET_RESOURCE_SINGLETON_MODEL_EXISTING, Mage::registry($registryKey));
    }

    public function testGetResourceSingletonNew()
    {
        $registryKey = '_resource_singleton/' . self::RESOURCE_MODEL_NEW;
        $this->assertEmpty(Mage::registry($registryKey));

        $this->assertInstanceOf(self::RESOURCE_MODEL_NEW_CLASS,
            $this->_helper->getResourceSingleton(self::RESOURCE_MODEL_NEW)
        );
        $this->assertNotEmpty(Mage::registry($registryKey));
    }

    public function testHasSingleton()
    {
        $this->assertFalse($this->_helper->hasSingleton(self::HAS_SINGLETON_MODEL));
        Mage::getSingleton(self::HAS_SINGLETON_MODEL);
        $this->assertTrue($this->_helper->hasSingleton(self::HAS_SINGLETON_MODEL));
    }

    public function testHasResourceSingleton()
    {
        $this->assertFalse($this->_helper->hasResourceSingleton(self::HAS_RESOURCE_SINGLETON_MODEL));
        Mage::getResourceSingleton(self::HAS_RESOURCE_SINGLETON_MODEL);
        $this->assertTrue($this->_helper->hasResourceSingleton(self::HAS_RESOURCE_SINGLETON_MODEL));
    }
}
