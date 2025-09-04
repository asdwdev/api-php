<?php
function validate(array $data, array $rules): array
{
    $errors = [];

    foreach ($rules as $field => $ruleString) {
        $rulesList = explode('|', $ruleString); // contoh: "required|numeric"

        foreach ($rulesList as $rule) {
            $rule = trim($rule);

            if ($rule === 'required') {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    $errors[] = "$field is required";
                }
            }

            if ($rule === 'numeric') {
                if (isset($data[$field]) && !is_numeric($data[$field])) {
                    $errors[] = "$field must be numeric";
                }
            }

            if (str_starts_with($rule, 'max:')) {
                $limit = (int) substr($rule, 4);
                if (isset($data[$field]) && strlen($data[$field]) > $limit) {
                    $errors[] = "$field must not exceed $limit characters";
                }
            }
        }
    }

    return $errors;
}
