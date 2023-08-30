
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
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  
<div class="container">
    <form action="{{route('dashboard.products.update',$products->id)}}" method="post" enctype="multipart/form-data">
        @csrf
  @method('PUT')
      @include('dashboard.products._form',[
        'button_label'=>'Update'
      ])
      </form>
      
</div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection 