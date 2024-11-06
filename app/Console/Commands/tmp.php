<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;

class tmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tmp';

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
        // $str = encrypt('Hello World');
        $str = decrypt('eyJpdiI6ImNJcE44MGorZHN1dmZ3UVRXVDRKR3c9PSIsInZhbHVlIjoibmRRZ3BvRWNXRmpQY0EzWmFlaUo5akpqK2ZBdVJyUTFlNm9TL2NUenRRK2k0d0ZhQVRXRllWc1lDTmhLQWh2QTdLYmlXR2xEaWdxeFpEUzBRM1VLWFlBK0JlbCt1TWtuWWZIT014NjdMNXFtVFRYOGFKOFpORmJJODZCc0w3ejh1enVFM2t2R2dMUmJUWi84VUJtbzhiVGhIemtEaHJLRUNTWHNlekI4VklyYzN0dzI4cnBPSkFBS2tHSmRMMEdVZmxVWDNXSnlLMnB1L0t3WDkxVmxNNk5PY0Y4MGFFVTJ3L2lUYTZMWm03Tyt5c0V3eDZsZVB3UmpxM3lwaUM3em5CdWc1d1RCTkdrRWNOV3UyR0VucUE9PSIsIm1hYyI6ImUxNDdjMjNmMTRkYWJiZjQ4ZDQyMTIwYzlhZTllMzU1ZDJkYTE1MjY2MjI4NWI0ZTJmMmNkODBmZjdlNTJjNGUiLCJ0YWciOiIifQ==');
        $this->info($str);
    }
}
