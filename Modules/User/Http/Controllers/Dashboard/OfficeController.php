<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Transformers\Dashboard\OfficeResource;
use Modules\User\Repositories\Dashboard\OfficeRepository as User;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class OfficeController extends Controller
{

    function __construct(User $user , Role $role)
    {
        $this->role = $role;
        $this->user = $user;
    }

    public function index()
    {
        return view('user::dashboard.offices.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));

        $datatable['data'] = OfficeResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    
}
