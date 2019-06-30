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
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/modal/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getFormSelector()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/dom-elements/form-selector',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getMessageSelector()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/dom-elements/message-selector',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getModalSelector()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/dom-elements/modal-selector',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getModalRequireLocation()
    {
        return $this->scopeConfig->getValue('hapex-newsletter-ajax/modal/require-location',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
