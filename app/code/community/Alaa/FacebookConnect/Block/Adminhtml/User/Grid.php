<?php
/**
 * Class Alaa_FacebookConnect_Block_Adminhtml_User_Grid
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Block_Adminhtml_User_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('facebookUserGrid');
        $this->setDefaultSort('entity_id', 'desc');
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->getAlaaUserCollection();
        $collection->getSelect()->joinLeft(
            array('customer' => 'customer_entity'),
            'customer.email=main_table.email and customer.store_id=main_table.store_id',
            array('customer_id' => 'customer.entity_id')
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('User ID'),
            'type' => 'number',
            'index' => 'entity_id',
        ));

        $this->addColumn('customer_id', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('Customer ID'),
            'type' => 'number',
            'index' => 'customer_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('Created Date'),
            'type' => 'date',
            'index' => 'created_at',
        ));

        $this->addColumn('first_name', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('First Name'),
            'type' => 'text',
            'index' => 'first_name',
        ));

        $this->addColumn('last_name', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('Last Name'),
            'type' => 'text',
            'index' => 'last_name',
        ));

        $this->addColumn('email', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('Email'),
            'type' => 'email',
            'index' => 'email',
        ));

        $this->addColumn('store', array(
            'header'    => $this->getAlaaFacebookConnectHelper()->__('Store View'),
            'index'     => 'store_id',
            'type'      => 'options',
            'options'   => $this->getStoreOptions()
        ));

        $this->addColumn('is_active', array(
            'header' => $this->getAlaaFacebookConnectHelper()->__('Active'),
            'index' => 'is_active',
            'type' => 'options',
            'options'   => $this->getYesNoOptions(),
        ));

        return parent::_prepareColumns();
    }

    /**
     * @return Alaa_FacebookConnect_Model_Resource_User_Collection
     */
    protected function getAlaaUserCollection()
    {
        return Mage::getResourceModel('alaa_facebookconnect/user_collection');
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getAlaaFacebookConnectHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }

    /**
     * @return array
     */
    public function getStoreOptions()
    {
        return Mage::getModel('adminhtml/system_store')->getStoreOptionHash();
    }

    /**
     * @return array
     */
    public function getYesNoOptions()
    {
        return Mage::getModel('adminhtml/system_config_source_yesno')->toArray();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('facebook_user_id');
        $this->getMassactionBlock()->setFormFieldName('facebook_user');

        $this->getMassactionBlock()->addItem('activate', array(
            'label'        => $this->getAlaaFacebookConnectHelper()->__('Activate'),
            'url'          => $this->getUrl('*/*/massActivate')
        ));

        $this->getMassactionBlock()->addItem('deactivate', array(
            'label'        => $this->getAlaaFacebookConnectHelper()->__('Deactivate'),
            'url'          => $this->getUrl('*/*/massDeactivate')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label'        => $this->getAlaaFacebookConnectHelper()->__('Delete'),
            'url'          => $this->getUrl('*/*/massDelete')
        ));

        return $this;
    }
}