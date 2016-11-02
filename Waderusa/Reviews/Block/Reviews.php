<?php

class Waderusa_Reviews_Block_Reviews extends Mage_Core_Block_Template
{
	public function getReviews()
	{
		if (!$this->getData('cached_collection')) {
			$collection = Mage::getModel('reviews/reviews')->getCollection()
				->addPresentFilter()
                ->addApprovedFilter(Waderusa_Reviews_Model_Status::STATUS_APPROVED)
                ->setOrder('created_time', 'desc');
            $this->setData('cached_collection', $collection);
		}
		return $this->getData('cached_collection');
	}
	protected function _beforeToHtml()
    {
        $this->helper('reviews/toolbar')->create(
            $this,
            array(
                'orders'        => array('created_time' => $this->__('Created At'), 'user' => $this->__('Added By')),
                'default_order' => 'created_time',
                'dir'           => 'desc',
                'limits'        => '1,24',
            )
        );
        return parent::_beforeToHtml();
    }
}