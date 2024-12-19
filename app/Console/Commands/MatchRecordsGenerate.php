<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Tournament;
use App\Models\Matches;
use App\Models\MatchRecords;
class MatchRecordsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:match-records-generate {id}';

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
        $matchId=$this->argument('id');
        for($i=0;$i<10;$i++){
            $matchRecords=MatchRecords::create([
               'match_id'=>$matchId,
                'home_team_score'=>rand(0,10),
                'opponent_team_score'=>rand(0,10)
            ]);
            if($i<10){
                sleep(2);
            }
        }
        $this->matchWinner();
    }

    public function matchWinner(){
        $match=Matches::with('matchRecords')->find($this->argument('id'));
        $homeTeamScore=$match->matchRecords->sum('home_team_score');
        $opponentScore=$match->matchRecords->sum('opponent_team_score');
        $homeTeamScore>=$opponentScore?($winTeamId=$match->home_team_id):($winTeamId=$match->opponent_team_id);
        $match->result_id=$winTeamId;
        $match->save();
    }
}
