<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Test_Model_Cron extends EcomDev_PHPUnit_Test_Case
{
    public function testReindexGridIndexerFlat()
    {
        $indexProcessMock = $this->getModelMockBuilder('index/process')
           ->setMethods(array('getId', 'getStatus', 'reindexAll'))
           ->getMock();

        $indexProcessMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $indexProcessMock->expects($this->once())
            ->method('getStatus')
            ->willReturn(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);

        $indexProcessMock->expects($this->once())
            ->method('reindexAll');

        $indexProcessCollectionnMock = $this->getResourceModelMockBuilder('index/process_collection')
           ->setMethods(array('getFirstItem'))
           ->getMock();
        $indexProcessCollectionnMock->expects($this->once())
            ->method('getFirstItem')
            ->willReturn($indexProcessMock);

        $this->replaceByMock('resource_model', 'index/process_collection', $indexProcessCollectionnMock);

        Mage::getModel('sumoheavy_ordergrid/cron')->reindexGridIndexerFlat();
    }
}
