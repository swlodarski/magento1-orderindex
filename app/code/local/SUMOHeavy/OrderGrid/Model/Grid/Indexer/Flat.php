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
class SUMOHeavy_OrderGrid_Model_Grid_Indexer_Flat extends Mage_Index_Model_Indexer_Abstract
{
    /**
     * Data key for matching result to be saved in
     */
    const EVENT_MATCH_RESULT_KEY = 'sumoheavy_ordergrid_match_result';

    /**
     * @var array
     */
    protected $_matchedEntities = array('sumoheavy_ordergrid_index' => array(Mage_Index_Model_Event::TYPE_SAVE));

    /**
     * Retrieve Indexer name
     *
     * @return string
     */
    public function getName()
    {
        return Mage::helper('sumoheavy_ordergrid')->__('SUMOHeavy OrderGrid indexer');
    }

    /**
     * Retrieve Indexer description
     *
     * @return string
     */
    public function getDescription()
    {
        return Mage::helper('sumoheavy_ordergrid')->__('Update sales_flat_order_grid table');
    }

    /**
     * Register indexer required data inside event object
     *
     * @param   Mage_Index_Model_Event $event
     */
    protected function _registerEvent(Mage_Index_Model_Event $event)
    {
        $event->addNewData(self::EVENT_MATCH_RESULT_KEY, true);
        if ($event->getType() == Mage_Index_Model_Event::TYPE_SAVE) {
            $event->addNewData('sumoheavy_ordergrid_index_update_grid', true);
        }
    }

    /**
     * Process event based on event state data
     *
     * @param   Mage_Index_Model_Event $event
     */
    protected function _processEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        if (!empty($data['sumoheavy_ordergrid_index_update_grid'])) {
            $this->reindexAll();
        }
    }

    /**
     * Rebuild all index data
     */
    public function reindexAll()
    {
        Mage::helper('sumoheavy_ordergrid')->updateSalesFlatOrderGrid();
    }
}
