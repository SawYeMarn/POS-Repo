@extends('admin.layouts.master')

@section('content')

<div class="container">
                    <div class=" d-flex justify-content-between my-2">
                        <a href="{{route('account#userlist')}}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>
                        <div class="">
                            <form action="{{route('account#adminlist')}}" method="get">
                                    @csrf
                                <div class="input-group">
                                    <input type="text" name="searchKey" value="{{request('searchKey')}}" class=" form-control"
                                        placeholder="Enter Search Key...">
                                    <button type="submit" class=" btn bg-dark text-white"> <i
                                            class="fa-solid fa-magnifying-glass"></i> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-hover shadow-sm ">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Created Date</th>
                                        <th> Platform</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($admin as $item )
                                    <tr class="text-center">
                                        <td ><img class="img-profile img-thumbnail w-50" id="output" src="{{ $item->profile != null ? asset('profile/'.$item->profile) : asset('default/image.png') }}"></td>
                                        <td>{{$item->name != null ? $item->name : $item->nickname}}</td>
                                        <td>{{$item->email}}</td>
                                        <td >{!! $item->address != null ? $item->address : '<span style="color:red; opacity:0.5">not register...</span>' !!}</td>
                                        <td >{!! $item->phone != null ? $item->phone: '<span style="color:red; opacity:0.5">not register...</span>' !!}</td>

                                        <td><span class="btn btn-sm bg-danger text-white rounded shadow-sm">{{$item->role}}</span></td>

                                        <td>{{$item->created_at->format('j-F-Y')}}</td>
                                        <td>
                                            @if($item->provider == "google")
                                            <i class="fa-brands fa-google"></i>@endif
                                            @if($item->provider == "simple")
                                            <i class="fa-solid fa-right-to-bracket"></i>@endif
                                        </td>
                                        <td>
                                           @if ($item->role != "superadmin")
                                            <a href="{{route('account#admindelete',$item->id)}}"  class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                           @endif
                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>

                            <span class=" d-flex justify-content-end">{{$admin->links()}}</span>

                        </div>
                    </div>
                </div>


@endsection


