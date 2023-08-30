
@props(['type'=>'text','value'=>'','name'])
<input type="{{$type}}" {{$attributes->class(['form-control', 'is-invalid' => $errors->has($name)
])
}}
     name="{{$name}}" value="{!! old($name,$value)!!}"  placeholder="category name"/>

  @error($name)
      <div class="invalid-feedback">
        {{$message}}
      </div>
  @enderror