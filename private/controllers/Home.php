<?php

// home controller
class Home extends Controller
{
    function index()
    {
        echo $this->view('home');
    }
}
