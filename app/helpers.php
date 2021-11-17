<?php

function sequal_escape($value = null)
{
    if (!$value) {
        $value = '';
    }

    return "'" . preg_replace("/'/", "\'", $value) . "'";
}
