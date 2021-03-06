<?php

declare(strict_types = 1);

namespace Cardapium\Repository;

use Cardapium\Models\Validators\ValidatorException;
use Cardapium\Models\Validators\ValidatorInterface;
use Illuminate\Database\Eloquent\Model;

class DefaultRepository implements RepositoryInterface, ValidatorInterface
{

    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var Model
     */
    private $_model;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $this->_model = new $modelClass;
    }

    public function all()
    {
        return $this->_model->all();
    }

    public function find(int $id, bool $failIfNotExist = true)
    {
        return $failIfNotExist ? $this->_model->findOrFail($id) :
                $this->_model->find($id);
    }

    public function create(array $data)
    {
        $this->_model->fill($data);
        $this->validate();
        $this->_model->save();
        return $this->_model;
    }

    public function update($id, array $data)
    {
        $this->_model = $this->findInternal($id);
        $this->_model->fill($data);
        $this->validate(['idExclude' => $id]);
        $this->_model->save();
        return $this->_model;
    }

    public function delete($id)
    {
        $model = $this->findInternal($id);
        $model->delete();
    }

    public function findByField(string $field, $value)
    {
        return $this->_model->where($field, '=', $value)->get();
    }

    public function findOneBy(array $search)
    {
        $queryBuilder = $this->_model;
        foreach ($search as $field => $value) {
            $queryBuilder = $queryBuilder->where($field, '=', $value);
        }

        return $queryBuilder->firstOrFail();
    }

    public function validate(array $options = [])
    {
        $this->_model->prepareFillableValidators($options);

        $fields = $this->_model->getFillableValidators();
        if (!is_array($fields)) {
            return true;
        }

        $errors = [];
        foreach ($fields as $field => $value) {

            if (!isset($this->_model->$field)) {
                continue;
            }

            if (isset($value['filters'])) {
                $filters = $value['filters'];
                foreach ($filters as $filter) {
                    $this->_model->$field = $filter->filter($this->_model->$field);
                }
            }

            if (isset($value['validators'])) {
                $validators = $value['validators'];
                foreach ($validators as $validator) {
                    if (!$validator->isValid($this->_model->$field)) {
                        if (!isset($errors[$field])) {
                            $errors[$field] = [];
                        }
                        $errors[$field][] = $validator->getMessages();
                    }
                }
            }
        }

        if ($errors) {
            $e = new ValidatorException();
            $e->addErrors($errors);
            throw $e;
        }
    }

    protected function findInternal($id)
    {
        return is_array($id) ? $this->findOneBy($id) : $this->find($id);
    }

}
