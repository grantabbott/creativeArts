@extends('layouts.full')

    @section('content')
        <div class="full-content-center animated fadeInDownBig">
            <div class="login-wrap">
                <div class="box-info">
                <h2 class="text-center"><strong>{!! trans('messages.User') !!}</strong> {!! trans('messages.Login') !!}</h2>
                    
                        @include('auth.login_form')

                        @if(! App\Classes\Helper::getMode())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>Admin</td>
                                            <td>admin</td>
                                            <td>123456</td>
                                        </tr>
                                        <tr>
                                            <td>Staff</td>
                                            <td>staff</td>
                                            <td>123456</td>
                                        </tr>
                                        <tr>
                                            <td>User</td>
                                            <td>user</td>
                                            <td>123456</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    @stop