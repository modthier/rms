@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث صنف  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('item.update',$item->id) }}" role="form" autocomplete="off" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }}
            <div class="form-group">
	            <label> اسم الصنف </label>
	            <input type="text" class="form-control" name="name"
                value="{{ $item->name }}"  required="">
            </div>

            <div class="form-group">
              <label> سعر الصنف </label>
              <input type="number" class="form-control" name="price"
               value="{{ $item->price }}"  required="">
            </div>




            <div class="form-group">
              <label> نوع الصنف </label>
              <select class="form-control" name="item_type_id" required="">
                  <option></option>
                  @foreach($itemTypes as $itemType)
                    <option value="{{ $itemType->id }}" @if($item->item_type_id == $itemType->id) selected @endif>{{ $itemType->type }}</option>
                  @endforeach
              </select>
            </div>


            <div class="form-group">
              <label> المكون الاساسي </label>
              <select class="form-control" name="ingredient_id" required="">
                  <option></option>
                  @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}" @if($item->ingredient_id == $ingredient->id) selected @endif>{{ $ingredient->ingredient }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>  صورة الصنف </label>
              <input type="file" name="icon" class="form-control">
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection