<?php

namespace App\Rules;

use App\Sortable;
use Illuminate\Contracts\Validation\Rule;

class SortableColumn implements Rule
{
    /**
     * @var array
     */
    private $columns;

    /**
     * Create a new rule instance.
     *
     * @param array $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! is_string($value)) {
            return false;
        }

        [$column] = Sortable::info($value);

        return in_array($column, $this->columns);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El orden no es válido';
    }
}
