@extends('layouts.master')

@section('content')


	<div class="">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Semua Kasus</h3>
			</div>

			<div class="box-body">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>No</th>
							<th>Problem</th>
							<th>Status <br>
								Email<br>
								Client</th>
							<th>Profile<br> User</th>
							<th>Jaringan<br> Komputer</th>
							<th>solving</th>
							{{--<th>Modify</th>--}}
						</tr>
						
					</thead>

					<tbody>

						@foreach($kasus as $kas)
							<tr>
								<td>{{$kas->id}}</td>
								<td>{{$kas->fact1}} (w={{$kas->fact1w}})</td>
								<td>{{$kas->fact2}} (w={{$kas->fact2w}})</td>
								<td>{{$kas->fact3}} (w={{$kas->fact3w}})</td>
								<td>{{$kas->fact4}} (w={{$kas->fact4w}})</td>
								<td>{!! $kas->solving !!}</td>
								{{--<td>--}}
									{{--<button class="btn btn-info"--}}
											{{--data-fact1="{{$kas->fact1}}" data-fact1w="{{$kas->fact1w}}"--}}
											{{--data-fact2="{{$kas->fact2}}" data-fact2w="{{$kas->fact2w}}"--}}
											{{--data-fact3="{{$kas->fact3}}" data-fact3w="{{$kas->fact3w}}"--}}
											{{--data-fact4="{{$kas->fact4}}" data-fact4w="{{$kas->fact4w}}"--}}
											{{--data-solving="{!! $kas->solving !!}"--}}
											{{--data-kasid={{$kas->id}}--}}
											{{--data-toggle="modal" data-target="#edit_kasus">Edit</button>--}}
									{{--/--}}
									{{--<button class="btn btn-danger" data-kasid={{$kas->id}} data-toggle="modal" data-target="#delete">Delete</button>--}}
								{{--</td>--}}
							</tr>

						@endforeach
					</tbody>


				</table>				
			</div>
		</div>
	</div>



	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
 	Add New
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Kasus Baru</h4>
      </div>
      <form action="{{route('kasus.store')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">
				@include('kasus.form')
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit_kasus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Kasus</h4>
      </div>
      <form action="{{route('kasus.update','test')}}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
	      		<input type="hidden" name="kas_id" id="kas_id" value="">
				@include('kasus.form')
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save Changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <form action="{{route('kasus.destroy','test')}}" method="post">
      		{{method_field('delete')}}
      		{{csrf_field()}}
	      <div class="modal-body">
				<p class="text-center">
					Are you sure you want to delete this?
				</p>
	      		<input type="hidden" name="category_id" id="cat_id" value="">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
	        <button type="submit" class="btn btn-warning">Yes, Delete</button>
	      </div>
      </form>
    </div>
  </div>
</div>


@endsection