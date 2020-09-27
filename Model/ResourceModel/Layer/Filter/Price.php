<?php

namespace Yirreo\RemoveSearch\Model\ResourceModel\Layer\Filter;

class Price extends \Magento\Catalog\Model\ResourceModel\Layer\Filter\Price
{

    protected function _getSelect()
    {
        $select =  parent::_getSelect();
        $this->removeStaging($select);
        return $select;
    }

    /**
     * @param \Magento\Framework\DB\Select $select
     * @throws \Zend_Db_Select_Exception
     */
    protected function removeStaging(\Magento\Framework\DB\Select $select): void
    {
        $wherePart = $select->getPart(\Magento\Framework\DB\Select::WHERE);
        $delVals = ['AND (e.created_in <= 1)', 'AND (e.updated_in > 1)'];
        foreach ($delVals as $delVal) {
            if (($key = array_search($delVal, $wherePart)) !== false) {
                unset($wherePart[$key]);
            }
        }

        $select->setPart(\Magento\Framework\DB\Select::WHERE, $wherePart);
    }
}
