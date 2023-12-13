@extends('layouts.main')

@section('content')

<div class="col-lg-12">
	<div class="card">
		<div class="card-header">
			<h1 class="m-0 text-dark">{{ $user->name }}</h1>
		</div>
	</div>
</div>
<section class="col-lg-12">

    <div class="card">
        <div class="card-body table-responsive p-0">
            @if($results)
            @if($results->count() > 0)
            <table class="table table-hover">
                <thead>
                   
                    <th>المجموع</th>
                    <th>التاريخ</th>
                    
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                    <td>{{ number_format($result->total,2) }}</td>
                    <td>{{ $result->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @else
                  <h3  class="text-center text-danger">لا يوجد مبيعات</h3>
            @endif
            @endif
        </div>

        <div class="card-footer">
          {{ $results->links() }}
        </div>



    </div>
</section>


@endsection