@extends('customer.layouts.master')

@section('content')
  <div class="container " style="margin-top: 150px">
        <div class="row">
            <div class="card col-12 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-4">Payment methods</h5>


                      @foreach ($payments as $item)
                 <div class="">
                                <b></b> ( Name :{{$item->account_name}} )
                            </div>

                            Account :{{$item->account_number}}

                            <hr>
                      @endforeach

                        </div>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <form action="{{route('customer#order')}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" id="" readonly value="{{Auth::user()->name}}"
                                                        class="form-control " placeholder="User Name...">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id="" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror  "
                                                        placeholder="09xxxxxxxx"> @error('phone')<div class="invalid-feedback">{{$message}} </div> @enderror
                                                </div>
                                  <div class="row mt-4">
                                      <div class="col"> <textarea name="address" value='' id="" cols="30"  rows="10" class="form-control @error('address') is-invalid @enderror " placeholder="Enter Address">
                                        {{old('address')}} </textarea>
                                        @error('address')<div class="invalid-feedback">{{$message}} </div> @enderror</div>

                                    </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <select name="paymentType" id=""  class=" form-select  @error('paymentType') is-invalid @enderror">
                                                        @foreach ($payments as $item )
                                                        <option value="{{$item->id}}" @if(old('paymentType'== $item->id))
                                                            selected
                                                        @endif>{{$item->type}}</option>
                                                        @endforeach
                                                    </select>
                                                     @error('paymentType')<div class="invalid-feedback">{{$message}} </div> @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="file" name="payslipImage"  value{{old('payslipImage')}} id="" class="form-control   @error('payslipImage') is-invalid @enderror">
                                                    @error('payslipImage')<div class="invalid-feedback">{{$message}} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode" value="{{$orderTemp[0]['order_code']}}">
                                                    Order Code : <span class="text-secondary   fw-bold">{{$orderTemp[0]['order_code']}}</span>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount" value="{{$orderTemp[0]['finalAmt']}}">
                                                    Total amt : <span class=" fw-bold">{{$orderTemp[0]['finalAmt']}}mmk</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 mx-2">
                                                <button type="submit" class="btn btn-outline-success w-100"><i
                                                        class="fa-solid fa-cart-shopping me-3"></i> Order
                                                    Now...</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
