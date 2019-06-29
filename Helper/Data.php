<?php

namespace Hapex\NewsletterAjax\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function isEnabled()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/general/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function modalAfterEnabled()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/general/modal-after-enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
