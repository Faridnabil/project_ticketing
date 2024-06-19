@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row" style="margin-top: 0px, ">
            <div class="col-lg-12">
                <div class="card" style="border-radius: 15px;">


                    <div class="card-body" style="background-color: #393B92; border-radius: 10px;">
                        <p style="font-size: 20px; color: #ffffff;">Dashboard</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">


                            <div class="col-md-4">
                                <div class="card text-white" style="position: relative; overflow: hidden;">
                                    <div
                                        style="background: linear-gradient(to bottom left, #403DF9, #A521FF); height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div
                                        style="background: url('/img/illustrations/pattern-card.svg') no-repeat center center; background-size: cover; opacity: 0.1; height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div class="card-body pb-12" style="position: relative; height: 150px;">
                                        <div class="text-value"
                                            style="position: absolute; bottom: 60px; left: 20px; font-size: 20px;">
                                            <div class="text-value">{{ number_format($totalTickets) }}</div>
                                        </div>
                                        <div style="position: absolute; bottom: 25px; left: 20px; font-size: 20px;">
                                            Total tickets
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="card text-white" style="position: relative; overflow: hidden;">
                                    <div
                                        style="background: linear-gradient(to bottom left, #F4734D, #FD4F52); height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div
                                        style="background: url('/img/illustrations/pattern-card.svg') no-repeat center center; background-size: cover; opacity: 0.1; height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div class="card-body pb-12" style="position: relative; height: 150px;">
                                        <div class="text-value"
                                            style="position: absolute; bottom: 60px; left: 20px; font-size: 20px;">
                                            <div class="text-value">{{ number_format($openTickets) }}</div>
                                        </div>
                                        <div style="position: absolute; bottom: 25px; left: 20px; font-size: 20px;">
                                            Open tickets
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="card text-white" style="position: relative; overflow: hidden;">
                                    <div
                                        style="background: linear-gradient(to bottom left, #03bb81, #09D8FB); height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div
                                        style="background: url('/img/illustrations/pattern-card.svg') no-repeat center center; background-size: cover; opacity: 0.1; height: 100%; width: 100%; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div class="card-body pb-12" style="position: relative; height: 150px;">
                                        <div class="text-value"
                                            style="position: absolute; bottom: 60px; left: 20px; font-size: 20px;">
                                            <div class="text-value"> {{ number_format($closedTickets) }}</div>
                                        </div>
                                        <div style="position: absolute; bottom: 25px; left: 20px; font-size: 20px;">
                                            Closed tickets
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
