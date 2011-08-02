<?php

/**
 * PluginS3Object
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginS3Object extends BaseS3Object {
  
  public function getUrl() {
    $s3 = new AmazonS3($this->getAccessKeyId(), $this->getSecretAccessKey());
    return $s3->get_object_url($this->getBucket(),
                               $this->getS3Path() . $this->getFilename(),
                               $this->getPreauth());
  }
  
  public function getS3Path() {
    return '/';
  }
  
  public function getBucket() {
    return sfConfig::get('app_aws_bucket');
  }
  
  public function getAccessKeyId() {
    return sfConfig::get('app_aws_access_key_id');
  }
  
  public function getSecretAccessKey() {
    return sfConfig::get('app_aws_secret_access_key');
  }
  
  public function getPreauth() {
    return sfConfig::get('app_aws_preauth');
  }
  
  public function uploadFile($filename, $path) {
    $s3 = new AmazonS3($this->getAccessKeyId(), $this->getSecretAccessKey());
    $s3->disable_ssl();
    $response = $s3->create_object($this->getBucket(), 
                                   $this->getS3Path() . $filename, 
                                   array('fileUpload' => $path, 'acl' => AmazonS3::ACL_PRIVATE));
    if ($response->isOK()) {
      // old file can be deleted
      if ($this->exists() && $this->getFilename() && 
          $s3->if_object_exists($this->getBucket(),  $this->getS3Path() . $this->getFilename())) {
        $s3->delete_object($this->getBucket(),  $this->getS3Path() . $this->getFilename());
        $this->setFilename('');
      }
      return $filename;
    }
    throw new S3_Exception('Check your AWS settings, file was not uploaded successfully.');
  }

}