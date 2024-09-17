<?php

// students controller
class Students extends Controller
{
    function index($id = '')
    {
        echo "This is a students Controller " . $id;
    }
}
