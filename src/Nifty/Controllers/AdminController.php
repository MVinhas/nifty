<?php

namespace Nifty\Controllers;

use Nifty\Models\Admin;

class AdminController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

    public function index()
    {
        $visits = $this->admin->getVisits();
        $data = [];
        $data['sessions']['today'] = $data['sessions']['week'] = 0;
        $data['sessions']['alltime'] = count((array)$visits);
        foreach ($visits as $visit) {
            if (
                $visit->date >= date('Y-m-d 00:00:00')
                &&
                $visit->date < date('Y-m-d 00:00:00', strtotime('+1 day'))
            ) {
                $data['sessions']['today'] += 1;
            }
            if ($visit->date >= date('Y-m-d 00:00:00', strtotime('-7 days'))) {
                $data['sessions']['week'] += 1;
            }
        }
        return $this->view((object)$data);
    }

    public function signOut()
    {
        unset($_SESSION['user']);
        session_write_close();
        header('Location: /');
        exit;
    }
}