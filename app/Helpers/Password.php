<?php

if (!function_exists('checkPassword')) {
    function checkPassword($password, $hashedPassword)
    {
        return \Illuminate\Support\Facades\Hash::check($password, $hashedPassword);
    }
}
