<?php

namespace Cardapium\Models\Validators;

/**
 *
 * @author Marcio
 */
interface ValidatorInterface
{
    public function validate(array $data = [], array $options = []);
}
