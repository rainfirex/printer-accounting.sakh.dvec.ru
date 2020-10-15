<?php namespace App\Modules;

use App\ActionEvent;
use App\Models\PrintLog;

class PrintLogger
{
    public static function commit(string $host, int $eventId, string $data, string $userId): void {
        try{
            $log = new PrintLog();
            $log->host     = $host;
            $log->user_id  = $userId;
            $log->event_id = $eventId;
            $log->data     = $data;
            $log->save();
        }
        catch (\Exception $ex) {
            var_dump($ex->getMessage()); exit;
        }
    }

    public static function reads(): array {
        return PrintLog::all()->sortByDesc('id')->values()->all();
    }

    public static function count(): int {
        return PrintLog::all()->count();
    }

    public static function limit(int $offset, int $limit){
//        return PrintLog::offset($offset)->limit($limit)->get()->sortByDesc('id')->values()->all();
//        return PrintLog::offset($offset)->limit($limit)->get();

        return PrintLog::offset($offset)
            ->limit($limit)
            ->orderBy('id','DESC')
            ->get();
    }

    public static function find(string $text, string $type) {
        $eventId = ActionEvent::where('event', '=', $type)->first()->id;

        if ($eventId === 1) {
            $logs = PrintLog::where('data', 'LIKE', '%'.trim($text).'%')->orderBy('id', 'DESC')->get();
        } else {
            $logs = PrintLog::where([
                ['event_id', '=', $eventId],
                ['data', 'LIKE', '%'.trim($text).'%']
            ])->orderBy('id', 'DESC')->get();
        }

        return $logs;
    }
}
