
@extends('layouts.dashboard')
@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Trash categories Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->


    <div class="mb-5 ml-4 ">
        <a href="{{route('dashboard.categories.index')}}" class="btn  btn-outline-primary">All categories</a>
        </div>
{{-- flash message --}}
<x-alert type="success"/>
<x-alert type="danger"/>
{{-- table content --}}
<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
  <x-form.input name="name" placeholder="Name" class="mx-4" :value="request('name')"/>
<select name="status" class="form-control mx-4">
  <option value="">All</option>
  <option value="active" @selected(request('status')=='active')>Active</option>
  <option value="archived" @selected(request('status')=='archived')>Archived</option>

</select>
<button class="btn btn-dark mx-2">Filter</button>

</form>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Id</th>
      <th scope="col">name</th>
      <th scope="col">Status</th>
      <th scope="col">Deleted at</th>
      <th colspan="2"></th>
    </tr>
  </thead>
  <tbody>
    @forelse ($categories as $category)
          <tr>
            <td><img src="{{asset('storage/'.$category->image)}}" alt="" height="50px"></td>
      <td>{{$category->id}}</td>
      <td>{{$category->name}}</td>
      <td>{{$category->status}}</td>
      <td>{{$category->deleted_at}}</td>
      <td>
        <form action="{{route('categories.restore',$category->id)}}" method="post">
            @csrf
            @method('put')
            <button type="submite" class="btn btn-outline-success">Restore</button>
            </form>
       
      </td>
      <td>
        <form action="{{route('categories.force.delete',$category->id)}}" method="post">
        @csrf
        @method('delete')
        <button type="submite" class="btn btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>  
    @empty
        <tr>
     
          <td colspan="7" class="alert alert-danger">
            No categories found !
          </td>
        </tr>
    @endforelse

 
  </tbody>
</table>
{{$categories->withQueryString()->appends(['search'=>1])->links()}}
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection 