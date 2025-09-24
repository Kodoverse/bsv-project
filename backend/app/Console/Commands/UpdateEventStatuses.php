<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;

class UpdateEventStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event statuses based on current time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating event statuses...');
        
        $updatedCount = Event::updateAllStatuses();
        
        if ($updatedCount > 0) {
            $this->info("Updated {$updatedCount} event statuses.");
        } else {
            $this->info('No event statuses needed updating.');
        }
        
        // Show current status distribution
        $statusCounts = Event::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
            
        $this->table(
            ['Status', 'Count'],
            $statusCounts->map(function ($count, $status) {
                return [$status, $count];
            })->values()->toArray()
        );
        
        return Command::SUCCESS;
    }
}