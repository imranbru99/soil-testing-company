@extends('layouts.app')
@section('title', 'TerraCore Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">From grid fertility panels to nuclear density QA — lab and field packages sized for growers, GCs, and municipalities.</p>
        <div class="grid-3">
            @foreach([
                ['agricultural-nutrient','Agricultural Nutrient Analysis','https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1600&q=80'],
                ['construction-compaction','Construction Compaction Testing','https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1600&q=80'],
                ['contamination-screening','Soil Contamination Screening','https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80'],
                ['geotech-index','Geotechnical Index Testing','https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1600&q=80'],
                ['landfill-cover','Landfill Cover Compliance','https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80'],
                ['residential-garden','Residential Garden Soil Analysis','https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=1600&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection