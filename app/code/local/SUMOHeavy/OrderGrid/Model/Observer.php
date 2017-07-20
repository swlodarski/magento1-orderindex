<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) 2017 SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 * @author     Daniel Szubart <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Model_Observer
{
    public function onSalesOrderSaveAfter(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if (!Mage::app()->getStore()->isAdmin()) {
            $order->setForceUpdateGridRecords(true);
        }

        $index = Mage::getModel('index/process')
            ->getCollection()
            ->addFieldToFilter('indexer_code','sumoheavy_ordergrid')
            ->getFirstItem();

        if ($index && $index->getId()) {
            $eventResource = Mage::getResourceSingleton('index/event');
            $unprocessedEvents = $eventResource->getUnprocessedEvents($index);
            if (empty($unprocessedEvents)) {
                Mage::getModel('index/indexer')->logEvent(
                    $order,
                    'sumoheavy_ordergrid_index',
                    Mage_Index_Model_Event::TYPE_SAVE
                );
            }
        }
        
        return $this;
    }
}
