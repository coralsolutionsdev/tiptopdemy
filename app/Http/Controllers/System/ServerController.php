<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServerController extends Controller
{
    public function index()
    {
//        $this->authorize('server', System::class);
//        $contentTitle = 'Server Info';
        return view('system.server.index');
    }

    public function flushCache()
    {
        Cache::flush();
        session()->flash('success', 'Successfully cleared the cache.');
        return back();
    }
}
