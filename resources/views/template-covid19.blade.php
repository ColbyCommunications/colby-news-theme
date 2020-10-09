{{--
    Template Name: Colby In The News: COVID-19
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php the_post() @endphp
        @include('partials.content-page')
    @endwhile
@endsection