<?php

namespace Cardapium\Models\Validators;

use Zend\Validator\AbstractValidator;

/**
 * Description of RecordExists
 *
 * @author Marcio
 */
class RecordExists extends AbstractValidator
{

    const NO_RECORD_EXISTS = 'noRecordExists';

    protected $messageTemplates = [
        self::NO_RECORD_EXISTS => 'Não foi encontrado registro para %value%'
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
        if ($model->get()->count() == 0) {
            $this->error(self::NO_RECORD_EXISTS, $value);
            return false;
        }
        return true;
    }

}
