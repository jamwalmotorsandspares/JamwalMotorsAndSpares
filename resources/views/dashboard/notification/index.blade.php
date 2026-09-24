@extends('dashboard.layouts.app')
@push('css')
    <!-- Select 2 -->
    {{-- <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css') }}"> --}}
@endpush
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> {{ __('site.dashboard') }}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{'notifications' }}</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div class="col-12 ">
                    <h2 class="page-heading">{{ __('site.list') }} notifications</h2>
                    <p class="mb-0">Count Notifications : {{ $notifications->total() }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header row">
                                <div class="col-md-6">

                                    {{-- btn-filter --}}
                                    {{-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                                        data-target="#filterModal">{{ __('site.filter') }}</button> --}}
                                    {{-- btn-excel --}}
                                    {{-- btn-mass-delete --}}
                                    {{-- <form action="{{ route('dashboard.products.destroy', 'delete') }}" method="post"
                                        style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <input type="hidden" value="" name="mass_delete" id="mass-delete">
                                        <button type="submit" id="btn-mass-delete" class="btn btn-danger mb-2"
                                            disabled>{{ __('site.mass_delete') }}</button>
                                    </form> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table verticle-middle table-responsive-lg mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ __('site.type') }}</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Message</th>
                                            {{-- <th scope="col">{{ __('site.url') }}</th> --}}
                                            <th scope="col">READ AT</th>
                                            {{-- <th scope="col"><input type="checkbox" value=""
                                                    id="check-box-delete-all"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $index => $notification)
                                        @php  $data = is_string($notification->data)
                                            ? json_decode($notification->data, true)
                                            : $notification->data; @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                 <td>{{ $notification->data['type'] }}</td>
                                                 <td>{{ $notification->data['title'] }}</td>
                                                <td>{{ $notification->data['message'] }}</td>

                                                {{-- <td>{{ $notification->data['url'] }}</td> --}}
                                                <td>{{ $notification->read_at ?? "Unread" }}</td>
                                                {{-- <td>
                                                    <span>
                                                        <input type="checkbox" value="{{ $notification->id }}"
                                                            class="check-box-delete">
                                                    </span>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $notifications->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modal')
    <!-- start filter modal -->
    <div class="modal fade" id="filterModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('site.filter') }} {{ __('site.notifications') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.notifications.index') }}" method="GET" id="filter-form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="@lang('site.search')"
                                value="{{ request()->search }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="event.preventDefault();
                document.getElementById('filter-form').submit();">{{ __('site.filter') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end filter modal -->
@endpush
@push('js')
    <script src="{{ asset('dashboard/assets/js/massDelete.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('dashboard/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Select 2 init -->
    <script src="{{ asset('dashboard/assets/js/plugins-init/select2-init.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/custom-init/select2-init.js') }}"></script>
@endpush
