@extends('dashboard.layouts.app')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> {{ __('site.dashboard') }}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{ __('site.clients') }}</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12 col-xl-7">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">@lang('site.create') @lang('site.client')</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('dashboard.clients.store') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.first_name')</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.last_name')</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.email')</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.phone')</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.password')</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.password_confirmation')</label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>
                                    {{-- <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.role')</label>
                                            <select class="custom-select mr-sm-2 @error('role') is-invalid @enderror" id="inlineFormCustomSelect" name="role">
                                                <option  value="" selected>@lang('site.choose') @lang('site.role')...</option>
                                                <option value="super_admin">@lang('site.super_admin')</option>
                                                <option value="accountant">@lang('site.accountant')</option>
                                                <option value="customer_service">@lang('site.customer_service')</option>
                                                <option value="data_entry">@lang('site.data_entry')</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.city')</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.state')</label>
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.street')</label>
                                            <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.building')</label>
                                            <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ old('building') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.apartment')</label>
                                            <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ old('apartment') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@lang('site.floor')</label>
                                            <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ old('floor') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-rounded btn-primary">@lang('site.add')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

