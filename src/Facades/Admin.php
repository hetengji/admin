<?php

namespace Evaluation\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Admin.
 *
 * @method static \Evaluation\Admin\Grid grid($model, \Closure $callable)
 * @method static \Evaluation\Admin\Form form($model, \Closure $callable)
 * @method static \Evaluation\Admin\Show show($model, $callable = null)
 * @method static \Evaluation\Admin\Tree tree($model, \Closure $callable = null)
 * @method static \Evaluation\Admin\Layout\Content content(\Closure $callable = null)
 * @method static \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void css($css = null)
 * @method static \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void js($js = null)
 * @method static \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void script($script = '')
 * @method static \Illuminate\Contracts\Auth\Authenticatable|null user()
 * @method static string title()
 * @method static void navbar(\Closure $builder = null)
 * @method static void registerAuthRoutes()
 * @method static void extend($name, $class)
 * @method static void disablePjax()
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Evaluation\Admin\Admin::class;
    }
}
