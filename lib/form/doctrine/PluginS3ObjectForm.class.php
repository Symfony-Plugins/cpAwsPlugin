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

  //copy to PluginS3ObjectForm
  public function configure() {
    parent::configure();
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'filename'          => new sfWidgetFormInputHidden(),
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
      'id'                       => new sfValidatorChoice(array(
        'choices' => array($this->getObject()->get('id')), 
        'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'filename'                 => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'original_filename'        => new sfValidatorFile(array('path' => '', 
                                                              'required' => $this->isNew(),
                                                              'validated_file_class' => 'ValidatedS3File')),
      'original_filename_delete' => new sfValidatorPass(),
      'title'                    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'description'              => new sfValidatorString(array('required' => false)),
    ));
    
    $this->disableCSRFProtection();
    $this->setOption('inlineLabels', true);
  } 

  public function bind(array $taintedValues = null, array $taintedFiles = null) {
    if ($taintedFiles['original_filename']['name']) {
      $sanitizer = new Sanitizer('object', '');
      $taintedValues['filename'] = $sanitizer->sanitize($taintedFiles['original_filename']['name']);
    } 
    parent::bind($taintedValues, $taintedFiles);
  }
  
  protected function updateOriginalFilenameColumn($value) {
    if ($value instanceof sfValidatedFile) {
      return $this->getObject()->uploadFile($value->getOriginalName(), $value->getTempName(),
                                            $this->values['filename']);
    }
    return false;
  } 
}  