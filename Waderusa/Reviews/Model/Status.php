<?php

class Waderusa_Reviews_Model_Status extends Varien_Object
{
    const STATUS_PENDING		= 1;
    const STATUS_APPROVED		= 2;
    const STATUS_NOT_APPROVED   = 3;

    public function addPedingFilterToCollection($collection)
    {
        $collection->addPedingFilter(array('in' => $this->getPedingStatusIds()));
        return $this;
    }

	public function getPedingStatusIds()
    {
        return array(self::STATUS_PENDING);
    }

    public function getApprovedStatusIds()
    {
        return array(self::STATUS_APPROVED);
    }

    public function getNotApprovedStatusIds()
    {
        return array(self::STATUS_NOT_APPROVED);
    }

    static public function getOptionArray()
    {
        return array(
            self::STATUS_PENDING  => Mage::helper('reviews')->__('Pending'),
            self::STATUS_APPROVED => Mage::helper('reviews')->__('Approved'),
            self::STATUS_NOT_APPROVED   => Mage::helper('reviews')->__('Not Approved')
        );
    }
}