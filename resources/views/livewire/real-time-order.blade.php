<div>
   <div class="container">
	<div class="row">
		<div class="col-lg-12"> 
    @foreach($orders as $type)
<div class="card">
				
				 <div class="card-header d-flex justify-content-between align-items-center">
				    
				      <div>
              <button type="button" data-toggle="collapse" href="#cat_{{ $type->id }}" class="btn btn-primary" aria-expanded="true">
				       رقم الفاتورة : {{ $type->id }}
				      </button>
              </div>
              <div>
                
                    <button wire:click="updateOrderStatus('{{$type->id}}')" class="btn btn-primary d-100">تم</button>
               
              </div>
				    </h2>
          </div>
				   <div class="card-body p-0">
           <div id="cat_{{ $type->id }}" class="collapse @if ($loop->first) show @endif">
				      
              <table class="table table-hovered table-lg">
                  <th> اسم الصنف </th>
                  <th> سعر الصنف </th>
                  <th> الكمية </th>
                  <th> المجموع </th>
                  @foreach($type->items as $item)
                  <tr>
                      <td>{{ $item->name }}</td>
                      <td>
                          {{ $item->pivot->price / $item->pivot->quantity }}
                      </td>
                      <td>{{ $item->pivot->quantity }}</td>
                      <td>{{ $item->pivot->price }}</td>
                  </tr>
                  @endforeach
              </table>
   
</div>
           </div>

				    
                   
                </div>
                @endforeach
                </div>
              </div>
            </div>  
			
</div>
