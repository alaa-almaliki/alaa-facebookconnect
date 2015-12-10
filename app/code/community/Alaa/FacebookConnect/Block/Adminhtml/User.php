<?php
/**
 * Class Alaa_FacebookConnect_Block_Adminhtml_User
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Block_Adminhtml_User extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'alaa_facebookconnect_admin';
        $this->_controller = 'user';
        $this->_headerText = $this->getAlaaFacebookConnectHelper()->__('Facebook Users');
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    public function _prepareLayout()
    {
        $this->_removeButton('add');
        return parent::_prepareLayout();
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getAlaaFacebookConnectHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }
}