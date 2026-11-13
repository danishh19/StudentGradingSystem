<?php
// Tests contribute 20 + 30 marks; the exam contributes the remaining 50.
function calculateResult(array $input): array
{
    $marks = [];
    foreach (['test1' => 20, 'test2' => 30, 'final_exam' => 50] as $field => $maximum) {
        $value = $input[$field] ?? null;
        if (!is_scalar($value) || !is_numeric($value) || !is_finite((float) $value)
            || (float) $value < 0 || (float) $value > $maximum) {
            throw new InvalidArgumentException("Enter a valid mark for " . str_replace('_', ' ', $field) . " between 0 and $maximum.");
        }
        $marks[$field] = (float) $value;
    }
    $marks['total_marks'] = round($marks['test1'] + $marks['test2'] + $marks['final_exam'], 2);
    $total = $marks['total_marks'];
    if ($total >= 80) {
        $marks['grade'] = 'A';
    } elseif ($total >= 65) {
        $marks['grade'] = 'B';
    } elseif ($total >= 50) {
        $marks['grade'] = 'C';
    } elseif ($total >= 40) {
        $marks['grade'] = 'D';
    } else {
        $marks['grade'] = 'E';
    }
    return $marks;
}
