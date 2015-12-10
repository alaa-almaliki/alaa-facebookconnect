<?php
/**
 * Class Alaa_FacebookConnect_Helper_Action
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Helper_Action extends Mage_Core_Helper_Abstract
{
    /**
     * @param   $collection
     * @param $data
     * @return $this
     */
    protected function massUpdate($collection, $data)
    {
        $table = '';
        if ($collection instanceof Mage_Core_Model_Resource_Db_Collection_Abstract) {
            $table = $collection->getResource()->getMainTable();
        } elseif ($collection instanceof Mage_Customer_Model_Resource_Customer_Collection) {
            $table = $collection->getResource()->getTable('customer_entity');
        }

        $collection->getConnection()->update(
            $table,
            $data,
            $collection->getResource()->getIdFieldName() . ' IN(' . implode(',', $collection->getAllIds()) . ')'
        );

        return $this;
    }

    /**
     * @param Alaa_FacebookConnect_Model_Resource_User_Collection $facebookUserCollection
     * @return $this
     */
    public function massDeactivate($facebookUserCollection)
    {
        $data = array('is_active' => 0);
        $emails = $facebookUserCollection->getColumnValues('email');
        $customerCollection = $this->getCustomerCollection()
            ->addFieldToFilter('email', $emails);

        $this->massUpdate($facebookUserCollection, $data);

        if ($customerCollection->count() > 0) {
            $this->massUpdate($customerCollection, $data);
        }

        return $this;
    }

    /**
     * @param Alaa_FacebookConnect_Model_Resource_User_Collection $facebookUserCollection
     * @return $this
     */
    public function massActivate($facebookUserCollection)
    {
        $data = array('is_active' => 1);
        $emails = $facebookUserCollection->getColumnValues('email');
        $customerCollection = $this->getCustomerCollection()
            ->addFieldToFilter('email', $emails);

        $this->massUpdate($facebookUserCollection, $data);

        if ($customerCollection->count() > 0) {
            $this->massUpdate($customerCollection, $data);
        }

        return $this;
    }

    /**
     * @param $facebookUserCollection
     * @return $this
     */
    public function massDelete($facebookUserCollection)
    {
        $emails = $facebookUserCollection->getColumnValues('email');
        $customerCollection = $this->getCustomerCollection()
            ->addFieldToFilter('email', $emails);

        $facebookUserCollection->walk('delete');

        if ($customerCollection->count() > 0) {
            $customerCollection->walk('delete');
        }
        return $this;
    }

    /**
     * @return Mage_Customer_Model_Resource_Customer_Collection
     */
    public function getCustomerCollection()
    {
        return Mage::getResourceModel('customer/customer_collection');
    }
}