@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <div class="container-settings">
                    @if (Session::has('success_message'))
                        <div class="greenDanger alert alert-danger" role="alert">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="tablecontainer">
                        <h3 style="margin-top: 10px"> Coupon Page
                            @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                <a href="{{ url('admin/coupons/add-edit-coupon') }}"
                                    class="btn btn-block btn-success tblBtn">
                                    Add</a>
                            @endif
                        </h3>
                        <div class="innerCon">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                        <th class="table__heading">ID</th>
                                        <th class="table__heading">Option</th>
                                        <th class="table__heading">Code</th>
                                        <th class="table__heading">Type</th>
                                        <th class="table__heading">Amount Type</th>
                                        <th class="table__heading">Amount</th>
                                        <th class="table__heading">Expiry Date</th>
                                        <th class="table__heading">Created</th>
                                        <th class="table__heading">Status</th>
                                        <th class="table__heading">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($couponsData as $coupon)
                                        <tr class="table__row">
                                            <td class="table__content" data-heading="ID">{{ $coupon['id'] }}</td>
                                            <td class="table__content" data-heading="coupon_option">{{ $coupon['coupon_option'] }}</td>
                                            <td class="table__content" data-heading="coupon_code">{{ $coupon['coupon_code'] }}</td>
                                            <td class="table__content" data-heading="coupon_type">{{ $coupon['coupon_type'] }}</td>
                                            <td class="table__content" data-heading="amount_type">{{ $coupon['amount_type'] }}</td>
                                            <td class="table__content" data-heading="amount">{{ $coupon['amount'] }} @if($coupon['amount_type'] == "Percentage") % @else KR @endif</td>
                                            <td class="table__content" data-heading="expiry_date">{{ $coupon['expiry_date'] }}</td>
                                            <td class="table__content" data-heading="Created at">
                                                {{ date('F j, Y, g:i a', strtotime($coupon['created_at'])) }}</td>
                                            <td class="table__content" data-heading="Status">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    @if ($coupon['status'] == 1)
                                                        <a class="updateCouponsPageStatus" id="page-{{ $coupon['id'] }}"
                                                            page_id="{{ $coupon['id'] }}" href="javascript:void(0)"
                                                            style="color: blue;">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateCouponsPageStatus" id="page-{{ $coupon['id'] }}"
                                                            page_id="{{ $coupon['id'] }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="action">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    <a href="{{ route('admin.coupons.add_edit_coupon', ['id' => $coupon['id']]) }}"
                                                        style="color: blue;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($pagesModule['full_access'] == 1)
                                                    <a title="Delete coupon" href="javascript:void(0)"
                                                        class="confirmDelete" record="coupon"
                                                        recordid="{{ $coupon['id'] }}" style="color: blue;"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
