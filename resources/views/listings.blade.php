<h1>{{$heading}}</h1>
{{-- If you have logic you can't run in the controller, you can do it in view
@php
    $test = 1;
@endphp 
{{$test}} --}}
@if(count($listings) == 0)
  <p>No listings found</p>
@endif

{{-- Instead of if, could use unless --}}
@unless(count($listings) == 0)

  @foreach($listings as $listing)
    <h2><a href="/listings/{{$listing['id']}}">{{$listing['title']}}</a></h2>
    <p>{{$listing['description']}}</p>
  @endforeach
    
@else
    <p>No listings found</p>
@endunless