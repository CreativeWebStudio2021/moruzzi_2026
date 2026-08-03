<?php

namespace App\Http\Controllers;

use App\Models\SiteAnnouncement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteAnnouncementController extends Controller
{
    public function dismiss(Request $request): RedirectResponse
    {
        $announcement = SiteAnnouncement::current();
        if ($announcement && $announcement->isActive()) {
            $request->session()->put('site_announcement_dismissed', $announcement->dismissToken());
        }

        return back();
    }

    public function reopen(Request $request): RedirectResponse
    {
        $request->session()->forget('site_announcement_dismissed');

        return back();
    }
}
