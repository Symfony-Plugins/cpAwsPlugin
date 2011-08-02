<?php
class Sanitizer {

  protected $default_filename;
  protected $forced_extension;

  function __construct($default_filename, $forced_extension) {
    $this->default_filename = $default_filename;
    $this->forced_extension = $forced_extension;
  }

  public function sanitize($string) {
    $s = trim($string);

    $s = preg_replace("/^[.]*/", "", $s); // lose any leading dots
    $s = preg_replace("/[.]*$/", "", $s); // lose any trailing dots
    $s = $s ? $s : $this->default_filename; // if filename is blank, provide default

    $s = $this->replace_accented_chars($s);

    $lastdotpos = strrpos($s, "."); // save last dot position

    $s = $this->replace_dodgy_chars($s);

    $extension = "";
    if ($lastdotpos !== false) { // Split into name and extension, if any.
      $filename = substr($s, 0, $lastdotpos);
      if ($lastdotpos < (strlen($s) - 1))
      $extension = substr($s, $lastdotpos + 1);
    }
    else {
      // no extension
      $filename = $s;
    }

    if (!empty($this->forced_extension)) {
      $s = $filename . "." . $this->forced_extension;
    }
    elseif ($extension) {
      $s = $filename . "." . $extension;
    }
    else { $s = $filename; }

    return $s;
  }

  protected function replace_dodgy_chars($string) {
    $dodgychars = "[^0-9a-zA-Z()_-]"; // allow only alphanumeric, underscore, parentheses and hyphen
    return preg_replace("/$dodgychars/", "_", $string); // replace dodgy characters
  }

  protected function replace_accented_chars($string) {
    $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
    return str_replace($search, $replace, $string);
  }


}