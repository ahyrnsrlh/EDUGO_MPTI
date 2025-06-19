<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class XenditSettingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Check if settings table exists first
        if (!DB::getSchemaBuilder()->hasTable('settings')) {
            $this->command->info('Settings table does not exist. Skipping Xendit settings seeder.');
            return;
        }
        
        // Insert sample settings for Xendit
        // Note: In production, these should be set via environment variables
        $settings = [
            [
                'key' => 'xendit_secret_key',
                'value' => 'xnd_development_secret_key_here',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'xendit_public_key', 
                'value' => 'xnd_public_development_key_here',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'xendit_webhook_token',
                'value' => 'webhook_verification_token_here',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'xendit_is_production',
                'value' => 'false',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'default_payment_gateway',
                'value' => 'xendit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Xendit settings seeded successfully!');
    }
}
