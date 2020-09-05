<?php

namespace Hapex\NewsletterAjax\Helper;

use Hapex\Core\Helper\DataHelper;

class Data extends DataHelper
{
    protected const XML_PATH_CONFIG_ENABLED = "hapex_newsletter_ajax/general/enable";
    protected const XML_PATH_CONFIG_MODAL_ENABLED = "hapex_newsletter_ajax/modal/enable";
    protected const XML_PATH_CONFIG_SELECTOR_FORM = "hapex_newsletter_ajax/dom_elements/form_selector";
    protected const XML_PATH_CONFIG_SELECTOR_MESSAGE = "hapex_newsletter_ajax/dom_elements/message_selector";
    protected const XML_PATH_CONFIG_SELECTOR_MODAL = "hapex_newsletter_ajax/dom_elements/modal_selector";
    protected const XML_PATH_CONFIG_REQUIRE_LOCATION = "hapex_newsletter_ajax/modal/require_location";

    public function isEnabled()
    {
        return $this->getConfigFlag(self::XML_PATH_CONFIG_ENABLED);
    }

    public function modalAfterEnabled()
    {
        return $this->getConfigFlag(self::XML_PATH_CONFIG_MODAL_ENABLED);
    }

    public function getFormSelector()
    {
        return $this->getConfigValue(self::XML_PATH_CONFIG_SELECTOR_FORM);
    }

    public function getMessageSelector()
    {
        return $this->getConfigValue(self::XML_PATH_CONFIG_SELECTOR_MESSAGE);
    }

    public function getModalSelector()
    {
        return $this->getConfigValue(self::XML_PATH_CONFIG_SELECTOR_MODAL);
    }

    public function getModalRequireLocation()
    {
        return $this->getConfigValue(self::XML_PATH_CONFIG_REQUIRE_LOCATION);
    }
}
