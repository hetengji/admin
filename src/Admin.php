<?php

namespace Evaluation\Admin;

use Closure;
use Evaluation\Admin\Auth\Database\Menu;
use Evaluation\Admin\Layout\Content;
use Evaluation\Admin\Traits\HasAssets;
use Evaluation\Admin\Widgets\Navbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

/**
 * Class Admin.
 */
class Admin
{
    use HasAssets;

    /**
     * The Laravel admin version.
     *
     * @var string
     */
    const VERSION = '1.6.1';

    /**
     * @var Navbar
     */
    protected $navbar;

    /**
     * @var array
     */
    public static $extensions = [];

    /**
     * @var []Closure
     */
    public static $booting;

    /**
     * @var []Closure
     */
    public static $booted;

    /**
     * Returns the long version of Laravel-admin.
     *
     * @return string The long application version
     */
    public static function getLongVersion()
    {
        return sprintf('Laravel-admin <comment>version</comment> <info>%s</info>', self::VERSION);
    }

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \Evaluation\Admin\Grid
     *
     * @deprecated since v1.6.1
     */
    public function grid($model, Closure $callable)
    {
        return new Grid($this->getModel($model), $callable);
    }

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \Evaluation\Admin\Form
     *
     *  @deprecated since v1.6.1
     */
    public function form($model, Closure $callable)
    {
        return new Form($this->getModel($model), $callable);
    }

    /**
     * Build a tree.
     *
     * @param $model
     *
     * @return \Evaluation\Admin\Tree
     */
    public function tree($model, Closure $callable = null)
    {
        return new Tree($this->getModel($model), $callable);
    }

    /**
     * Build show page.
     *
     * @param $model
     * @param mixed $callable
     *
     * @return Show
     *
     * @deprecated since v1.6.1
     */
    public function show($model, $callable = null)
    {
        return new Show($this->getModel($model), $callable);
    }

    /**
     * @param Closure $callable
     *
     * @return \Evaluation\Admin\Layout\Content
     *
     * @deprecated since v1.6.1
     */
    public function content(Closure $callable = null)
    {
        return new Content($callable);
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getModel($model)
    {
        if ($model instanceof Model) {
            return $model;
        }

        if (is_string($model) && class_exists($model)) {
            return $this->getModel(new $model());
        }

        throw new InvalidArgumentException("$model is not a valid model");
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function menu()
    {
        return (new Menu())->toTree();
    }

    /**
     * Get admin title.
     *
     * @return Config
     */
    public function title()
    {
        return config('admin.title');
    }

    /**
     * Get current login user.
     *
     * @return mixed
     */
    public function user()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Set navbar.
     *
     * @param Closure|null $builder
     *
     * @return Navbar
     */
    public function navbar(Closure $builder = null)
    {
        if (is_null($builder)) {
            return $this->getNavbar();
        }

        call_user_func($builder, $this->getNavbar());
    }

    /**
     * Get navbar object.
     *
     * @return \Evaluation\Admin\Widgets\Navbar
     */
    public function getNavbar()
    {
        if (is_null($this->navbar)) {
            $this->navbar = new Navbar();
        }

        return $this->navbar;
    }

    /**
     * Register the auth routes.
     *
     * @return void
     */
    public function registerAuthRoutes()
    {
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'namespace'  => 'Evaluation\Admin\Controllers',
        ];
        app('router')->group($attributes, function ($router) {

            /* @var \Illuminate\Routing\Router $router */
            $router->group([], function ($router) {
                /* @var \Illuminate\Routing\Router $router */
                // TODO 此处 编写内部路由
                $router->resource('subject','SubjectController');
                $router->resource('dimension','DimensionController');
            });
        });
        // TODO 整理一步步删除 先注释
//        $attributes = [
//            'prefix'     => config('admin.route.prefix'),
//            'namespace'  => 'Evaluation\Admin\Controllers',
//            'middleware' => config('admin.route.middleware'),
//        ];
//        app('router')->group($attributes, function ($router) {
//
//            /* @var \Illuminate\Routing\Router $router */
//            $router->group([], function ($router) {
//                /* @var \Illuminate\Routing\Router $router */
//                $router->resource('auth/users', 'UserController');
//                $router->resource('auth/roles', 'RoleController');
//                $router->resource('auth/permissions', 'PermissionController');
//                $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);
//                $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']]);
//                $router->resource('subject','SubjectController');
//            });
//            $router->get('/', 'HomeController@index');
//            $router->get('auth/login', 'AuthController@getLogin');
//            $router->post('auth/login', 'AuthController@postLogin');
//            $router->get('auth/logout', 'AuthController@getLogout');
//            $router->get('auth/setting', 'AuthController@getSetting');
//            $router->put('auth/setting', 'AuthController@putSetting');
//
//        });
    }

    /**
     * Extend a extension.
     *
     * @param string $name
     * @param string $class
     *
     * @return void
     */
    public static function extend($name, $class)
    {
        static::$extensions[$name] = $class;
    }

    /**
     * @param callable $callback
     */
    public static function booting(callable $callback)
    {
        static::$booting[] = $callback;
    }

    /**
     * @param callable $callback
     */
    public static function booted(callable $callback)
    {
        static::$booted[] = $callback;
    }

    /*
     * Disable Pjax for current Request
     *
     * @return void
     */
    public function disablePjax()
    {
        if (request()->pjax()) {
            request()->headers->set('X-PJAX', false);
        }
    }
}