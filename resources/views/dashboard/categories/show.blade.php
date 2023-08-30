
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
              <li class="breadcrumb-item active"> Show products</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  
<div class="container">
  <table class="table">
    <thead class="thead-light">
      <tr>
     
        <th scope="col">Name</th>
        <th scope="col">Store</th>
        <th scope="col">Status</th>
        <th scope="col">Created at</th>
   
      </tr>
    </thead>
    <tbody>
      @forelse ($category->products as $product)
            <tr>
              <td>{{$product->name}}</td>
              <td>{{$product->store->name}}</td>
              <td>{{$product->status}}</td>
        <td>{{$product->created_at}}</td>
       
      </tr>  
      @empty
          <tr>
       
            <td colspan="6" class="alert alert-danger">
              No categories found !
            </td>
          </tr>
      @endforelse
  
   
    </tbody>
  </table>
      
</div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection 