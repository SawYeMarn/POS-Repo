@extends('customer.layouts.master')

@section('content')


    <div class="container " style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>

              @foreach ($orders as $item )
                    <tr>
                        <td>{{$item->created_at->format('j-F-Y')}}</td>
                        <td>{{$item->order_code}}</td>
                        <td>

                            @if ($item->status==0)
                                <i class="fa-solid fa-clock btn btn-sm btn-warning"></i><span class="mx-3 text-warnig">Pending</span>
                            @elseif($item->status ==1)
                                 <i class="fa-solid fa-check btn btn-sm btn-success"></i><span class="mx-3 text-success">Success</span>
                                 @else<i class="fa-solid fa-xmark btn btn-sm btn-danger"></i><span class="mx-3 text-danger">Reject</span>
                            @endif

                        </td>
                    </tr>
              @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
