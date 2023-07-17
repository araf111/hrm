@extends('backend.layouts.app')
@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h4 class="m-0 text-dark">@lang('Telephone/PABX Approval Stage')</h4>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
					<li class="breadcrumb-item active">@lang('Telephone/PABX Approval Stage')</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					@if(!count(@$editData))
					<div class="card-header text-right">
						<a href="{{route('admin.requisition.telephone_pabx_approval_steps.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add Telephone/PABX Approval Stage')</a>
					</div>
					@endif
					<div class="card-body">
						<table class="rowspandatatableeaccommodationapprovalstep table table-sm table-bordered table-striped">
							<tbody>
								@foreach($accommodation_approval_steps as $list)
								<tr>
									<td width="5%">{{ digitDateLang($loop->iteration)}}</td>
									<td>{{(session()->get('language')=='bn')?(@$list['role']['name_bn']):@$list['role']['name']}}</td>
									<td>{{digitDateLang($list->stage)}}</td>
									<td>{!! activeStatus($list->status) !!} </td>
									<td class="text-center" width="5%">
										<a class="btn btn-sm btn-success" href="{{route('admin.requisition.telephone_pabx_approval_steps.create')}}">
											<i class="fa fa-edit"></i>
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    $(document).ready( function () {
        var table = $('.rowspandatatableeaccommodationapprovalstep').DataTable({
            pageLength:100,
            ordering: false,
            columns: [
            {
                name: 'sl',
                title: "@lang('Serial')",
            },
            {
                name: 'role',
                title: "@lang('Role Name')",
            },
            {
                name: 'stage',
                title: "@lang('Stages')",
            },
            {
                name: 'status',
                title: "@lang('Status')",
            },
            {
                name: 'action',
                title: "@lang('Action')",
            }
            ],
            rowsGroup: [
            'action:name'
            ],
        });
    });

</script>
@endsection