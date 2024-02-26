<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class ProfileQuestion implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $filtered = collect($value)->filter(fn ($v) => $v);

        if (!$filtered->count()) {
            $fail('You must answer least one profile question.');
        }
    }
}
