<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Entities\Post;
use Modules\Template\Entities\Template;
use Modules\Document\DataTables\DocumentDataTable;
use Modules\TemplateCategory\Entities\TemplateCategory;

class DashboardController extends Controller
{
    /**
     * Constructor for the controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'status_check'])->except(['redirectToDashboard']);
        \cs_set('theme', [
            'title'      => 'Dashboard',
            'back'       => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => false,
                ],

            ],
            'rprefix'    => 'admin.dashboard',
        ]);
    }

    public function index(Request $request)
    {
        $checkFreeUser = Post::isFreeMembership();

        return view('dashboard', compact('checkFreeUser'));
    }

    public function redirectToDashboard()
    {
        return redirect()->route('admin.dashboard');
    }
}