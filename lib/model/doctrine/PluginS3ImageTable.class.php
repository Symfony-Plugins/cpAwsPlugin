<?php

/**
 * PluginS3ImageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginS3ImageTable extends S3ObjectTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginS3ImageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginS3Image');
    }
}