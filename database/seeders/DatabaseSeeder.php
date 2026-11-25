<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(515) 555-0167',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@terracoresoil.com'],
            [
                'name' => 'Hannah Briggs',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(515) 555-0167',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'field@terracoresoil.com'],
            [
                'name' => 'Omar Delgado',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(515) 555-0167',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'TerraCore Soil Labs',
            'company_phone' => '(515) 555-0167',
            'company_email' => 'lab@terracoresoil.com',
            'whatsapp' => '15155550167',
            'service_area' => 'Des Moines, Ames, Ankeny, Cedar Rapids & Central Iowa',
            'tax_rate' => '7.00',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = array (
  0 => 
  array (
    'name' => 'Ag Nutrient Panel — Standard',
    'sku' => 'SOIL-AG-STD',
    'category' => 'ag',
    'unit_cost' => 8,
    'unit_price' => 28,
    'stock_qty' => 999,
    'unit' => 'sample',
  ),
  1 => 
  array (
    'name' => 'Ag Nutrient Panel — Complete',
    'sku' => 'SOIL-AG-CMP',
    'category' => 'ag',
    'unit_cost' => 14,
    'unit_price' => 48,
    'stock_qty' => 999,
    'unit' => 'sample',
  ),
  2 => 
  array (
    'name' => 'Proctor Compaction Test',
    'sku' => 'SOIL-PRO-1',
    'category' => 'construction',
    'unit_cost' => 35,
    'unit_price' => 95,
    'stock_qty' => 999,
    'unit' => 'test',
  ),
  3 => 
  array (
    'name' => 'Nuclear Gauge Day Rate',
    'sku' => 'SOIL-NUC-D',
    'category' => 'construction',
    'unit_cost' => 120,
    'unit_price' => 350,
    'stock_qty' => 4,
    'unit' => 'day',
  ),
  4 => 
  array (
    'name' => 'TPH Contamination Screen',
    'sku' => 'SOIL-TPH-1',
    'category' => 'contamination',
    'unit_cost' => 42,
    'unit_price' => 120,
    'stock_qty' => 999,
    'unit' => 'sample',
  ),
  5 => 
  array (
    'name' => 'RCRA Metals Package',
    'sku' => 'SOIL-MET-8',
    'category' => 'contamination',
    'unit_cost' => 55,
    'unit_price' => 145,
    'stock_qty' => 999,
    'unit' => 'sample',
  ),
  6 => 
  array (
    'name' => 'Atterberg Limits Set',
    'sku' => 'SOIL-ATT-1',
    'category' => 'geotech',
    'unit_cost' => 28,
    'unit_price' => 75,
    'stock_qty' => 999,
    'unit' => 'set',
  ),
  7 => 
  array (
    'name' => 'Garden Kit + Lead Screen',
    'sku' => 'SOIL-GAR-L',
    'category' => 'residential',
    'unit_cost' => 12,
    'unit_price' => 49,
    'stock_qty' => 80,
    'unit' => 'kit',
  ),
);
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['is_active' => true]);
        }

        $customers = collect(array (
  0 => 
  array (
    'name' => 'Ruth Kellogg',
    'email' => 'ruth@prairieag.coop',
    'phone' => '(515) 555-2201',
    'company' => 'Prairie Ag Cooperative',
    'city' => 'Ames',
    'state' => 'IA',
    'zip' => '50010',
    'address' => '2140 S Duff Ave',
  ),
  1 => 
  array (
    'name' => 'Ben Stroud',
    'email' => 'ben@heartlandgc.com',
    'phone' => '(515) 555-2210',
    'company' => 'Heartland General Contractors',
    'city' => 'Des Moines',
    'state' => 'IA',
    'zip' => '50309',
    'address' => '400 Locust St',
  ),
  2 => 
  array (
    'name' => 'Clara Nguyen',
    'email' => 'clara@ankenyworks.gov',
    'phone' => '(515) 555-2299',
    'company' => 'City of Ankeny Public Works',
    'city' => 'Ankeny',
    'state' => 'IA',
    'zip' => '50023',
    'address' => '220 W 1st St',
  ),
  3 => 
  array (
    'name' => 'Joel Freese',
    'email' => 'joel.freese@example.com',
    'phone' => '(319) 555-2188',
    'company' => NULL,
    'city' => 'Cedar Rapids',
    'state' => 'IA',
    'zip' => '52404',
    'address' => '1820 16th Ave SW',
  ),
  4 => 
  array (
    'name' => 'Maya Ortiz',
    'email' => 'maya@midwestfill.com',
    'phone' => '(515) 555-2177',
    'company' => 'Midwest Fill & Cover LLC',
    'city' => 'Des Moines',
    'state' => 'IA',
    'zip' => '50313',
    'address' => '5055 NE 22nd St',
  ),
))->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = array (
  0 => 
  array (
    'customer' => 0,
    'title' => 'Spring grid nutrient sampling — 1,200 ac',
    'service_type' => 'ag_nutrient',
    'status' => 'scheduled',
    'sq_ft' => 1200,
    'quoted_amount' => 8400,
  ),
  1 => 
  array (
    'customer' => 1,
    'title' => 'Warehouse pad compaction QA',
    'service_type' => 'compaction',
    'status' => 'in_progress',
    'sq_ft' => 65000,
    'quoted_amount' => 5200,
  ),
  2 => 
  array (
    'customer' => 2,
    'title' => 'Municipal yard contamination screen',
    'service_type' => 'contamination',
    'status' => 'quoted',
    'sq_ft' => 18000,
    'quoted_amount' => 3900,
  ),
  3 => 
  array (
    'customer' => 3,
    'title' => 'Garden + lead screen — residential',
    'service_type' => 'residential',
    'status' => 'completed',
    'sq_ft' => 0,
    'quoted_amount' => 89,
    'final_amount' => 89,
  ),
  4 => 
  array (
    'customer' => 4,
    'title' => 'Landfill intermediate cover QA week',
    'service_type' => 'landfill',
    'status' => 'invoiced',
    'sq_ft' => 0,
    'quoted_amount' => 6100,
    'final_amount' => 6280,
  ),
);

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo soil testing job for TerraCore ERP. sq_ft stores acres or area where relevant.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.07, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * (1 + 0.07), 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * (1 + 0.07), 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'ach',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Field density — Heartland pad'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projectModels[1]->id,
                'type' => 'field_test',
                'starts_at' => now()->addDays(2)->setTime(7, 0),
                'ends_at' => now()->addDays(2)->setTime(11, 0),
                'status' => 'scheduled',
                'location' => $customers[1]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Grid sample intake — Prairie Ag'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'lab_intake',
                'starts_at' => now()->addDays(4)->setTime(8, 0),
                'ends_at' => now()->addDays(4)->setTime(10, 0),
                'status' => 'confirmed',
                'location' => $customers[0]->address,
            ]
        );

        $posts = array (
  0 => 
  array (
    'title' => 'Reading an Iowa Soil Test Before You Fertilizer',
    'excerpt' => 'pH, organic matter, and P-K numbers that actually change spring blend decisions.',
    'cover' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1400&q=80',
    'body' => 'A soil test is only useful if recommendations match your yield goals and manure credits. TerraCore reports spell out lime and nutrient needs in grower language — not just lab tables.',
  ),
  1 => 
  array (
    'title' => 'Why Compaction Failures Happen After a Wet Week',
    'excerpt' => 'Moisture content, lift thickness, and Proctor curves — what inspectors look for on Midwest pads.',
    'cover' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1400&q=80',
    'body' => 'Pushing fill when moisture sits above optimum is the fastest way to fail nuclear density. We help GCs time lifts and document Proctor pairs so rework stays rare.',
  ),
  2 => 
  array (
    'title' => 'Contamination Screens for Property Transfers',
    'excerpt' => 'When a Phase I flag or visible staining means you need soil answers before closing.',
    'cover' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1400&q=80',
    'body' => 'Targeted TPH and metals screens can clear — or confirm — concerns without a full Phase II campaign. Ask TerraCore how many borings match the recognized area of concern.',
  ),
);
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = array (
  0 => 
  array (
    'category' => 'issues',
    'title' => 'Sample bag unlabeled at intake',
    'body' => 'Quarantine the bag. Match field notes and GPS tags. Relabel only with collector confirmation. Document the correction before analysis begins.',
  ),
  1 => 
  array (
    'category' => 'issues',
    'title' => 'Compaction failing below 95% of Proctor',
    'body' => 'Check moisture vs optimum. Thin the lift. Recompact and retest. If material is out of spec, reject the load and update the job record.',
  ),
  2 => 
  array (
    'category' => 'guides',
    'title' => 'How to collect a garden soil sample',
    'body' => 'Sample 6–8 inches deep across the bed. Mix cores in a clean bucket. Air-dry overnight. Drop off or ship with the TerraCore kit form.',
  ),
  3 => 
  array (
    'category' => 'guides',
    'title' => 'Soil testing timeline from intake to report',
    'body' => 'Day 0: Intake & login.
Days 1–3: Prep and analysis.
Closeout: PDF report + invoice. Rush panels available for construction QA.',
  ),
  4 => 
  array (
    'category' => 'admin',
    'title' => 'Admin ERP quick start',
    'body' => 'Login at /admin with admin@example.com / password.
1. Add customers.
2. Create jobs with service type.
3. Schedule field tests and lab intake.
4. Invoice and record payments.
5. Use AI Studio for content.
6. Update Settings.',
  ),
  5 => 
  array (
    'category' => 'admin',
    'title' => 'Roles: Admin, Manager, Staff',
    'body' => 'Admin: full ERP + settings + users.
Manager: jobs, inventory, invoices, scheduling.
Staff: intake and field updates.',
  ),
  6 => 
  array (
    'category' => 'troubleshoot',
    'title' => 'Nuclear gauge out of calibration',
    'body' => 'Do not run density tests. Swap to a calibrated backup. Log the failure. Recertify before next use.',
  ),
  7 => 
  array (
    'category' => 'troubleshoot',
    'title' => 'Chatbot giving demo answers only',
    'body' => 'Add OPENAI_API_KEY or GEMINI_API_KEY to .env when you want live model replies.',
  ),
);
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}