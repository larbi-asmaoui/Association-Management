<?php

namespace App\Console\Commands;

use App\Models\Abonnement;
use Illuminate\Console\Command;

class CheckAbonnementStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-abonnement-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription status and set member as inactive if expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $abonnemets = Abonnement::where('date_fin', '<', now())->get();
        // foreach ($abonnemets as $abonnement) {
        //     $abonnement->adherent->update(['is_actif' => false]);
        // }

        // $this->info('Abonnemets status checked and adherent status updated.');
    }
}
