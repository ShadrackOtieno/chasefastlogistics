<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Rate;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Shipment;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Setting::put([
            'company_name' => 'Chase Fast Logistics Limited',
            'tagline' => 'Your Cargo in Good and Safe Hands',
            'email' => 'info@chasefastlogistics.com',
            'notify_email' => 'info@chasefastlogistics.com',
            'hotline' => '+254 750 974 699',
            'whatsapp' => '254750974699',
            'phone_head_office' => '+254 721 214 212 / +254 722 698 418',
            'phone_jkia' => '+254 737 214 212 / +254 733 258 617',
            'address_head_office' => 'Vision Plaza, 5th Floor, Suite 24, Mombasa Road, Nairobi',
            'address_jkia' => 'KAHL Building, 1st Floor, Suite 122, JKIA, Nairobi',
            'po_box' => 'P.O. Box 28197-00100, Nairobi, Kenya',
            'hours' => 'Mon - Fri: 8:00am - 5:00pm | Sat: 8:00am - 1:00pm',
            'facebook' => '',
            'linkedin' => '',
            'twitter' => '',
            'about_intro' => "Chase Fast Logistics Limited is a licensed clearing and forwarding firm handling freight by air, sea and land. Our clearing and exports are done at Jomo Kenyatta International Airport, Mombasa Seaport, the Inland Container Depots in Nairobi and Kisumu, and the borders of Kenya, Uganda and Southern Sudan.\n\nWe log entries for customs purposes so that the required duty, Value Added Tax and other government charges are paid, and we keep our clients updated on the day-to-day position of their shipments. We can track and trace most air and sea cargo, and we also provide warehousing, exports (air, sea and land) and bulk transport of goods countrywide and to Uganda, Rwanda and South Sudan.",
            'team_intro' => 'Our organisation is backed by highly experienced former Customs officers drawn from Kenya Ports Authority, Kenya Railways Corporation and Kenya Revenue Authority, alongside a workforce of young and highly professional managers and staff.',
            'vision' => 'To be the best clearing and forwarding firm globally.',
            'mission' => 'To be the firm of choice for facilitating the clearing and forwarding of goods and services, effectively and efficiently, globally.',
            'values' => "Corporate integrity: we maintain the highest ethical and moral standards.\nQuality people: we invest in staff with enthusiasm for excellence and a desire for advancement.\nSuperior service: we deliver exceptional value, consistent performance and creative logistics solutions.",
            'objectives' => "Continually improve client satisfaction with the effectiveness of our services in meeting client needs.\nContinually improve the timeliness with which our services are offered.\nEvaluate these objectives through client evaluations and analysis of process and service non-conformances.",
            'vat_note' => 'All of the above costs attract VAT at 16%. All taxes and other charges are to be settled by the importer. Rates are indicative and may vary by shipment; request a quote for exact pricing.',
            'grace_air' => '48 hours from the date of advice, after which storage charges begin to accrue.',
            'grace_sea' => '4 days from the date of arrival, after which storage charges begin to accrue.',
        ]);

        $services = [
            ['Air Freight', 'air', 'plane', 'Import and export by air: consolidation, charter, break-bulk and IATA direct services, plus courier from the UK, USA, Canada, China, Asia and the Middle East.',
                "We move your cargo by air, worldwide, with full customs clearance at JKIA and onward forwarding to the final destination.",
                "Export consolidation traffics\nCharter services worldwide\nSea / air traffic\nBreak bulk services worldwide\nIATA direct services\nImport consolidation traffics\nCourier services from UK, USA, Canada, China, Asia and the Middle East\nCustoms clearance\nOnward forwarding to final destination by air or truck\nInternational freight forwarding services"],
            ['Sea Freight', 'sea', 'ship', 'FCL and break-bulk services worldwide, consolidation, and contract accounts for special clients to particular destinations.',
                "Whether you ship a single container or run a regular programme, we handle bookings, documentation, port clearance and delivery through Mombasa Seaport.",
                "Export consolidation traffics\nFCL service worldwide\nBreak bulk services worldwide\nContract accounts for special clients to particular destinations\nClearing at Mombasa Seaport and onward transport to Nairobi ICD"],
            ['Overland Transport', 'land', 'truck', 'Full truck-load and consolidated transport across Kenya and East Africa, including Uganda, Rwanda and South Sudan.',
                "Our overland division moves goods between every entry and exit point in Kenya and to destinations across East Africa.",
                "Full truck-load services to any destination in East Africa\nFull truck-load services from any destination in East Africa\nDomestic full truck-load services to and from all entry / exit points countrywide\nConsolidation traffics (export, import and domestic)\nBulk transport of goods to Uganda, Rwanda and South Sudan"],
            ['Customs Clearance', 'customs', 'file-check', 'Entries, duty and VAT processing and clearance at JKIA, Mombasa, ICD Nairobi/Kisumu and the Kenya, Uganda and Southern Sudan borders.',
                "Our team of former customs officers makes sure your entries are lodged correctly, duties are computed and paid, and your cargo is released quickly.",
                "Logging entries for customs purposes\nPayment of duty, VAT and other government charges\nClearance at JKIA, Mombasa Seaport, ICD Nairobi and Kisumu\nBorder clearance: Kenya, Uganda and Southern Sudan\nDay-to-day updates on the position of your shipments\nTrack and trace for most air and sea cargo"],
            ['Warehousing & Distribution', 'warehousing', 'warehouse', 'Secure storage of goods and distribution to your customers countrywide.',
                "We store your goods safely and distribute them on your schedule, with full visibility of stock movement.",
                "Secure warehousing of goods\nDistribution countrywide\nBonded and general cargo handling\nTransport to final destination"],
            ['Project Forwarding', 'projects', 'building', 'Turn-key, door-to-door forwarding of industrial projects worldwide for international principals and organisations.',
                "We plan and execute complex project cargo movements, including services abroad and in the country of destination.",
                "Forwarding of industrial projects worldwide\nTurn-key (door-to-door) basis, including services abroad and in the country of destination\nFrom multinational areas of supply\nFor international principals and organisations"],
        ];
        foreach ($services as $i => [$title, $cat, $icon, $summary, $body, $features]) {
            Service::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($title)], [
                'title' => $title, 'category' => $cat, 'icon' => $icon, 'summary' => $summary,
                'body' => $body, 'features' => $features, 'sort_order' => $i + 1, 'is_active' => true,
            ]);
        }

        Rate::query()->delete();
        $rates = [
            ['Air Freight', 'Agency fees (airfreight shipments only)', 10000, 'per shipment', null],
            ['Air Freight', 'Transportation', 7, 'per kg', 'Minimum KES 4,500'],
            ['Air Freight', 'IDF processing', 1000, 'per shipment', null],
            ['Air Freight', 'Documentation', 2000, 'per shipment', null],
            ['Sea Freight: FCL imports (Mombasa / ICD Nairobi)', 'Agency fees, 20ft container', 23000, 'per container', null],
            ['Sea Freight: FCL imports (Mombasa / ICD Nairobi)', 'Agency fees, 40ft container', 28000, 'per container', null],
            ['Sea Freight: FCL imports (Mombasa / ICD Nairobi)', 'Documentation', 5000, 'per shipment', null],
            ['Transport: Mombasa to Nairobi', '20ft container', 85000, 'per container', null],
            ['Transport: Mombasa to Nairobi', '40ft container', 95000, 'per container', null],
        ];
        foreach ($rates as $i => [$cat, $item, $amt, $unit, $note]) {
            Rate::create(['category' => $cat, 'item' => $item, 'amount' => $amt, 'unit' => $unit, 'note' => $note, 'sort_order' => $i + 1]);
        }

        Client::query()->delete();
        foreach (['CTL Tractor and Spareparts Limited', 'Anatolia Construction Limited', 'Electrical and Carbon Products Marketing Limited', 'Tramex Mediquip Limited', 'Hayat Kimya Kenya Hygienic Products Limited', 'Kenafric Industries Limited'] as $i => $name) {
            Client::create(['name' => $name, 'sort_order' => $i + 1]);
        }

        TeamMember::query()->delete();
        TeamMember::create(['name' => 'Charity M. Nganda', 'title' => 'Director', 'phone' => '+254 721 214 212', 'sort_order' => 1]);
        TeamMember::create(['name' => 'Shadrack M. Mwangangi', 'title' => 'Managing Director', 'phone' => '+254 722 698 418', 'sort_order' => 2]);

        // Demo shipment so the tracking page can be tried straight away. Delete it from the back office when going live.
        if (! Shipment::where('tracking_number', 'CFL-DEMO-001')->exists()) {
            $s = Shipment::create([
                'tracking_number' => 'CFL-DEMO-001', 'customer_name' => 'Demo Customer', 'mode' => 'sea',
                'origin' => 'Shanghai, China', 'destination' => 'Nairobi ICD', 'description' => '1 x 40ft container: demo shipment',
                'status' => 'customs_clearance', 'current_location' => 'Mombasa Seaport', 'eta' => now()->addDays(3),
            ]);
            $s->events()->create(['status' => 'booked', 'location' => 'Shanghai, China', 'note' => 'Shipment booked', 'occurred_at' => now()->subDays(24)]);
            $s->events()->create(['status' => 'in_transit', 'location' => 'Indian Ocean', 'note' => 'Vessel departed', 'occurred_at' => now()->subDays(20)]);
            $s->events()->create(['status' => 'arrived', 'location' => 'Mombasa Seaport', 'note' => 'Vessel berthed, discharge complete', 'occurred_at' => now()->subDays(2)]);
            $s->events()->create(['status' => 'customs_clearance', 'location' => 'Mombasa Seaport', 'note' => 'Entry lodged with KRA, duty assessment in progress', 'occurred_at' => now()->subDay()]);
        }
    }
}
