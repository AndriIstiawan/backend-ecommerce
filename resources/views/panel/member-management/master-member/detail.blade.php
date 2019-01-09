@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<style type="text/css">
    .wrp{
        clear: both;
        box-sizing: border-box;
    }
    .wrp .left{
        width: 30%;
        float: left;
    }
    .wrp .right{
        width: 70%;
    }
</style>
<div class="container-fluid">
    <p>
        <button type="button" class="btn btn-primary" onclick="window.history.back()">
        <i class="fa fa-backward"></i>&nbsp; Back to List
        </button>
    </p>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Detail poin
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="wrp">
                            <div class="left">Point</div>
                            <div class="right">: {{ $member->point }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Detail saldo
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="wrp">
                            <div class="left">Saldo</div>
                            <div class="right">: {{ price('Rp', $member->saldo) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Detail of member
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">Name</label><label class="col-form-label pull-right">:</label>
                        </div>
                        <div class="col-md-9">
                            <label class="col-form-label">{{ $member->name }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">Email</label><label class="col-form-label pull-right">:</label>
                        </div>
                        <div class="col-md-9">
                            <label class="col-form-label">{{ $member->email }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">Phone number</label><label class="col-form-label pull-right">:</label>
                        </div>
                        <div class="col-md-9">
                            <label class="col-form-label">{{ $member->phone }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">Address</label><label class="col-form-label pull-right">:</label>
                        </div>
                        <div class="col-md-9">
                            @foreach ($member->address as $addr)
                            <?php

                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-form-label">
                                        @isset($addr['primary'])<span class="badge badge-primary">{{($addr['primary']?'Primary':'')}}</span>&nbsp;&nbsp;@endisset
                                        @isset($addr['address_alias'])<span class="badge badge-success">{{$addr['address_alias']}}</span>&nbsp;&nbsp;@endisset
                                        @isset($addr['receiver_name']){{ $addr['receiver_name'] }}, @endisset
                                        @isset($addr['address']){{ $addr['address'] }} @endisset
                                        @isset($addr['city_name']){{ $addr['city_name'] }} @endisset
                                        @isset($addr['postal_code']){{ $addr['postal_code'] }}. @endisset
                                        @isset($addr['type']){{ $addr['type'] }} @endisset
                                        @isset($addr['province']){{ $addr['province'] }} @endisset
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    
</script>
@endsection