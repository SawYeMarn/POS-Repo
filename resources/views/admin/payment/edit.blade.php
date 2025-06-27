@extends('admin.layouts.master')

@section('content')
 <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Payment List</h1>
                    </div>


                    <div class="">
                        <div class="row">
                            <div class="col-4 offset-4">
                                <div class="card">
                                    <div class="card-title">
                                        <a href="{{route('payment#admin')}}" class="mx-3 my-2 btn  bg-dark text-white rounded ">Back</a>
                                    </div>
                                    <div class="card-body shadow">
                                        <form action="{{route('payment#Update',$payments->id)}}" method="post" class="p-3 rounded">
                                              @csrf
                                          <input type="text" name="accountNumber" @error('accountNumber') class="is-invalid"   @enderror value="{{old('accountNumber',$payments->account_number)}}" class="my-2 form-control "
                                                placeholder="account Number...">
                                                @error('accountNumber')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                                <input type="text" name="accountName" @error('accountName') class="is-invalid"   @enderror value="{{old('accountName',$payments->account_name)}}" class="my-2 form-control "
                                                placeholder="account Name...">
                                                @error('accountName')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                                <input type="text" name="type" @error('type') class="is-invalid"   @enderror value="{{old('type',$payments->type)}}" class="my-2 form-control "
                                                placeholder="bank type...">
                                                @error('type')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                                        </form>
                                    </div>
                                </div>
                            </div>

@endsection
