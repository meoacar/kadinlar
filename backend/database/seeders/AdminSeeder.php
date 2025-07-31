<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ZodiacSign;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user oluştur
        $adminZodiac = ZodiacSign::findByBirthDateSimple('1985-08-23'); // Başak burcu
        
        User::updateOrCreate(
            ['email' => 'admin@kadinlari.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Kadınlar Atlası',
                'email' => 'admin@kadinlari.com',
                'password' => Hash::make('admin123'),
                'birth_date' => '1985-08-23',
                'zodiac_sign_id' => $adminZodiac?->id,
                'role' => 'admin',
                'subscription_type' => 'creator',
                'is_active' => true,
                'email_verified' => true,
                'bio' => 'Kadınlar Atlası platformunun admin kullanıcısı. Astroloji ve kişisel gelişim uzmanı.'
            ]
        );

        // Test content creator user
        $creatorZodiac = ZodiacSign::findByBirthDateSimple('1990-03-21'); // Koç burcu
        
        User::updateOrCreate(
            ['email' => 'creator@kadinlari.com'],
            [
                'first_name' => 'Ayşe',
                'last_name' => 'Yıldız',
                'email' => 'creator@kadinlari.com',
                'password' => Hash::make('creator123'),
                'birth_date' => '1990-03-21',
                'zodiac_sign_id' => $creatorZodiac?->id,
                'role' => 'creator',
                'subscription_type' => 'gold',
                'is_active' => true,
                'email_verified' => true,
                'bio' => 'İçerik yaratıcısı ve astroloji uzmanı.'
            ]
        );

        // Test regular users with different zodiac signs
        $testUsers = [
            ['name' => 'Fatma Güler', 'birth' => '1992-06-15', 'role' => 'user', 'sub' => 'silver'],
            ['name' => 'Zeynep Aksoy', 'birth' => '1988-11-30', 'role' => 'user', 'sub' => 'gold'],
            ['name' => 'Merve Demir', 'birth' => '1995-02-14', 'role' => 'user', 'sub' => 'free'],
            ['name' => 'Selin Kaya', 'birth' => '1991-09-10', 'role' => 'user', 'sub' => 'silver'],
            ['name' => 'Deniz Özer', 'birth' => '1993-12-05', 'role' => 'user', 'sub' => 'free'],
        ];

        foreach ($testUsers as $userData) {
            $names = explode(' ', $userData['name']);
            $zodiac = ZodiacSign::findByBirthDateSimple($userData['birth']);
            
            User::updateOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $userData['name'])) . '@test.com'],
                [
                    'first_name' => $names[0],
                    'last_name' => $names[1],
                    'email' => strtolower(str_replace(' ', '.', $userData['name'])) . '@test.com',
                    'password' => Hash::make('test123'),
                    'birth_date' => $userData['birth'],
                    'zodiac_sign_id' => $zodiac?->id,
                    'role' => $userData['role'],
                    'subscription_type' => $userData['sub'],
                    'is_active' => true,
                    'email_verified' => true
                ]
            );
        }
    }
}
