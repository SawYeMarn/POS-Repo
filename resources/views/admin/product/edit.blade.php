@extends('admin.layouts.master')

@section('content')
  <div class="container">
                    <div class="row">
                        <div class="col-8 offset-2 card p-3 shadow-sm rounded">

                            <form action="{{route('product#update')}}" method="post" enctype="multipart/form-data">
                               @csrf
                               <input type="hidden" name="productId" value="{{$product->id}}" >
                                <input type="hidden" name="productImage" value="{{$product->image}}">
                                {{-- <input type="hidden" name="productId" value=""> --}}

                                <div class="card-body">
                                    <div class="mb-3">
                                       <div class="text-center"> <img class="img-profile mb-1 w-25" id="output"  src="{{asset('productImage/'.$product->image)}}"></div>
                                        <input type="file" onchange="loadFile(event)" accept="image/*" name="image" id="" class="form-control mt-1 @error('image')
                                                    is-invalid
                                        @enderror">
                                        @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{old('name',$product->name)}}" class="form-control  @error('name')
                                                    is-invalid
                                                @enderror"
                                                    placeholder="Enter Name...">
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <select name="categoryId" id="" class="form-control  @error('categoryId')
                                                    is-invalid
                                                @enderror">

                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id ==old('categoryId', $product->category_id)) selected @endif>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('categoryId')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" name="price" value="{{old('price',$product->price)}}" class="form-control  @error('price')
                                                    is-invalid
                                                @enderror"
                                                    placeholder="Enter Price...">
                                                    @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Stock</label>
                                                <input type="text" name="stock" value="{{old('stock',$product->stock)}}" class="form-control  @error('stock')
                                                    is-invalid
                                                @enderror"
                                                    placeholder="Enter stock...">
                                               @error('stock')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                               @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id=""  cols="30" rows="10" class="form-control @error('description')
                                                    is-invalid
                                        @enderror "
                                            placeholder="Enter description...">{{old('description',$product->description)}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                    </div>
                                    @enderror

                                    <div class="mb-3">
                                        <input type="submit" value="Update Product"
                                            class=" btn btn-primary w-100 rounded shadow-sm">
                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>


@endsection
