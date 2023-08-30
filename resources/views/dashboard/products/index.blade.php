
@extends('layouts.dashboard')
@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    
<div class="mb-5 ml-4 ">
{{-- <a href="{{route('dashboard.products.create')}}" class="btn btn-outline-primary">Create</a>
<a href="{{route('products.trash')}}" class="btn btn-outline-danger ">Trash page</a> --}}
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
      <th scope="col">Category</th>
      <th scope="col">Store</th>
      <th scope="col">price</th>
      <th scope="col">Status</th>
      <th scope="col">Created at</th>
      <th colspan="2"></th>
    </tr>
  </thead>
  <tbody>
    @forelse ($products as $product)
          <tr>
            <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50px"></td>
      <td>{{$product->id}}</td>
      <td>{{$product->name}}</td>
      <td>{{$product->Category->name}}</td>
      <td>{{$product->store->name}}</td>
      <td>{{$product->price}}</td>
      <td>{{$product->status}}</td>
      <td>
        <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-outline-success">Edit</a>
      </td>
      <td>
        <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
        @csrf
        @method('delete')
        <button type="submite" class="btn btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>  
    @empty
        <tr>
     
          <td colspan="9" class="alert alert-danger">
            No products found !
          </td>
        </tr>
    @endforelse

 
  </tbody>
</table>
{{$products->withQueryString()->appends(['search'=>1])->links()}}
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection 