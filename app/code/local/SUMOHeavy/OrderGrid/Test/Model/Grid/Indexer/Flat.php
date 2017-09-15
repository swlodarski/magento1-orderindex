<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Test_Model_Grid_Indexer_Flat extends EcomDev_PHPUnit_Test_Case
{
    public function testReindexAll()
    {
        $helperMock = $this->getHelperMockBuilder('sumoheavy_ordergrid')
           ->setMethods(array('updateSalesFlatOrderGrid'))
           ->getMock();

        $helperMock->expects($this->once())
            ->method('updateSalesFlatOrderGrid')
            ->willReturn(array());

        $this->replaceByMock('helper', 'sumoheavy_ordergrid', $helperMock);

        Mage::getModel('sumoheavy_ordergrid/grid_indexer_flat')->reindexAll();
    }
}
