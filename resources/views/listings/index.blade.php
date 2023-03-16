@extends('layout')

@section('content')

@include('partials._hero')

@include('partials._search')
    

<div class="text-lg mt-4 font-bold">
    <p class="text-center" style="background: #ef3b2d">Click on job title to view  | | You can filter by tags  </p>
</div>

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

@unless (count($listings) == 0)


@foreach ($listings as $listing)

{{-- <x-listing-card :listing = "$listing" />  --}}

<div class="bg-gray-50 border border-gray-200 rounded p-6">
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{$listing->logo ? asset('storage/'. $listing->logo) : asset('images/no-image.png') }}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="/listings/{{$listing->id}}">{{$listing->title}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$listing->company}}</div>

            @php
                $tags = explode(',', $listing->tags)
            @endphp
            <ul class="flex">
                @foreach ($tags as $tag)
                    
               
                <li
                    class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
                >
                    <a href="/?tag={{$tag}}">{{$tag}}</a>
                </li>
                @endforeach
            </ul>
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
            </div>
        </div>
    </div>
</div>

    
@endforeach

@else 

<p>No listing found</p>
    
@endunless

</div>

<div class="mt-6 p-4">{{$listings->links() }}</div>

@endsection