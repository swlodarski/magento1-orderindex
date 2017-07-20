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
class SUMOHeavy_OrderGrid_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_logFileName = 'sumoheavy_ordergrid.log';

    public function updateSalesFlatOrderGrid()
    {
        $this->_log('Starting updateSalesFlatOrderGrid');

        $dateThreshold = Mage::getSingleton('core/date')
            ->gmtDate(null, Mage::getSingleton('core/date')->date(null, '-25 minutes'));

        $resourceModel = Mage::getResourceModel('sales/order');
        $subSelect = $resourceModel->getReadConnection()
            ->select()
            ->from($resourceModel->getGridTable(), 'entity_id');

        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToSelect('entity_id')
            ->addFieldToFilter(array(
                'updated_at',
                'entity_id',
            ),
                array(
                    array('gt' => $dateThreshold),
                    array('nin' => $subSelect),
                ));

        $orderIds = $resourceModel->getReadConnection()->fetchCol($collection->getSelect());

        if (!empty($orderIds)) {
            $resourceModel->updateGridRecords($orderIds);
            $this->_log('Orders with IDs: ' . implode(', ', $orderIds) . ' were updated.');
        }

        $this->_log('Finished updateSalesFlatOrderGrid');

        return $this;
    }

    protected function _log($message)
    {
        Mage::log($message, null, $this->_logFileName);
    }
}
