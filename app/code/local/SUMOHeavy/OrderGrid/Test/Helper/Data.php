<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    public function testUpdateSalesFlatOrderGrid()
    {
        $helper = Mage::helper('sumoheavy_ordergrid');

        $orderIds = array(1, 2, 3);

        $orderCollectionMock = $this->getResourceModelMockBuilder('sales/order_collection')
           ->setMethods(array('getAllIds'))
           ->getMock();
        $orderCollectionMock->expects($this->once())
            ->method('getAllIds')
            ->willReturn($orderIds);

        $this->replaceByMock('resource_model', 'sales/order_collection', $orderCollectionMock);

        $orderResourcenMock = $this->getResourceModelMockBuilder('sales/order')
           ->setMethods(array('updateGridRecords'))
           ->getMock();
        $orderResourcenMock->expects($this->once())
            ->method('updateGridRecords')
            ->with($orderIds)
            ->willReturn(null);

        $this->replaceByMock('resource_model', 'sales/order', $orderResourcenMock);

        $helper->updateSalesFlatOrderGrid();
    }
}
