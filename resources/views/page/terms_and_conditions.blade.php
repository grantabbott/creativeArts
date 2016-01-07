@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-12">
                <div class="box-info">
                    <h2><strong>{!! config('page.terms_and_conditions.title') !!}</strong></h2>
                    {!! config('page.terms_and_conditions.description') !!}
                </div>
            </div>
        </div>
    @stop