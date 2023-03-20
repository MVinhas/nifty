<?php

namespace Nifty\Controllers;

use Nifty\Models\Admin;
use Nifty\Models\Site;

class AdminController extends Controller
{
    protected Site $site;
    protected Admin $admin;

    public function __construct()
    {
        $this->admin = new Admin();
        $this->site = new Site();
    }

    public function index(): bool
    {
        $visits = $this->admin->getVisits();
        return $this->view(
            (object)[
                'sessions' => [
                    'today' => $this->visitsToday($visits),
                    'week' => $this->visitsThisWeek($visits),
                    'alltime' => count((array)$visits)
                ]
            ]
        );
    }

    private function visitsToday(object $visits): int
    {
        $counter = 0;
        foreach ($visits as $visit) {
            if (
                $visit->date >= date('Y-m-d 00:00:00')
                &&
                $visit->date < date('Y-m-d 00:00:00', strtotime('+1 day'))
            ) {
                $counter++;
            }
        }
        return $counter;
    }

    private function visitsThisWeek(object $visits): int
    {
        $counter = 0;
        foreach ($visits as $visit) {
            if ($visit->date >= date('Y-m-d 00:00:00', strtotime('-7 days'))) {
                $counter++;
            }
        }
        return $counter;
    }

    public function signOut()
    {
        unset($_SESSION['user']);
        session_write_close();
        header('Location: /');
        exit;
    }
}