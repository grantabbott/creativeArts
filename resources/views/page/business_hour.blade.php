@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-12">
                <div class="box-info">
                    <h2><strong>{!! config('page.business_hour.title') !!}</strong></h2>
                    {!! config('page.business_hour.description') !!}

                    <div class="col-md-6">
                        <h4><strong>Business Hour</strong></h4>
                        <div class="table-responsive">
                            <table data-sortable class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($business_hours as $business_hour)
                                        <tr>
                                            <td>{!! $business_hour->day !!}</td>
                                            <td>{!! \App\Classes\Helper::showTime($business_hour->start) !!}</td>
                                            <td>{!! \App\Classes\Helper::showTime($business_hour->end) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4><strong>Service Time</strong></h4>
                        <div class="table-responsive">
                            <table data-sortable class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Priority</th>
                                        <th>Estimated Response Time</th>
                                        <th>Estimated Resolution Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($service_times as $service_time)
                                        <tr>
                                            <td>{!! $service_time->priority !!}</td>
                                            <td>{!! $service_time->response_time.' '.ucfirst($service_time->response_unit).' ('.\App\Classes\Helper::toWord($service_time->response_time_type).')' !!}</td>
                                            <td>{!! $service_time->resolution_time.' '.ucfirst($service_time->resolution_unit).' ('.\App\Classes\Helper::toWord($service_time->resolution_time_type).')'  !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop