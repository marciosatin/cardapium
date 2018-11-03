<?php

namespace Cardapium\Models\Validators;

use Zend\Validator\AbstractValidator;

/**
 * Description of NoRecordExists
 *
 * @author Marcio
 */
class NoRecordExists extends AbstractValidator
{

    const RECORD_EXISTS = 'recordExists';

    protected $messageTemplates = [
        self::RECORD_EXISTS => '%value% já existe cadastrado'
    ];
    protected $table;
    protected $field;
    protected $excludeField;
    protected $excludeValue;

    public function __construct(array $options)
    {
        if (!isset($options['table']) || !isset($options['field'])) {
            throw new \Zend\Validator\Exception\InvalidArgumentException;
        }
        $this->table = $options['table'];
        $this->field = $options['field'];

        if (isset($options['exclude'])) {
            $this->excludeField = $options['exclude']['excludeField'];
            $this->excludeValue = $options['exclude']['excludeValue'];
        }

        parent::__construct($options);
    }

    public function isValid($value)
    {
        $model = $this->table::where($this->field, '=', $value);
        if ((null !== $this->excludeField) and (null !== $this->excludeValue)) {
            $model->where($this->excludeField, '!=', $this->excludeValue);
        }

        $row = $model->get();

        if ($row->count() > 0) {
            $this->error(self::RECORD_EXISTS, $value);
            return false;
        }
        return true;
    }

}
