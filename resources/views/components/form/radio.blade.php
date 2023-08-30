
@props(['type','value'=>'','name','checked'=>false,'options'])
@foreach ($options as $value=>$text)
    



   <div>
    <input type="{{$type}}" name="{{$name}}" id="status" value="{{$value}}" 
    {{$attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)
])
}}
    @checked(old($name,$checked) ==$value)>
    <label class="form-check-label" for="status">
  {{$text}}
    </label>
   </div>
   @endforeach