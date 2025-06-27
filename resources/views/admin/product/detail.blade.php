@extends('admin.layouts.master')

@section('content')
<div class="container">
                    <div class="row">
                        <div class="col-8 offset-2 card p-3 shadow-sm rounded">

                            <form action="" method="post" enctype="multipart/form-data">


                                <input type="hidden" name="oldPhoto" value="">
                                <input type="hidden" name="productId" value="">

                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="text-center"><img class="img-profile mb-1 w-50" id="output" src="{{ asset('productImage/'.$product->image) }}"></div>


                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-control">{{$product->name}}</label>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">      <select name="categoryId" id="" class="form-control                                                ">

                                                    @foreach ($categories as $item)
                                                         <option value="{{ $item->id }}"
                                                            @if ($item->id ==old('categoryId', $product->category_id)) selected @endif>
                                                            {{ $item->name }}</option>
                                                        </option>

                                                        @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-control">{{ $product->price}}MMK</label>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-control">{{$product->stock}}</label>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                       <textarea class="form-control">{{$product->description}}</textarea>


                                    </div>


                                </div>
                            </form>


                        </div>

                    </div>
                </div>


@endsection

