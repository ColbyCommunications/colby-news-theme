{{--
    Template Name: Colby In The News: COVID-19
--}}

@extends('layouts.app')

@section('content')
    
    <div class="row"><div class="col" style="margin: 2rem 0px;"><h2>COVID-19 News</h2></div></div>
    @while(have_posts()) @php the_post() @endphp
        @include('partials.content-page-section')
    @endwhile
@endsection