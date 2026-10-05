<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** group => [key => [label, type]] */
    public const SCHEMA = [
        'Company' => [
            'company_name' => ['Company name', 'text'],
            'tagline' => ['Tagline', 'text'],
            'about_intro' => ['About us (intro; blank line = new paragraph)', 'textarea'],
            'team_intro' => ['Team introduction', 'textarea'],
            'vision' => ['Vision', 'textarea'],
            'mission' => ['Mission', 'textarea'],
            'values' => ['Values (one per line)', 'textarea'],
            'objectives' => ['Quality objectives (one per line)', 'textarea'],
        ],
        'Contact details' => [
            'email' => ['Public email', 'text'],
            'notify_email' => ['Send quote & contact notifications to', 'text'],
            'hotline' => ['Hotline', 'text'],
            'whatsapp' => ['WhatsApp number (digits only, with country code)', 'text'],
            'phone_head_office' => ['Head office phones', 'text'],
            'phone_jkia' => ['JKIA office phones', 'text'],
            'address_head_office' => ['Head office address', 'text'],
            'address_jkia' => ['JKIA office address', 'text'],
            'po_box' => ['Postal address', 'text'],
            'hours' => ['Opening hours', 'text'],
        ],
        'Rates page' => [
            'vat_note' => ['Rates footnote / VAT note', 'textarea'],
            'grace_air' => ['Air freight grace period', 'text'],
            'grace_sea' => ['Sea freight grace period', 'text'],
        ],
        'Social media' => [
            'facebook' => ['Facebook URL', 'text'],
            'linkedin' => ['LinkedIn URL', 'text'],
            'twitter' => ['X / Twitter URL', 'text'],
        ],
    ];

    public function edit()
    {
        return view('admin.settings', ['schema' => self::SCHEMA, 'values' => Setting::map()]);
    }

    public function update(Request $request)
    {
        $values = [];
        foreach (self::SCHEMA as $fields) {
            foreach ($fields as $key => $_) {
                $values[$key] = $request->input($key);
            }
        }
        Setting::put($values);
        return back()->with('success', 'Settings saved.');
    }
}
