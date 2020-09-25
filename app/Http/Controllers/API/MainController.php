<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contacts\Client;
use App\Model\Projects\Project;
use App\Model\Tasks\Task;
use App\User;

class MainController extends Controller
{
    public function dashboardData() {
        $data = [];

        $data['clients'] = Client::count();
        $data['projects'] = Project::count();
        $data['tasks'] = Task::count();
        $data['users'] = User::count();

        return response()->json($data);
    }
}
