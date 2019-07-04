<?php
/**
 *
 */
namespace Hapex\NewsletterAjax\Plugin\Subscriber;
use Magento\Customer\Api\AccountManagementInterface as CustomerAccountManagement;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Newsletter\Model\SubscriberFactory;
use Hapex\NewsletterAjax\Helper\Data;
/**
 * Class Ajax
 */
class Ajax extends \Magento\Newsletter\Controller\Subscriber\NewAction {

    protected $customerAccountManagement;
    protected $resultJsonFactory;
    protected $dataHelper;

    public function __construct(Context $context, SubscriberFactory $subscriberFactory, Session $customerSession, StoreManagerInterface $storeManager, CustomerUrl $customerUrl, CustomerAccountManagement $customerAccountManagement, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, Data $dataHelper) {
        $this->customerAccountManagement = $customerAccountManagement;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $subscriberFactory, $customerSession, $storeManager, $customerUrl, $customerAccountManagement);
        $this->dataHelper = $dataHelper;
    }

    public function aroundExecute($subject, $procede) {
        if ($this->dataHelper->isEnabled())
        {
            if ($this->isValidRequest()) {
                $email = $this->getEmail();
                try {
                    if ($this->isSubscriber($email)) {
                        return $this->generateResponse("ERROR", "This email address is already subscribed.");
                    } else {
                        $status = $this->subscribeEmail($email);
                        if ($status == \Magento\Newsletter\Model\Subscriber::STATUS_NOT_ACTIVE) {
                            return $this->generateResponse("OK", "The confirmation request has been sent.");
                        } else {
                            return $this->generateResponse("OK", "Thank you for your subscription.");
                        }
                    }
                }
                catch(\Magento\Framework\Exception\LocalizedException $e) {
                    return $this->generateResponse("ERROR", "There was a problem with the subscription: $e->getMessage()");
                }
                catch(\Exception $e) {
                    return $this->generateResponse("ERROR", "Something went wrong with the subscription.");
                }
            }
        }
        else
        {
            parent::execute($subject,$procede);
        }
    }
    
    
    private function generateResponse($status, $message)
    {
        $response = ['status' => "$status", 'msg' => __("$message") ];
        return $this->resultJsonFactory->create()->setData($response);
    }
    
    private function getEmail()
    {
        return (string)$this->getRequest()->getPost('email');
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
