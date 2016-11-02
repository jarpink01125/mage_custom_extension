<?php

class Waderusa_Reviews_Model_Mysql4_Reviews_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('reviews/reviews');
    }

    public function addApprovedFilter($status)
    {
        $this->getSelect()->where('main_table.status = ?', $status);
        return $this;
    }

    public function addPresentFilter()
    {
        $this->getSelect()->where('main_table.created_time<=?', now());
        return $this;
    }
}