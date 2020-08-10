<?php

namespace Hapex\NewsletterAjax\Controller\Subscriber;

use Hapex\Core\Helper\LogHelper;
use Magento\Customer\Model\Session;
use Hapex\NewsletterAjax\Helper\Data;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Newsletter\Model\SubscriberFactory;
use \Magento\Newsletter\Controller\Subscriber\NewAction;
use Magento\Customer\Api\AccountManagementInterface as CustomerAccountManagement;
use Magento\Framework\Controller\Result\JsonFactory;

class Ajax extends NewAction
{
    protected $customerManagement;
    protected $resultJsonFactory;
    protected $helperData;
    protected $helperLog;

    public function __construct(
        Context $context,
        SubscriberFactory $subscriberFactory,
        Session $customerSession,
        StoreManagerInterface $storeManager,
        CustomerUrl $customerUrl,
        CustomerAccountManagement $customerManagement,
        JsonFactory $resultJsonFactory,
        Data $helperData,
        LogHelper $helperLog
    ) {
        $this->customerManagement = $customerManagement;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $subscriberFactory, $customerSession, $storeManager, $customerUrl, $customerManagement);
        $this->helperData = $helperData;
        $this->helperLog = $helperLog;
    }

    public function aroundExecute($subject, $procede)
    {
        switch ($this->helperData->isEnabled()) {
            case true:
                $response = "";
                switch ($this->isValidRequest()) {
                    case true:
                        $email = $this->getEmail();
                        try {
                            switch ($this->isSubscriber($email)) {
                                case true:
                                    $response = $this->generateResponse("ERROR", "This email address is already subscribed.");
                                    break;
                                default:
                                    $status = $this->subscribeEmail($email);
                                    $response = ($status == \Magento\Newsletter\Model\Subscriber::STATUS_NOT_ACTIVE) ? $this->generateResponse("OK", "The confirmation request has been sent.") : $this->generateResponse("OK", "Thank you for your subscription.");
                                    break;
                            }
                        } catch (\Magento\Framework\Exception\LocalizedException $e) {
                            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
                            $response = $this->generateResponse("ERROR", "There was a problem with the subscription: " . $e->getMessage());
                        } catch (\Exception $e) {
                            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
                            $response = $this->generateResponse("ERROR", "Something went wrong with the subscription.");
                        } finally {
                            return $response;
                        }
                        break;
                }
                break;
            default:
                $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl());
                break;
        }
    }

    private function generateResponse($status, $message)
    {
        $response = ['status' => "$status", 'msg' => __("$message")];
        return $this->resultJsonFactory->create()->setData($response);
    }

    private function getEmail()
    {
        return (string) $this->getRequest()->getPost('email');
    }

    private function isSubscriber($email)
    {
        $this->validateEmailFormat($email);
        $this->validateGuestSubscription();
        $this->validateEmailAvailable($email);
        $subscriber = $this->_subscriberFactory->create()->loadByEmail($email);
        return ($subscriber->getId() && $subscriber->getSubscriberStatus() == \Magento\Newsletter\Model\Subscriber::STATUS_SUBSCRIBED);
    }

    private function isValidRequest()
    {
        return $this->getRequest()->isPost() && $this->getRequest()->getPost('email');
    }

    private function subscribeEmail($email)
    {
        return $this->_subscriberFactory->create()->subscribe($email);
    }
}
