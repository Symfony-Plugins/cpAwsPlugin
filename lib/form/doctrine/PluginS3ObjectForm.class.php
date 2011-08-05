<?php

/**
 * PluginS3Object form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginS3ObjectForm extends BaseS3ObjectForm {
  
  public function configure() {
    parent::configure();
    $this->setWidgets(array(
      'original_filename' => new sfWidgetFormInputFileEditable(array(
        'file_src' => $this->isNew() ? 
          '' : 
          '<a href="' . $this->getObject()->getUrl() . '">' . $this->getObject()->getOriginalFilename(). '</a>',
        'edit_mode' => true,
        'label' => 'File' )),
      'title'             => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormTextarea()
    ));

    $this->setValidators(array(
      'title'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'description'       => new sfValidatorString(array('required' => false)),
      'original_filename'          => new sfValidatorFile(array('path' => '', 
                                                                'required' => $this->isNew(),
                                                                'validated_file_class' => 'ValidatedS3File')),
      'original_filename_delete'   => new sfValidatorPass()
    ));
    
    $this->mergePostValidator(new sfValidatorDoctrineUnique(array(
      'model' => $this->getModelName(), 
      'column' => array('original_filename', 'asset_id')), array(
      'invalid' => 'The file with the same name already exist.')));
    
    $this->disableCSRFProtection();
    $this->setOption('inlineLabels', true);
  }

  protected function updateOriginalFilenameColumn($value) {
    if ($value instanceof sfValidatedFile) {
      return $this->getObject()->uploadFile($value->getOriginalName(), $value->getTempName());
    }
    return false;
  } 
}  