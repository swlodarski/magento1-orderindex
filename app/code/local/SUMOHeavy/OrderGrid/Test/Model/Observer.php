<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    public function testOnSalesOrderSaveAfter()
    {
        $orderMock = $this->getModelMockBuilder('sales/order')
           ->getMock();

        $observer = new Varien_Event_Observer();
        $observer->setEvent(new Varien_Event(array('order' => $orderMock)));

        $indexProcessCollectionnMock = $this->getResourceModelMockBuilder('index/process_collection')
           ->setMethods(array('getFirstItem'))
           ->getMock();
        $indexProcessCollectionnMock->expects($this->once())
            ->method('getFirstItem')
            ->willReturn(new Varien_Object(array('id' => 1)));

        $this->replaceByMock('resource_model', 'index/process_collection', $indexProcessCollectionnMock);

        $indexEventMock = $this->getResourceModelMockBuilder('index/event')
           ->setMethods(array('getUnprocessedEvents'))
           ->getMock();
        $indexEventMock->expects($this->once())
            ->method('getUnprocessedEvents')
            ->willReturn(array());

        $this->replaceByMock('resource_model', 'index/event', $indexEventMock);

        $indexIndexerMock = $this->getModelMockBuilder('index/indexer')
           ->setMethods(array('logEvent'))
           ->getMock();
        $indexIndexerMock->expects($this->once())
            ->method('logEvent')
            ->with(
                $orderMock,
                'sumoheavy_ordergrid_index',
                Mage_Index_Model_Event::TYPE_SAVE
            )
            ->willReturn(null);

        $this->replaceByMock('model', 'index/indexer', $indexIndexerMock);

        Mage::getModel('sumoheavy_ordergrid/observer')->onSalesOrderSaveAfter($observer);
    }
}
