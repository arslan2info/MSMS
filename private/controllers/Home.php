<?php

// home controller
class Home extends Controller
{
    function index()
    {
        // $user = $this->load_model('User');
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }


        $this->view('home');
    }
}
