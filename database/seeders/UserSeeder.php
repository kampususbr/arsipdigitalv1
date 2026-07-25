<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@usbr.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'unit_kerja' => 'IT Department',
                'jabatan' => 'Administrator',
                'status' => 'active',
            ]
        );
        $admin->assignRole('admin');

        // Create Manager User
        $manager = User::firstOrCreate(
            ['email' => 'manager@usbr.ac.id'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password'),
                'phone' => '081234567891',
                'unit_kerja' => 'General Affairs',
                'jabatan' => 'Document Manager',
                'status' => 'active',
            ]
        );
        $manager->assignRole('manager');

        // Create User
        $user = User::firstOrCreate(
            ['email' => 'user@usbr.ac.id'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'unit_kerja' => 'Academic Affairs',
                'jabatan' => 'Staff',
                'status' => 'active',
            ]
        );
        $user->assignRole('user');

        // Create Viewer User
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@usbr.ac.id'],
            [
                'name' => 'Viewer Only',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'unit_kerja' => 'Public Relations',
                'jabatan' => 'Guest',
                'status' => 'active',
            ]
        );
        $viewer->assignRole('viewer');
    }
}
