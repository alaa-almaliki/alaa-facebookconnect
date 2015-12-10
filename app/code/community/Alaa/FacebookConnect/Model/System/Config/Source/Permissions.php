<?php
/**
 * Class Alaa_FacebookConnect_Model_System_Config_Source_Permissions
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_System_Config_Source_Permissions
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $ops = array();

        foreach ($this->toArray() as $value => $label) {
            $ops[] = array(
                'label'     => $label,
                'value'     => $value,
            );
        }

        return $ops;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $permissions = array(
            'public_profile'                    => $this->getHelper()->__('Public Profile'),
            'user_friends'                      => $this->getHelper()->__('User Friends'),
            'email'                             => $this->getHelper()->__('Email'),
            'user_about_me'                     => $this->getHelper()->__('User About Me'),
            'user_actions'                      => $this->getHelper()->__('User Actions Books'),
            'user_actions.music'                => $this->getHelper()->__('User Actions Music'),
            'user_actions.news'                 => $this->getHelper()->__('User Actions News'),
            'user_actions.video'                => $this->getHelper()->__('User Actions Video'),
            'user_birthday'                     => $this->getHelper()->__('User Birthday'),
            'user_education_history'            => $this->getHelper()->__('User Education History'),
            'user_events'                       => $this->getHelper()->__('User Events'),
            'user_games_activity'               => $this->getHelper()->__('User Game Activity'),
            'user_hometown'                     => $this->getHelper()->__('User Hometown'),
            'user_likes'                        => $this->getHelper()->__('User Likes'),
            'user_location'                     => $this->getHelper()->__('User Location'),
            'user_managed_groups'               => $this->getHelper()->__('User Managed Groups'),
            'user_photos'                       => $this->getHelper()->__('User Photos'),
            'user_posts'                        => $this->getHelper()->__('User Posts'),
            'user_relationships'                => $this->getHelper()->__('User Relationships'),
            'user_relationship_details'         => $this->getHelper()->__('User Relationship Details'),
            'user_religion_politics'            => $this->getHelper()->__('User Religion Politics'),
            'user_tagged_places'                => $this->getHelper()->__('User Tagged Places'),
            'user_videos'                       => $this->getHelper()->__('User Videos'),
            'user_website'                      => $this->getHelper()->__('User Website'),
            'user_work_history'                 => $this->getHelper()->__('User Work History'),
            'read_custom_friendlists'           => $this->getHelper()->__('Read Custom Friend Lists'),
            'read_insights'                     => $this->getHelper()->__('Read Insights'),
            'read_audience_network_insights'    => $this->getHelper()->__('Read Audience Network Insights'),
            'read_page_mailboxes'               => $this->getHelper()->__('Read Page Mailboxes'),
            'manage_pages'                      => $this->getHelper()->__('Manage Pages'),
            'publish_pages'                     => $this->getHelper()->__('Publish Pages'),
            'publish_actions'                   => $this->getHelper()->__('Publish Actions'),
            'rsvp_event'                        => $this->getHelper()->__('RSVP Event'),
            'pages_show_list'                   => $this->getHelper()->__('Pages Show List'),
            'pages_manage_cta'                  => $this->getHelper()->__('Pages Manage CTA'),
            'pages_manage_leads'                => $this->getHelper()->__('Pages Manage Leads'),
            'ads_read'                          => $this->getHelper()->__('Ads Read'),
            'ads_management'                    => $this->getHelper()->__('Ads Management'),
            );

        return $permissions;
    }

    /**
     * @return Alaa_FacebookConnect_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('alaa_facebookconnect');
    }
}