<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! TerraCore will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return array (
  'agricultural-nutrient' => 
  array (
    'title' => 'Agricultural Nutrient Analysis',
    'summary' => 'N-P-K, micronutrients, pH, and organic matter panels for row-crop and specialty growers.',
    'body' => 'TerraCore runs nutrient panels that Iowa growers actually use — grid sampling support, fertility recommendations, and turnaround timed to spring planting windows across Central Iowa.',
    'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1600&q=80',
  ),
  'construction-compaction' => 
  array (
    'title' => 'Construction Compaction Testing',
    'summary' => 'Nuclear density and Proctor-backed compaction verification for fills and structural pads.',
    'body' => 'GCs call us when embankments and building pads need documented density. We pair field tests with lab Proctors so inspectors sign off without rework loops.',
    'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1600&q=80',
  ),
  'contamination-screening' => 
  array (
    'title' => 'Soil Contamination Screening',
    'summary' => 'Petroleum, metals, and pesticide screens for property transfers and spill response.',
    'body' => 'When a deal or spill needs answers fast, TerraCore screens soils for TPH, RCRA metals, and common ag chemicals with chain-of-custody tracking from field to bench.',
    'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80',
  ),
  'geotech-index' => 
  array (
    'title' => 'Geotechnical Index Testing',
    'summary' => 'Atterberg limits, grain size, moisture, and classification for geotech partners.',
    'body' => 'We support Midwest geotech firms with reliable index testing — moisture, Atterberg, sieve/hydrometer, and USCS classification that feeds foundation and pavement recommendations.',
    'image' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1600&q=80',
  ),
  'landfill-cover' => 
  array (
    'title' => 'Landfill Cover Compliance',
    'summary' => 'Cover soil QA testing for municipal and private landfill operators.',
    'body' => 'Daily and intermediate cover specs fail when soil is too wet or poorly graded. TerraCore verifies cover materials against permit criteria so operators stay audit-ready.',
    'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80',
  ),
  'residential-garden' => 
  array (
    'title' => 'Residential Garden Soil Analysis',
    'summary' => 'Homeowner-friendly fertility and lead screens for gardens, lawns, and raised beds.',
    'body' => 'Des Moines homeowners get plain-language fertility advice and optional lead screening before planting — no agronomy jargon wall, just what to amend and why.',
    'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=1600&q=80',
  ),
);
    }
}