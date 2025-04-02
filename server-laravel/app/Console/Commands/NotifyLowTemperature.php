<?php

namespace App\Console\Commands;

use App\Models\Coop;
use App\Notifications\UserNotification;
use Illuminate\Console\Command;

class NotifyLowTemperature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-low-temperature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users when their coop temperature is below 10';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //todo : na disinilah nantinya cloud messagenya akan
        // dieksekusi
        // disini akan berjalan beriringan
        // notify user dari cloud message dan juga
        // kita akan simpan ke tabel notifications

        // Get all coops with temperature below 10
        $coops = Coop::where('temp', '<', 10)->with('user')->get();

        foreach ($coops as $coop) {
            $user = $coop->user;

            if ($user) {
                // Send notification to the user
                $user->notify(new UserNotification("The temperature of your coop '{$coop->name}' is below 10°C."));
            }
        }

        $this->info('Notifications sent to users with low-temperature coops.');
    }
}
