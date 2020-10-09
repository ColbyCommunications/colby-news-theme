{{--
    Template Name: Colby In The News: COVID-19
--}}

@extends('layouts.app')

@section('content')
    <h2>COVID-19 News</h2>
    @while(have_posts()) @php the_post() @endphp
        @include('partials.content-page')
    @endwhile
@endsection