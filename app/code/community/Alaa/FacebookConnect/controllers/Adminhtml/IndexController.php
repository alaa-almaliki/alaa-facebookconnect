<?php
/**
 * Class Alaa_FacebookConnect_Adminhtml_IndexController
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{

    /** @var  Alaa_FacebookConnect_Model_Resource_User_Collection $facebookCollection */
    protected $facebookCollection;
    /** @var  int $collectionCount */
    protected $collectionCount;

    /**
     * @see Mage_Adminhtml_Controller_Action::preDispatch
     */
    public function preDispatch()
    {
        parent::preDispatch();

        $actions = array(
            'massActivate',
            'massDeactivate',
            'massDelete'
        );

        $action = $this->getRequest()->getActionName();

        if (in_array($action, $actions)) {
            if($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                $users = isset($post['facebook_user'])? $post['facebook_user']: array();
                if (!is_array($users) || empty($users)) {
                    $this->getSession()->addError('There was a problem updating users.');
                    $this->_redirect('*/*/');
                }

                $this->facebookCollection = $this->getFacebookUserCollection()
                    ->addFieldToFilter('entity_id', $users);
                $this->collectionCount = $this->facebookCollection->count();
            }
        }
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('alaa_facebookconnect_admin/user');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    /**
     * mass activate facebook users
     */
    public function massActivateAction()
    {
        if (!is_null($this->facebookCollection)) {
            $this->getFacebookActionHelper()->massActivate($this->facebookCollection);
            $this->getSession()->addSuccess($this->collectionCount . ' records were activated.');
        } else {
            $this->getSession()->addError('There was a problem updating users.');
        }
        $this->_redirect('*/*/');
    }

    /**
     * mass deactivate facebook users
     */
    public function massDeactivateAction()
    {
        if (!is_null($this->facebookCollection)) {
            $this->getFacebookActionHelper()->massDeactivate($this->facebookCollection);
            $this->getSession()->addSuccess($this->collectionCount . ' records were deactivated.');
        } else {
            $this->getSession()->addError('There was a problem updating users.');
        }
        $this->_redirect('*/*/');
    }

    /**
     * mass deletes facebook users
     */
    public function massDeleteAction()
    {
        if (!is_null($this->facebookCollection)) {
            $this->getFacebookActionHelper()->massDelete($this->facebookCollection);
            $this->getSession()->addSuccess($this->collectionCount . ' records were deleted.');
        } else {
            $this->getSession()->addError('There was an error updating users.');
        }
        $this->_redirect('*/*/');
    }

    /**
     * @return Alaa_FacebookConnect_Model_Resource_User_Collection
     */
    public function getFacebookUserCollection()
    {
        return Mage::getResourceModel('alaa_facebookconnect/user_collection');
    }


    /**
     * @return Alaa_FacebookConnect_Helper_Action
     */
    public function getFacebookActionHelper()
    {
        return Mage::helper('alaa_facebookconnect/action');
    }

    /**
     * @return Mage_Adminhtml_Model_Session
     */
    protected function getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('config/alaa_facebookconnect');
    }
}