@extends('backend.layouts.app')
@section('content')
<!-- Default box -->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">@lang('User List')</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
			<a href="{{ route('admin.user-management.user-info.add') }}" class="btn btn-sm btn-info" ><i class="fas fa-plus"></i> @lang('Add User')</a>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="user_table_list" class="table table-bordered table-striped">
				<thead>
					<tr class="text-center">
						<th>@lang('Serial')</th>
						<th>@lang('ID')</th>
						<th>@lang('Name')</th>
						<th>@lang('Email')</th>
						<th>@lang('Permission')</th>
						<th width="15%">@lang('Action')</th>
					</tr>
				</thead>
				<tbody>
					@if (isset($users) && count($users) > 0)
					@foreach ($users as $u)
					<tr>
						<td>{{ digitDatelang($loop->iteration) }}</td>
						<td>{{ digitDatelang($u->profileID ?? $u->employee_id) }}</td>
						<td>
							@if (session()->get('language') == 'bn')
							{{ $u->name_bn }}
							@else
							{{ $u->name }}
							@endif
						</td>
						<td>{{ $u->email }}</td>
						<td><?php echo AccessRole(@$u->user_role) ?></td>
						<td>
							<a href="{{ route('admin.user-management.user-info.edit',$u->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
							<a href="{{ route('admin.user-management.user-info.show', $u->id) }}"
								class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
							<a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
						</td>
					</tr>
					@endforeach
					@else
					<tr class="text-center bg-danger">
						<td colspan="12" >@lang('No Data Found')</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.card-body -->
</div>
<!-- /.card -->
<script>
	$(document).ready(function(){
		$("#user_table_list").dataTable({
			"ordering": false
		});
	});
</script>
@endsection