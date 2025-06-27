@extends('admin.layouts.master')

@section('content')
  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Category List</h1>
                    </div>

                    <div class="">
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body shadow">
                                        <form action="{{route('category#create')}}" method="post" class="p-3 rounded">
                                              @csrf
                                            <input type="text" name="categoryName" @error('categoryName') class="is-invalid"   @enderror value="{{old('categoryName')}}" class=" form-control "
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

                            <div class="col ">
                                <table class="table table-hover shadow-sm ">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Created Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    @foreach ($categories as $item)

                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->created_at->format('j-F-Y')}}</td>
                                            <td>
                                                <a href="{{route('category#edit',$item->id)}}" class="btn btn-sm btn-outline-secondary"> <i
                                                        class="fa-solid fa-pen-to-square"></i> </a>
                                                <a href="{{route('category#delete', $item->id)}}"   class="btn btn-sm btn-outline-danger"> <i
                                                        class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach





                                    </tbody>

                                </table>
                                <span>{{$categories->links()}}</span>

                                <span class=" d-flex justify-content-end"></span>

                            </div>
                        </div>
                    </div>

                </div>

@endsection

{{-- @section('js-script')

<script>
function delete() {
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire({
      title: "Cancelled",
      text: "Your imaginary file is safe :)",
      icon: "error"
    });
  }
});
}
    </script>

@endsection --}}
