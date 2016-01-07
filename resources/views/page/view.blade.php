@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-8">
                <div class="box-info">
                    <h2>{!! $page->page_title !!} </h2>
          			{!! $page->page_description !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-info">
                    <h2><strong>Other</strong> Pages</h2>
                	@foreach($pages as $page)
                		<a href="{!! URL::to('/pages/'.$page->page_slug) !!}">{!! $page->page_title !!}</a> <br />
                	@endforeach
                </div>
            </div>
        </div>
    @stop