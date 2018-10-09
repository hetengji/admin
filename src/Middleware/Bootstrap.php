<?php

namespace Evaluation\Admin\Middleware;

use Evaluation\Admin\Admin;
use Evaluation\Admin\Form;
use Evaluation\Admin\Grid;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, \Closure $next)
    {
        Form::registerBuiltinFields();

        Grid::registerColumnDisplayer();

        if (file_exists($bootstrap = admin_path('bootstrap.php'))) {
            require $bootstrap;
        }

        if (!empty(Admin::$booting)) {
            foreach (Admin::$booting as $callable) {
                call_user_func($callable);
            }
        }

        $this->injectFormAssets();

        if (!empty(Admin::$booted)) {
            foreach (Admin::$booted as $callable) {
                call_user_func($callable);
            }
        }

        return $next($request);
    }

    /**
     * Inject assets of all form fields.
     */
    protected function injectFormAssets()
    {
        $assets = Form::collectFieldAssets();

        Admin::css($assets['css']);
        Admin::js($assets['js']);
    }
}
