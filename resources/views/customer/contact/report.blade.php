@extends('customer.layouts.master')

@section('content')

<div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="">
                        <div class="row">
                            <div class="col-8 offset-2">

                                <div class="card">
                                    <div class="card-body shadow">
                                        <form action="{{route('contact#adminreport')}}" method="post" class="p-3 rounded">
                                             @csrf
                                             <div class="row">
                                                <input type="hidden" name="userId" value="{{Auth::user()->id}}">
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value='{{Auth::user()->name}}' disabled class="form-control "
                                                    placeholder="">

                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control  @error('title') is-invalid @enderror"
                                                    placeholder="Enter Title">
                                             @error('title') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            </div>



                                            <div class="mb-3">
                                                <label class="form-label">Message</label>
                                        <textarea name="message" id="" cols="30" class="form-control  @error('message') is-invalid @enderror" placeholder="Enter Message" rows="10"></textarea>
                                               @error('message') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <div class="">
                                                <input type="submit" value="Contact" class="btn bg-dark text-white">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


@endsection
