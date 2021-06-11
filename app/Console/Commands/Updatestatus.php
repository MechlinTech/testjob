<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supports;
use App\Models\Messages;
class Updatestatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of the Support ticket after 24 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_supports = Supports::where('updated_at', '<=', \Carbon\Carbon::now()->subDays(1)->toDateTimeString())->get();
        foreach ($all_supports as $supports) {
            $getLastMsg = Messages::where('support_id',$supports->id)->orderBy('created_at', 'desc')->first();
            if($supports->user_id != $getLastMsg->user_id){
                $supports->status = "Answered";
                $supports->save();
            }
        }
        $this->info('Status for all older support is changed');
    }
}
