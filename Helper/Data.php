<?php

namespace Hapex\NewsletterAjax\Helper;

use \Hapex\Core\Helper\DataHelper;

class Data extends DataHelper
{
    public function isEnabled()
    {
        return $this->getConfigFlag('hapex_newsletter_ajax/general/enable');
    }
    
    public function modalAfterEnabled()
    {
        return $this->getConfigFlag('hapex_newsletter_ajax/modal/enable');
    }
    
    public function getFormSelector()
    {
        return $this->getConfigValue('hapex_newsletter_ajax/dom_elements/form_selector');
    }
    
    public function getMessageSelector()
    {
        return $this->getConfigValue('hapex_newsletter_ajax/dom_elements/message_selector');
    }
    
    public function getModalSelector()
    {
        return $this->getConfigValue('hapex_newsletter_ajax/dom_elements/modal_selector');
    }
    
    public function getModalRequireLocation()
    {
        return $this->getConfigValue('hapex_newsletter_ajax/modal/require_location');
    }

}
