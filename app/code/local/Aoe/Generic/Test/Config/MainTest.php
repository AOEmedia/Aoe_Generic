<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_Test_Config_MainTest extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testModuleBasics()
    {
        $this->assertModuleCodePool('local');
    }

    public function testClassAliases()
    {
        $this->assertHelperAlias('aoe_generic/mage', 'Aoe_Generic_Helper_Mage');
        $this->assertModelAlias('aoe_generic/observer', 'Aoe_Generic_Model_Observer');
    }
}
