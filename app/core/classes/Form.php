<?
class Form
{
    public $errors;
    private $valid = true;

    public function addError(array $array)
    {
        $this->valid = false;
        $this->errors[] = $array;
    }

    public function isValid()
    {
        return $this->valid;
    }
}
 