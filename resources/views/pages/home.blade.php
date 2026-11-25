@extends('layouts.app')

@section('title', 'TerraCore Soil Labs')
@section('meta_description', 'TerraCore Soil Labs — Agricultural, construction & contamination soil testing for Iowa & the Midwest')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>TerraCore<br>Soil Labs</h1>
        <p>Defensible agricultural, construction, and contamination soil testing — timed for Iowa planting windows, pad pours, and property closings.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book lab intake</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View testing services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">From grid fertility panels to nuclear density QA — lab and field packages sized for growers, GCs, and municipalities.</p>
        <div class="grid-3">
            @foreach([
                ['agricultural-nutrient','Agricultural Nutrient Analysis','N-P-K, micronutrients, pH, and organic matter panels for row-crop and specialty growers.','https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1600&q=80'],
                ['construction-compaction','Construction Compaction Testing','Nuclear density and Proctor-backed compaction verification for fills and structural pads.','https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1600&q=80'],
                ['contamination-screening','Soil Contamination Screening','Petroleum, metals, and pesticide screens for property transfers and spill response.','https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why TerraCore</h2>
        <p class="lede">Analysts and field techs who treat sample integrity, turnaround, and readable reports as part of the same deliverable.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Grower-ready reports</h3>
                <p>Fertility recommendations written for Iowa operators — not just raw ppm tables.</p>
            </div>
            <div class="panel">
                <h3>Construction QA speed</h3>
                <p>Proctor pairs and nuclear density documented so inspectors can sign off without rework loops.</p>
            </div>
            <div class="panel">
                <h3>ERP-run lab ops</h3>
                <p>Jobs, kit inventory, invoices, and field appointments live in one stack.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the TerraCore ERP used to schedule field density, track sample kits, and close lab invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>41</strong> Active jobs</div>
                    <div class="metric"><strong>$98k</strong> Pipeline</div>
                    <div class="metric"><strong>97%</strong> On-time reports</div>
                </div>
                <div class="bars">
                    <span style="height:45%"></span><span style="height:70%"></span><span style="height:55%"></span>
                    <span style="height:85%"></span><span style="height:60%"></span><span style="height:92%"></span>
                    <span style="height:68%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0;font-size:1.4rem">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Lab jobs & field scheduling</li>
                    <li>Sample kit inventory</li>
                    <li>Invoices & panel fees</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the lab bench</h2>
        <p class="lede">Practical notes for growers, GCs, and homeowners facing soil decisions.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection