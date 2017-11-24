<?php
/**
 * SUMOHeavy_OrderGrid
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_OrderGrid
 * @copyright  Copyright (c) SUMO Heavy Industries, LLC
 * @author     Szymon Wlodarski <support@sumoheavy.com>
 */
class SUMOHeavy_OrderGrid_Model_Config_Backend_Cron extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH  = 'crontab/jobs/sumoheavy_ordergrid_reindex_grid_indexer_flat/schedule/cron_expr';
    const CRON_MODEL_PATH   = 'crontab/jobs/sumoheavy_ordergrid_reindex_grid_indexer_flat/run/model';

    const XML_PATH_ENABLED      = 'groups/cron/fields/enabled/value';
    const XML_PATH_CRON_EXPR    = 'groups/cron/fields/cron_expr/value';

    /**
     * Cron settings after save
     *
     * @return self
     */
    protected function _afterSave()
    {
        $enabled = $this->getData(self::XML_PATH_ENABLED);
        $cronExpr = $this->getData(self::XML_PATH_CRON_EXPR);

        $cronExprString = '';
        if ($enabled) {
            $cronExprString = $cronExpr;
        }

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();

            Mage::getModel('core/config_data')
                ->load(self::CRON_MODEL_PATH, 'path')
                ->setValue((string) Mage::getConfig()->getNode(self::CRON_MODEL_PATH))
                ->setPath(self::CRON_MODEL_PATH)
                ->save();
        } catch (Exception $e) {
            Mage::throwException(Mage::helper('sumoheavy_ordergrid')->__('Unable to save the cron expression.'));
        }

        return $this;
    }
}
