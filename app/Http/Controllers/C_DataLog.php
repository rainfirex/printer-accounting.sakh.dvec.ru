<?php

namespace App\Http\Controllers;

use App\Modules\PrintLogger;
use Illuminate\Http\Request;

class C_DataLog extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('gets', 'getCountPage', 'find', 'count');
    }

    public function gets(int $page) {
        $limit = 20;
//        $count = PrintLogger::count();

        $offset = ($page * $limit) - $limit;
//        $countPage = ceil( $count / $limit);

        $logs = PrintLogger::limit($offset, $limit);

        $logs->load([
            'user' => function($query) {
                $query->select('id', 'name', 'email', 'phone', 'title', 'last_ip', 'user_agent');
            },
            'event'
        ]);
        return response()->json([
            'logs' => $logs
        ]);
    }

    public function getCountPage() {
        $limit = 20;
        $count = PrintLogger::count();
        $countPage = ceil( $count / $limit);
        return response()->json([
            'count'=>$countPage
        ]);
    }

    public function find(string $text, string $type) {
        $logs = PrintLogger::find($text, $type);
        $logs->load([
            'user' => function($query) {
                $query->select('id', 'name', 'email', 'phone', 'title', 'last_ip', 'user_agent');
            },
            'event'
        ]);
        return response()->json([
            'logs'=>$logs
        ]);
    }

    public function count() {
        $count = PrintLogger::count();
        return response()->json([
            'count' => $count
        ]);
    }
}
