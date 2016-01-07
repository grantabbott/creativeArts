@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-5">
                <div class="box-info">
                    <h2><strong>{!! trans('messages.Create') !!}</strong> {!! trans('messages.Ticket') !!}</h2>
                    {!! Form::open(['route' => 'ticket.store','role' => 'form', 'class'=>'ticket-form']) !!}
                        @include('ticket._form')
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-7">
                <div class="box-info full">
                    <h2><strong>{!! trans('messages.My') !!}</strong> Tickets</h2>

                    @if(!count($tickets))
                    <div class="alert alert-danger">You haven't raised any tickets.</div>
                    @endif

                    <div class="comment-widget">
                        @foreach($tickets as $ticket)
                        <ul class="media-list">
                          <li class="media">
                            <a class="pull-left">{!! \App\Classes\Helper::getAvatar($ticket->User->id) !!}</a>
                            <div class="media-body danger">
                              <h5><strong>Ticket # {!! $ticket->ticket_no !!}</strong></h5> <p>{!! $ticket->ticket_subject !!} <a href="{!! URL::to('/view-ticket/'.$ticket->id) !!}" class="btn btn-default btn-xs pull-right"><i class="fa fa-share"></i> Check Detail</a></p>
                              <p time="time-left"><strong>{!! \App\Classes\Helper::showTicketStatus($ticket->ticket_status) !!}</strong>
                              <span class="time pull-right"><i class="fa fa-clock-o"></i> {!! \App\Classes\Helper::showDateTime($ticket->created_at) !!}</span></p>
                            </div>
                          </li>
                        </ul>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    @stop