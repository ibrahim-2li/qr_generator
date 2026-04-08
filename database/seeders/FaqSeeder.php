<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question'=>'What’s the difference between static and dynamic QR codes?',
            'answer'  =>'Static QR codes can’t be edited after creation. Dynamic QR codes can be updated (URL/content) without reprinting and include scan analytics.',
            'sort_order' => 1,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'Which QR code types do you support?',
            'answer'  =>'URL, Text, Wi‑Fi, vCard/Contact, Email, Phone, SMS, PDF/file, and custom redirects (based on your plan).',
            'sort_order' => 2,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'How do I create my first QR code?',
            'answer'  =>'Go to Dashboard → Create QR → choose type → fill content → customize style → save. Then download or print.',
            'sort_order' => 3,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'Can I update the destination after printing?',
            'answer'  =>'Yes, for dynamic QR codes. Open the QR → Edit → change the target → Save.',
            'sort_order' => 4,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'Where can I see scan analytics?',
            'answer'  =>'Dashboard → Analytics or your QR’s details page. You’ll see total scans, unique scans, devices, locations, and trends.',
            'sort_order' => 5,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'Why doesn’t my QR code scan?',
            'answer'  =>'Ensure high contrast (dark code on light background), sufficient size, clear print, and no excessive logo coverage. Increase error correction if needed.',
            'sort_order' => 6,
            'is_active' => 1
        ]);

        Faq::create([
            'question'=>'Are there limits on scans or QR codes?',
            'answer'  =>'Limits depend on your plan (number of dynamic QRs, monthly scans, file size). See Pricing or My Subscription.',
            'sort_order' => 7,
            'is_active' => 1
        ]);
    }
}
