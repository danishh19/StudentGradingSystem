<?php
// Use this when displaying database or form values in HTML.
function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
