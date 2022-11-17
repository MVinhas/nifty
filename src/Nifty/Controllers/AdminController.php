<?php

namespace Nifty\Controllers;

use Nifty\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return $this->view();
    }

    public function signOut()
    {
        unset($_SESSION['user']);
        session_write_close();
        header('Location: /');
        exit;
    }
}