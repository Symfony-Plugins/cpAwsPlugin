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
    $this->setWidgets(array(
      'filename' => new sfWidgetFormInputFileEditable(array(
        'file_src' => $this->isNew() ? 
          '' : 
          '<a href="' . $this->getObject()->getUrl() . '">' . $this->getObject()->getFilename(). '</a>',
        'edit_mode' => true,
        'label' => 'File' )),
      'title'             => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormTextarea()
    ));

    $this->setValidators(array(
      'title'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'description'       => new sfValidatorString(array('required' => false)),
      'filename'          => new sfValidatorFile(array('path' => '', 'required' => $this->isNew())),
      'filename_delete'   => new sfValidatorPass()
    ));

    $this->disableCSRFProtection();
    $this->setOption('inlineLabels', true);
  }

  protected function updateFilenameColumn($value) {
    if ($value instanceof sfValidatedFile) {
      return $this->getObject()->uploadFile($value->getOriginalName(), $value->getTempName());
    }
    return false;
  }
}  