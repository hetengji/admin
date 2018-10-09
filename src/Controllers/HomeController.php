<?php

namespace Evaluation\Admin\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        dd(auth());
        echo '此处渲染Home页面';
    }
}
