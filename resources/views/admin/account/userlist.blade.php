@extends('admin.layouts.master')

@section('content')
  <div class="container">
                    <div class=" d-flex justify-content-between my-2">
                        <a href="{{route('account#adminlist')}}"> <button class=" btn btn-sm btn-secondary  "> Back</button> </a>
                        <div class="">
                            <form action="{{route('account#userlist')}}" method="get">
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

                                   @foreach ($users as $user )

                                    <tr>
                                        <td><img class="img-profile img-thumbnail w-50" id="output" src="{{$user->profile != null ?  asset('profile/'.$user->profile) : asset('default/image.png')}}" ></td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{!! $user->address != null ? $user->address : '<span style="color:red; opacity:0.5">not register...</span>' !!}</td>
                                        <td>{!! $user->phone != null ? $user->phone : '<span style="color:red; opacity:0.5">not register...</span>' !!}</td>
                                        <td><span class="btn btn-sm bg-danger text-white rounded shadow-sm"></span>
                                        {{$user->role}}
                                        </td>

                                        <td>{{$user->created_at->format('j-F-Y')}}</td>
                                        <td>
                                           @if($user->provider == "google")
                                            <i class="fa-brands fa-google"></i>@endif
                                            @if($user->provider == "simple")
                                            <i class="fa-solid fa-right-to-bracket"></i>@endif
                                        </td>
                                        <td>
                                 <a href="{{route('account#userdelete',$user->id)}}" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                   @endforeach

                                </tbody>
                            </table>

                            <span class=" d-flex justify-content-end"></span>

                        </div>
                    </div>
                </div>

@endsection
