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
                <span class="btn btn-outline-dark m-2"><i class="fa-solid fa-triangle-exclamation"></i> Sale Information</span>
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
                         @foreach ($order as $item)
                               <tr>
                                 <td>{{$item->created_at->format('j-F-Y')}}</td>
                                <td>{{$item->order_code}}</td>
                                <td>{{$item->userName}}</td>
                                <td class="text-success">
                                    Success
                                </td>
                            <td>
                                 <i class="fa-solid fa-user-check text-success"></i>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>



            </div>
        </div>
    </div>


@endsection
