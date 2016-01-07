@extends('layouts.error')
    @section('content')
        
        <!-- Begin 503 Page -->
        <div class="full-content-center animated bounceIn">
            <h1>Under Maintenance</h1>
            <h2>{!! $exception->getMessage() !!}</h2>
        </div>
        <!-- End 503 Page -->
    @stop