@extends('layouts.error')
    @section('content')
        
        <!-- Begin 399 Page -->
        <div class="full-content-center animated bounceIn">
            <h1>Something Missing??</h1>
            <h2>{!! $exception->getMessage() !!}</h2>
        </div>
        <!-- End 399 Page -->
    @stop