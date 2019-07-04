<?php

namespace Hapex\NewsletterAjax\Helper;

use \Hapex\Core\Helper\DataHelper;

class Data extends DataHelper
{
    public function isEnabled()
    {
        return $this->getConfigFlag('hapex-newsletter-ajax/general/enable');
    }
    
    public function modalAfterEnabled()
    {
        return $this->getConfigFlag('hapex-newsletter-ajax/modal/enable');
    }
    
    public function getFormSelector()
    {
        return $this->getConfigValue('hapex-newsletter-ajax/dom-elements/form-selector');
    }
    
    public function getMessageSelector()
    {
        return $this->getConfigValue('hapex-newsletter-ajax/dom-elements/message-selector');
    }
    
    public function getModalSelector()
    {
        return $this->getConfigValue('hapex-newsletter-ajax/dom-elements/modal-selector');
    }
    
    public function getModalRequireLocation()
    {
        return $this->getConfigValue('hapex-newsletter-ajax/modal/require-location');
    }

}
