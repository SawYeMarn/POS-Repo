@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{request('searchKey')}}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="btn btn-outline-dark m-2"><i class="fa-solid fa-triangle-exclamation"></i> Click Order Code to See order details</span>
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>

                            <th>Date</th>
                            <th>Order-Code</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orderList as $item)
                            <tr>
                                <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                <td> <a href="{{route('order#product',$item->order_code)}}" class="orderCode">{{ $item->order_code }}</a></td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <select name="" id="" class="form-select form-control statusChange">
                                        <option value="0" @if ($item->status == 0) selected @endif>Pending
                                        </option>
                                       @if ($item->count <= $item->stock)
                                        <option value="1" @if ($item->status == 1) selected @endif>Success
                                        </option>
                                       @endif
                                        <option value="2" @if ($item->status == 2) selected @endif>Reject
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    @if ($item->status == 0)
                                        <i class="fa-solid fa-clock text-warning"></i>

                                    @elseif($item->status == 1)
                                       <i class="fa-solid fa-user-check text-success"></i>

                                    @else<i class="fa-solid fa-xmark text-danger"></i>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>



            </div>
        </div>
    </div>
@endsection

@section('js-script')

<script>
$(document).ready(function(){
    $('.statusChange').change(function(){
    //    orderCode = $('#orderCode').text();

    status = $(this).val();
    orderCode =$(this).parents('tr').find('.orderCode').text();
    data = ({
        'order_code' : orderCode,
        'status' : status
    })

      $.ajax({
        type : 'get',
        url : '/admin/order/statusChange',
        data : data,
        dataType : 'json',
        success:function(res){
            res.status == 'success' ? location.href= '/admin/order/list' : '';
        }

      })

    })
})

</script>

@endsection
