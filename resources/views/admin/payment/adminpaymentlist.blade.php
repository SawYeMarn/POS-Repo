@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Payment List</h1>
                    </div>

                      <div class="row my-2 ">
                        <div class="col"></div>
                        <div class="col-4">
                            <form action="" method="get">

                                <div class="input-group">
                                    <input type="text" name="searchKey" value="{{request('searchKey')}}" class=" form-control"
                                        placeholder="Enter Search Key...">
                                    <button type="submit" class=" btn bg-dark text-white"> <i
                                            class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div></div>
                    </div>

                    <div class="">
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body shadow">
                                        <form action="{{route('payment#create')}}" method="post" class="p-3 rounded">
                                              @csrf
                                            <input type="text" name="accountNumber" @error('accountNumber') class="is-invalid"   @enderror value="{{old('accountNumber')}}" class="my-2 form-control "
                                                placeholder="account Number...">
                                                @error('accountNumber')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                                <input type="text" name="accountName" @error('accountName') class="is-invalid"   @enderror value="{{old('accountName')}}" class="my-2 form-control "
                                                placeholder="account Name...">
                                                @error('accountName')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                                <input type="text" name="type" @error('type') class="is-invalid"   @enderror value="{{old('type')}}" class="my-2 form-control "
                                                placeholder="bank type...">
                                                @error('type')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                            <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col ">
                                <table class="table table-hover shadow-sm ">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>ID</th>
                                            <th>Acc Name</th>
                                            <th>Acc Number</th>
                                            <th>Acc Type</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>




                                @foreach ($payments as $item)
                                     <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->account_name}}</td>
                                            <td>{{$item->account_number}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>
                                                <a href="{{route('payment#edit',$item->id)}}" class="btn btn-sm btn-outline-secondary"> <i
                                                        class="fa-solid fa-pen-to-square"></i> </a>
                                                <a href="{{route('payment#delete',$item->id)}}"   class="btn btn-sm btn-outline-danger"> <i
                                                        class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                @endforeach







                                    </tbody>

                                </table>

                                   <span>{{$payments->links()}}</span>


                                <span class=" d-flex justify-content-end"></span>

                            </div>
                        </div>
                    </div>

                </div>
@endsection
