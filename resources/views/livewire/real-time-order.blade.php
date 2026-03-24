<div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@foreach($orders as $type)
					<div class="cashier-card cashier-live-card mb-3">
						<div class="cashier-card-header">
							<div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
								<button
									type="button"
									class="btn btn-primary btn-sm"
									data-bs-toggle="collapse"
									data-bs-target="#cat_{{ $type->id }}"
									aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
								>
									رقم الفاتورة: {{ $type->id }}
								</button>
								<span class="text-muted small">نوع الطلب: {{ $type->orderType->name }}</span>
							</div>
							<button type="button" wire:click="updateOrderStatus('{{ $type->id }}')" class="btn btn-primary btn-sm">تم</button>
						</div>
						<div class="cashier-card-body p-0">
							<div id="cat_{{ $type->id }}" class="collapse @if ($loop->first) show @endif">
								<div class="cashier-table-wrap">
									<table class="cashier-table table table-lg mb-0">
										<thead>
											<tr>
												<th>اسم الصنف</th>
												<th>سعر الصنف</th>
												<th>الكمية</th>
												<th>المجموع</th>
											</tr>
										</thead>
										<tbody>
											@foreach($type->items as $item)
												<tr>
													<td>{{ $item->name }}</td>
													<td>{{ $item->pivot->price / $item->pivot->quantity }}</td>
													<td>{{ $item->pivot->quantity }}</td>
													<td>{{ $item->pivot->price }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
