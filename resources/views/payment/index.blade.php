@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   طرق الدفع  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('payment.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
          <table class="table table-hover table-lg">
                <th> طريقة الدفع </th>
                <th>عمليات</th>

                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->method }}</td>
                    <td>
                       
                        <a href="{{ route('payment.edit',$payment->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>

                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        
    </div>
</div>


</div>	

@endsection