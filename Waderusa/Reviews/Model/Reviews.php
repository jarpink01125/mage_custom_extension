<?php

class Waderusa_Reviews_Model_Reviews extends Mage_Core_Model_Abstract
{
	public function _construct()
    {
        parent::_construct();
        $this->_init('reviews/reviews');
    }
	
	public function getComment() {
        $content = $this->getData('comment');
        $processor = Mage::getModel('core/email_template_filter');
        $content = $processor->filter($content);
        return $content;
    }
}