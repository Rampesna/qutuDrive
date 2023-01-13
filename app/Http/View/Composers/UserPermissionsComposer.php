<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class UserPermissionsComposer
{
    /**
     * @var mixed $permissions
     */
    protected $permissions;

    public function __construct()
    {
        $this->permissions = auth()->guard('user_web')->check() ? auth()->user()->permissions()->pluck('id')->toArray() : [];
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('permissions', $this->permissions);
    }
}
