<?php

class Waderusa_Reviews_Helper_Toolbar extends Mage_Core_Block_Abstract
{
    public function create($block, $params = array())
    {
        /* prepare global params */
        $this->setToolbarParentBlock($block);
        $this->setToolbarParams($params);

        $toolbar = $this->getToolbarBlock();
        $toolbar->setPost($this);
        $toolbar->setAvailableOrders($params['orders']);
        $toolbar->setDefaultOrder($params['default_order']);
        $toolbar->setDefaultDirection('desc');
        $toolbar->setCollection($block->getReviews());
        $toolbar->disableViewSwitcher();
        $block->setChild('reviews_list_toolbar', $toolbar);
    }

    public function getAvailLimits()
    {
        $params = $this->getToolbarParams();

        $limits = array();
        if (isset($params['limits'])) {
            foreach (explode(',', $params['limits']) as $limit) {
                $limit = (int)trim($limit);
                if (!$limit) {
                    continue;
                }
                $limits[$limit] = $limit;
            }
        }
        return $limits;
    }

    public function getToolbarBlock()
    {
        $block = $this->getToolbarParentBlock()->getLayout()->getBlock('reviews_list_toolbar');
        if (!$block) {
            return $this->getToolbarParentBlock()->getLayout()->createBlock('reviews/toolbar', microtime());
        }
        return $block;
    }
}