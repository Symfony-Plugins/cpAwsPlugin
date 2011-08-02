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
    $this->validatorSchema['filename']->setOption('mime_types', 'image_video'); 
    $this->validatorSchema['filename']->setOption('mime_categories', 
                                                           array('image_video' => array('image/jpeg', 
                                                                                        'image/pjpeg',
                                                                                        'image/png',
                                                                                        'image/x-png',
                                                                                        'image/gif',
                                                                                        'video/mpeg',
                                                                                        'video/quicktime',
                                                                                        'video/x-msvideo')); 
  }
}
