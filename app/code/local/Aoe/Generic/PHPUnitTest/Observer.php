<?php
/**
 * @author Dmytro Zavalkin <dmytro.zavalkin@aoemedia.de>
 */

class Aoe_Generic_PHPUnitTest_Observer
{
    public function replaceMageHelper()
    {
        Mage::register('_helper/aoe_generic/mage', new Aoe_Generic_PHPUnitTest_Helper_Mage());
    }
}
