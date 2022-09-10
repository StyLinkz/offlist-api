<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class GitController extends Controller
{

    public function getVersion(Request $request)
    {
        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('Europe/Berlin'));

        return sprintf('%s (%s UTC+2)', $commitHash, $commitDate->format('Y-m-d H:i:s'));
    }
}
