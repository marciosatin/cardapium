<?php

namespace Cardapium\Models\Validators;

/**
 * Description of ValidatorException
 *
 * @author Marcio
 */
class ValidatorException extends \ErrorException
{

    protected $errors = [];

    public function addErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getErrorMessages()
    {
        $errorMsg = [];
        foreach ($this->getErrors() as $field => $errors) {
            foreach ($errors as $erro) {
                if (!isset($errorMsg[$field])) {
                    $errorMsg[$field] = [];
                }
                $errorMsg[$field] = array_values($erro);
            }
        }

        return $errorMsg;
    }

}
