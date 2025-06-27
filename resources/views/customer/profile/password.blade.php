@extends('customer.layouts.master')

@section('content')
  <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="">
                        <div class="row">
                            <div class="col-8 offset-2">

                                <div class="card">
                                    <div class="card-body shadow">
                                        <form action="{{route('profile#passwordupdate')}}" method="post" class="p-3 rounded">
                                             @csrf
                                             <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Old Password</label>
                                                <input type="password" name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror"
                                                    placeholder="Enter Old Password...">
                                             @error('oldPassword') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="newPassword" class="form-control  @error('newPassword') is-invalid @enderror"
                                                    placeholder="Enter New Password...">
                                             @error('newPassword') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            </div>



                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="confirmPassword" class="form-control  @error('confirmPassword') is-invalid @enderror"
                                                    placeholder="Enter Confirm Password...">
                                               @error('confirmPassword') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <div class="">
                                                <input type="submit" value="Change" class="btn bg-dark text-white">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

@endsection
