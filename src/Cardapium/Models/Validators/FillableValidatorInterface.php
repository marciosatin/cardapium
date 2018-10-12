<?php

namespace Cardapium\Models\Validators;

/**
 *
 * @author Marcio
 */
interface FillableValidatorInterface
{

    public function getFillableValidators();

    public function prepareFillableValidators();
}
