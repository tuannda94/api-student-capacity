<?php

namespace App\Console\Commands;

use App\Models\Enterprise;
use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncEnterpriseInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:enterprise {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data (contact name, contact email, contact phone, tax number) from post to enterprises';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recruitmentPosts = Post::whereNotNull('code_recruitment')->get();
        $enterprises = Enterprise::all();
        $count = 0;

        try {
            DB::beginTransaction();
            foreach ($enterprises as $e) {
                $recruitmentPost = $recruitmentPosts->first(function ($item, $key) use ($e) {
                    return $item->enterprise_id === $e->id;
                });
                
                if ($recruitmentPost) {
                    $e->update([
                        'tax_number' => $recruitmentPost->tax_number ?: null,
                        'contact_name' => $recruitmentPost->contact_name ?: null,
                        'contact_phone' => $recruitmentPost->contact_phone ?: null,
                        'contact_email' => $recruitmentPost->contact_email ?: null,
                    ]);
    
                    $count += 1;
                    $this->info(PHP_EOL." - Synced successfully for $e->name enterprise!");
                }
            }

            if ($this->option('dry-run')) {
                DB::rollBack();
            } else {
                DB::commit();
            }
            $this->info(PHP_EOL.'===> Sync success '.$count.' enterprises');
        } catch (Exception $exception) {
            DB::rollBack();
            dump($exception);
        }
    }
}
