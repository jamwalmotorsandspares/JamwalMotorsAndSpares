@extends('dashboard.layouts.app')
@push('css')
    <style>
        @media print {
            button.btn-print {
                display: none;
            }
        }
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> {{ __('site.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> {{ __('site.orders') }}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{ __('site.invoice') }}</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="container-fluid">
            <div class="row justify-content-between">
            <div class="col-12 ">
                    <h2 class="page-heading"><a href="{{route('dashboard.orders.index')}}"> {{ __('site.return') }}</a></h2>
                </div>
                <div class="col-12 ">
                    <h2 class="page-heading">{{ __('site.invoice') }} {{ __('site.order') }}</h2>
                </div>
            </div>
             <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <div class="bootstrap-label">
                                    {{-- <span
                                        class="label label-{{ $order->payment_status == 1 ? 'success' : 'light' }}">{{ $order->payment_status != 1 ? __('site.draft') : __('site.active') }}</span> --}}
                                    @if ($order->payment_status == 1)
                                        <span class="label label-success">PAID</span>
                                    @elseif ($order->payment_status == 2)
                                    <span class="label label-warning">PENDING</span>
                                    {{-- <span
                                        class="label label-{{ $order->payment_status == 1 ? 'success' : 'light' }}">{{ $order->payment_status != 1 ? __('site.draft') : __('site.active') }}</span> --}}
                                    @else
                                    <span class="label label-danger">UNPAID</span>
                                    @endif
                                </div>
                            </div>
                            <div class="float-right">
                                <div class="button-group">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary"
                                            onclick="printDiv()">{{ __('site.print') }}</button>
                                         @if ($order->payment_status != 1)
                                            <button type="submit" form="formordersActive" class="btn btn-outline-primary"
                                                {{ $order->payment_status == 1 ? 'disabled' : '' }}>{{ __('site.approval') }}</button>
                                        @else
                                            <a href="{{ route('dashboard.orders.edit', $order->id) }}"
                                                class="btn btn-outline-primary">{{ __('site.payment') }}</a>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('dashboard.orders.active', $order->id) }}" method="post"
                                    style="display: none" id="formordersActive">
                                    @csrf
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="print">
                <div class="col-12">

                {{-- <div class="text-right">

                            <button type="button" class="btn btn-primary mb-2 btn-print"
                                onclick="printDiv()">@lang('site.print')</button>
                        </div> --}}
                    <div class="p-3 bg-white rounded">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="text-uppercase">@lang('site.invoice') @lang('site.order')</h4>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.invoice_no'):</span><span
                                        class="ml-1">#{{ $order->invoice_no }}</span></div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.date'):</span><span
                                        class="ml-1">{{ $order->updated_at->format('M d, Y') }}</span></div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.method'):</span><span
                                        class="ml-1">{{ $order->method }}</span></div>
                                @if ($order->transaction)
                                    <div class="billed"><span
                                            class="font-weight-bold text-uppercase">@lang('site.transaction_no'):</span><span
                                            class="ml-1">#{{ $order->transaction->transaction_no }}</span></div>
                                    <div class="billed"><span
                                            class="font-weight-bold text-uppercase">@lang('site.order_transaction_no'):</span><span
                                            class="ml-1">#{{ $order->transaction->order_transaction_no }}</span></div>
                                    <div class="billed"><span
                                            class="font-weight-bold text-uppercase">@lang('site.source_type'):</span><span
                                            class="ml-1">#{{ $order->transaction->source_type }}</span></div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-uppercase">@lang('site.from')</h4>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.name'):</span><span
                                        class="ml-1">{{ $setting->name }}</span></div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.phone'):</span><span
                                        class="ml-1">{{ $setting->phone }}</span></div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.address'):</span><span
                                        class="ml-1">{{ $setting->address }}</span></div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-uppercase">@lang('site.to')</h4>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.name'):</span><span
                                        class="ml-1">{{ $order->user->first_name . ' ' . $order->user->last_name }}</span>
                                </div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.phone'):</span><span
                                        class="ml-1">{{ $order->user->phone }}</span></div>
                                <div class="billed"><span
                                        class="font-weight-bold text-uppercase">@lang('site.address'):</span><span
                                        class="ml-1">{{ $order->address }} |
                                        {{ __('site.building') . ': ' . $order->building . ', ' . __('site.apartment') . ': ' . $order->apartment . ', ' . __('site.floor') . ': ' . $order->floor }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 text-right mt-3">
                                <h4 class="text-primary mb-0">{{ $setting->name }}</h4>
                                {{-- <span>sparte-parts.com</span> --}}
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>@lang('site.product')</th>
                                            <th>@lang('site.price')</th>
                                            <th>@lang('site.quantity')</th>
                                            <th>@lang('site.total')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $index => $product)
                                            <tr>
                                                <td>#{{ $product->id }}</td>
                                                <td><a
                                                        href="{{ route('dashboard.products.show', $product->id) }}">{{ $product->name }}</a>
                                                </td>
                                                <td>₹{{ number_format($product->pivot->price, 2) }}</td>
                                                <td>{{ $product->pivot->quantity }}</td>
                                                <td>₹{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-5">
                                    <table class="table">
                                        <tr>
                                            <th>@lang('site.subTotal')</th>
                                            <td>₹{{ number_format($order->sub_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tax</th>
                                            <td>₹{{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('site.shipping')</th>
                                            <td>{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : __('site.free') . ' ' . __('site.shipping') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('site.total')</th>
                                            <td>₹{{ number_format($order->total_price, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-4 col-sm-5"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endpush
