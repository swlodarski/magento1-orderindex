<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Model_Cron
{
    /**
     * Force reindex  SUMOHeavy OrderGrid indexer
     *
     * @return $this
     */
    public function reindexGridIndexerFlat()
    {
        $indexer = Mage::getModel('index/process')->getCollection()
            ->addFieldToFilter('indexer_code', 'sumoheavy_ordergrid')
            ->getFirstItem();
        if ($indexer && $indexer->getId() &&
            ($indexer->getStatus() == Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX
                || $indexer->getUnprocessedEventsCollection()->count())) {
            $indexer->reindexAll();
        }

        return $this;
    }
}
