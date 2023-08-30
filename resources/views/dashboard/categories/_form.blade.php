@if ($errors->any())

<div class="alert alert-danger">
  <h3>Erorr ocurced!</h3>
  <ul>
    @foreach ($errors->all() as $error)
    <li>
  {{$error}}
    </li>
    @endforeach
    
  </ul>
</div>
    
@endif


<div class="form-group">
    <label >Category name</label>
    {{--  --}}
    <x-form.input type="text" value="{{$categories->name}}" name="name"/>
</div>
  <div class="form-group">
      <label for="description">Category description</label>
      <x-form.textarea  value="{{$categories->description}}" name="description" rows="3" class="form-control" />
    </div>
  <div class="form-group">
    <label for="parent">Category parent</label>
    <select  class="form-control" id="parent" name="parent_id">
      <option value="">Primary Category</option>
  @foreach ($parents as $parent)
  <option value="{{$parent->id}}" @selected(old('parent_id',$categories->parent_id) == $parent->id)  >
    {{$parent->name}}
  </option>
  @endforeach
    
    </select>
  </div>
  <div class="form-group">
      
     <x-form.label id="image">Image</x-form.label>
      <x-form.input type="file" class="form-control" name="image"/>

  @if ($categories->image)
  <img src="{{asset('storage/'.$categories->image)}}" alt="" height="50px">
  
  @endif
    </div>
    <div class="form-check">
      <label for="status" style="margin: -20px">Status</label>
      <x-form.radio type="radio" value="{{$categories->status}}" :checked="$categories->status"
       name="status" :options="['active'=>'Active',
        'archived'=>'Archived']"/>
    </div>
    <div class="form-group">
     <button type="submit" class="btn btn-primary">{{$button_label ??'Save'}}</button>
    </div>