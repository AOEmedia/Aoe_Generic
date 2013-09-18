<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_Test_PHPUnitTest_Helper_MageTest extends EcomDev_PHPUnit_Test_Case
{
    /**@+
     * Test aliases
     *
     * @var string
     */
    const MODEL_ALIAS          = 'model/mock';
    const RESOURCE_MODEL_ALIAS = 'model/resource_mock';
    /**@-*/

    /**
     * @return Aoe_Generic_PHPUnitTest_Helper_Mage
     */
    public function testDynamicHelperRewrite()
    {
        $helper = Mage::helper('aoe_generic/mage');
        $this->assertInstanceOf('Aoe_Generic_PHPUnitTest_Helper_Mage', $helper);

        return $helper;
    }

    /**
     * @depends testDynamicHelperRewrite
     *
     * @param Aoe_Generic_PHPUnitTest_Helper_Mage $helper
     */
    public function testGetModelReplacedByMock(Aoe_Generic_PHPUnitTest_Helper_Mage $helper)
    {
        $mock = $this->getMock('stdClass');
        $this->replaceByMock('model', self::MODEL_ALIAS, $mock);
        $this->assertSame($mock, $helper->getModel(self::MODEL_ALIAS));
    }

    /**
     * @depends testDynamicHelperRewrite
     *
     * @param Aoe_Generic_PHPUnitTest_Helper_Mage $helper
     */
    public function testGetResourceModelReplacedByMock(Aoe_Generic_PHPUnitTest_Helper_Mage $helper)
    {
        $mock = $this->getMock('stdClass');
        $this->replaceByMock('resource_model', self::RESOURCE_MODEL_ALIAS, $mock);
        $this->assertSame($mock, $helper->getResourceModel(self::RESOURCE_MODEL_ALIAS));
    }
}
