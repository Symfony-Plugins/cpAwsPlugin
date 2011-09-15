<?php

/**
 * PluginS3Image form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginS3ImageForm extends BaseS3ImageForm {
  
  public function configure() {
    parent::configure();
    $this->validatorSchema['original_filename']->setOption('mime_types', 'image_video'); 
    $this->validatorSchema['original_filename']->setOption('mime_categories', array('image_video' => array(
      'image/jpeg', 
      'image/pjpeg',
      'image/png',
      'image/x-png',
      'image/gif',
      'video/3gpp',       // video mime-types that Amazon support
      'video/x-msvideo',
      'video/x-dv',
      'video/x-flv',
      'video/vnd.mpegurl',
      'video/x-m4v',
      'video/quicktime',
      'video/x-sgi-movie',
      'video/mp4',
      'video/mpeg',
      'video/ogv',
      'video/webm',
      'video/x-ms-wmv'))); 
  }
  
}
