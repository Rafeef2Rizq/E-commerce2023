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
    <label >Product name</label>
    {{--  --}}
    <x-form.input type="text" value="{{$products->name}}" name="name"/>
</div>
  <div class="form-group">
      <label for="description">Product description</label>
      <x-form.textarea  value="{{$products->description}}" name="description" rows="3" class="form-control" />
    </div>
    
  <div class="form-group">
    <label for="category">Product category</label>
    <select  class="form-control" id="category" name="category_id">
      <option value="">Primary Product</option>
  @foreach (App\Models\Category::all() as $category)
  <option value="{{$category->id}}" @selected(old('category_id',$products->category_id) == $category->id)  >
    {{$category->name}}
  </option>
  @endforeach
    
    </select>
  </div>
  <div class="form-group">
      
     <x-form.label id="image">Image</x-form.label>
      <x-form.input type="file" class="form-control" name="image"/>

  @if ($products->image)
  <img src="{{asset('storage/'.$products->image)}}" alt="" height="50px">
  
  @endif
    </div>
     <div class="form-group">
      <label for="price">Product price</label>
    <x-form.input type="text" value="{{$products->price}}" name="price"/>
    </div>
     <div class="form-group">
      <label for="price">Compare price</label>
    <x-form.input type="text" value="{{$products->compare_price}}" name="compare_price"/>
    </div>
       <div class="form-group">
      <label for="tag">Tags</label>
    <x-form.input value="{!! $tags !!}" name="tags"/>
    </div>
    <div class="form-check">
      <label for="status" style="margin: -20px">Status</label>
      <x-form.radio type="radio" value="{{$products->status}}" :checked="$products->status"
       name="status" :options="['active'=>'Active',
        'archived'=>'Archived']"/>
    </div>
    <div class="form-group">
     <button type="submit" class="btn btn-primary">{{$button_label ??'Save'}}</button>
    </div>
    <script>
      // The DOM element you wish to replace with Tagify
var input = document.querySelector('input[name=tags]');
    tagify = new Tagify (input);
    </script>