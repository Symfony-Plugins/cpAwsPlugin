<?php

/**
 * PluginS3DocumentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginS3DocumentTable extends S3ObjectTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginS3DocumentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginS3Document');
    }
}