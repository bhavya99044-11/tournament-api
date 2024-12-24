<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MatchRecords;
use Pusher\Pusher;
use App\Models\Matches;
use Illuminate\Support\Facades\Log;
class RecordsNotification extends Command
{
    public $data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:records-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $options = [
            'cluster' => config('app.pusher.cluster'),
            'useTLS' => true
        ];
        $pusher = new Pusher(
            config('app.pusher.key'),
            config('app.pusher.secret'),
            config('app.pusher.app_id'),
            $options
        );
        $this->data=MatchRecords::limit(10)->latest()->get();

         $response = $pusher->trigger('records-notification', 'RecordNotificationEvent', ['data' => $this->data]);
    }
}
