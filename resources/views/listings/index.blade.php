<x-layout>

  @include('partials._hero')
  @include('partials._search')

  <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
    {{-- If you have logic you can't run in the controller, you can do it in view
@php
    $test = 1;
@endphp 
{{$test}} --}}
    @if (count($listings) == 0)
      <p>No listings found</p>
    @endif

    {{-- Instead of if, could use unless --}}
    @unless (count($listings) == 0)
      @foreach ($listings as $listing)
        <x-listing-card :listing="$listing" />
      @endforeach
    @else
      <p>No listings found</p>
    @endunless

  </div>

</x-layout>
