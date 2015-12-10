<?php
/**
 * Class Alaa_FacebookConnect_IndexController
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @return Mage_Core_Controller_Varien_Action
     * @throws Exception
     */
    public function callbackLoginUrlAction()
    {
        $this->getFacebookSession()->setData(
            Alaa_FacebookConnect_Model_Session::FBRLH_STATE,
            $this->getRequest()->getParam('state')
        );

        $this->getFacebookSession()->setState();
        $fb = $this->getFacebook();
        $helper = $fb->getRedirectLoginHelper();

        $accessToken = null;
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $this->log($e->getMessage());
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            $this->log($e->getMessage());
        }

        if (!isset($accessToken)) {
            throw new \Exception('Access Token is not set.');
        }
        $this->getFacebookSession()->setAccessToken($accessToken);

        $data = $this->getPublicProfile()->getData(
            $fb,
            $accessToken,
            $this->getHelper()->getUserProperties()
        );

        // if there is no email in the data
        if (!isset($data['email'])) {
            $this->getCoreSession()->addError('We are sorry, but your facebook email is not valid');
            return $this->_redirect('*/*/error');
        }

        $user = $this->getUser()->loadByEmail($data['email']);

        if ($user->getId()) {
            // if user has been deactivated by admin
            if (!$user->getData('is_active')) {
                $this->getCoreSession()->addError('We are sorry, system unable to connect you with facebook');
                return $this->_redirect('*/*/error');
            }
        }

        if ($user->getId()) {
            // if user exists on the same store, then unset the user_id from the post data.
            if ($user->getData('store_id') == $this->getMageApp()->getStore()->getId()) {
                unset($data['user_id']);
                // else if user is not on this store,
                // then we reset the user to save new one with the post data.
            } elseif ($user->getData('store_id') != $this->getMageApp()->getStore()->getId()) {
                $user = $this->getUser();
            }
        }

        // we always save data upon login, in case users change their alaa profile details.
        try {
            $user->setRequiredProperties($data)
                ->setExtra($data);
            $user->save();

        } catch(\Exception $e) {
            $this->log($e->getMessage());
            throw $e;
        }

        $this->getCoreSession()->setData(
            'facebook_user_id',
            $user->getId()
        );

        return $this->_redirect('customer/account', array('user_id' => $user->getId()));
    }

    /**
     * error action.
     * @return $this
     */
    public function errorAction()
    {
        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }

    public function comingSoonAction()
    {
        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }


    /**
     * @return Alaa_FacebookConnect_Model_Session
     */
    public function getFacebookSession()
    {
        return Mage::getSingleton('alaa_facebookconnect/session');
    }

    /**
     * @param string    $msg
     */
    public function log($msg)
    {
        Mage::log($msg);
    }

    /**
     * @return Alaa_FacebookConnect_Model_Facebok_PublicProfile
     */
    public function getPublicProfile()
    {
        return Mage::getModel('alaa_facebookconnect/facebook_publicProfile');
    }

    /**
     * @return Alaa_FacebookConnect_Helper_PublicProfile
     */
    public function getPublicProfileHelper()
    {
        return Mage::helper('alaa_facebookconnect/publicProfile');
    }

    /**
     * @return Alaa_FacebookConnect_Model_User
     */
    public function getUser()
    {
        return Mage::getModel('alaa_facebookconnect/user');
    }

    /**
     * @param string $segment
     * @return string
     */
    protected function getUrl($segment)
    {
        return Mage::getUrl($segment);
    }

    /**
     * @return Mage_Core_Model_Session
     */
    protected function getCoreSession()
    {
        return Mage::getSingleton('core/session');
    }

    /**
     * @return Mage_Core_Model_App
     */
    public function getMageApp()
    {
        return Mage::app();
    }

    /**
     * @return \Facebook\Facebook
     */
    public function getFacebook()
    {
        return $this->getFacebookFactory()->getFacebook();
    }

    /**
     * @return Alaa_FacebookConnect_Model_Alaa_Factory
     */
    public function getFacebookFactory()
    {
        return Mage::getSingleton('alaa_facebookconnect/facebook_factory');
    }
}