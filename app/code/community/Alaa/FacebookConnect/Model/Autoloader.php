<?php
/**
 * Class Alaa_FacebookConnect_Model_Autoloader
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Alaa_FacebookConnect_Model_Autoloader
{
    const FACEBOOK_AUTOLOAD_DIRECTORY = 'vendor/autoload.php';

    /**
     * @return mixed
     * @throws Exception
     */
    public static function load()
    {
        $filePath = Mage::getBaseDir() . DS . self::FACEBOOK_AUTOLOAD_DIRECTORY;
        if (!file_exists($filePath)) {
            throw new \Exception('File: ' . $filePath . ' does not exist.');
        }

        return include ($filePath);
    }
}