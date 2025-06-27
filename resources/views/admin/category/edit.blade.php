@extends('admin.layouts.master')

@section('content')
  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Category List</h1>
                    </div>

                    <div class="">
                        <div class="row">
                            <div class="col-4 offset-4">
                                <div class="card">
                                    <div class="card-title">
                                        <a href="{{route('category#list')}}" class="mx-3 my-2 btn  bg-dark text-white rounded ">Back</a>
                                    </div>
                                    <div class="card-body shadow">
                                        <form action="{{route('category#update',$category->id)}}" method="post" class="p-3 rounded">
                                              @csrf
                                            <input type="text" name="categoryName" value="{{old('categoryName',$category->name)}}"
                                                class=" form-control @error('categoryName') is-invalid @enderror "
                                                placeholder="Category Name...">
                                                 @error('categoryName')
                                                <small class="invalid-feedback">
                                                    {{ $message }}
                                                </small>
                                                @enderror

                                            <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                                        </form>
                                    </div>
                                </div>
                            </div>


@endsection
