<?php

function set_active($path, $active = 'active')
{
    return \Request::is($path . '*') ? $active : '';
}

function set_active_strict($path, $active = 'active')
{
    return \Request::is($path) ? $active : '';
}
