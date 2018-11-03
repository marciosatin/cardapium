<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\NoRecordExists;
use Illuminate\Database\Eloquent\Model;
use Jasny\Auth\User as JasnyUser;
use Zend\Validator\NotEmpty;

class User extends Model implements JasnyUser, UserInterface, FillableValidatorInterface
{

    //Mass Assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];
    protected $fillableValidators = [];

    /**
     * Get user id
     *
     * @return int|string
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Get user's username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Get user's hashed password
     *
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->password;
    }

    /**
     * Event called on login.
     *
     * @return boolean  false cancels the login
     */
    public function onLogin()
    {
        // TODO: Implement onLogin() method.
    }

    /**
     * Event called on logout.
     *
     * @return void
     */
    public function onLogout()
    {
        // TODO: Implement onLogout() method.
    }

    public function getFullname(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

    public function prepareFillableValidators(array $options = [])
    {

        $noRecordOpt = [
            'table' => User::class,
            'field' => 'email'
        ];

        if (isset($options['idExclude'])) {
            $noRecordOpt['exclude'] = [
                'excludeField' => 'id',
                'excludeValue' => (int) $options['idExclude']
            ];
        }

        $this->fillableValidators = [
            'first_name' => [
                'validators' => [
                    (new NotEmpty)->setMessage('Primeiro nome não pode ser vazio')
                ]
            ],
            'last_name' => [
                'validators' => [
                    (new NotEmpty)->setMessage('Segundo nome não pode ser vazio')
                ]
            ],
            'email' => [
                'validators' => [
                    (new NotEmpty)->setMessage('Data inicial não pode ser vazio'),
                    (new NoRecordExists($noRecordOpt))
                ]
            ],
            'password' => [
                'validators' => [
                    (new NotEmpty)->setMessage('Data final não pode ser vazio')
                ]
            ],
        ];
    }

}
