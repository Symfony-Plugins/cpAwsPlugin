<?php

class ValidatedS3File extends sfValidatedFile {
  
  /**
   * used in sfValidatorDoctrineUnique#doClean: $q->addWhere('a.' . $colName . ' = ?', $values[$column]); to build query with proper value for 'original_filename' field.
   */
  public function __toString() {
    return $this->getOriginalName();
  }
  
}