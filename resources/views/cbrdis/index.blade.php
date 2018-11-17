@extends('layouts.master')

@section('content')


	<div class="">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">CBR Humming Distance</h3>
			</div>

			<div class="box-body">
				<form action="{{route('cbrdis.store')}}" method="post">
					{{csrf_field()}}
					<table class="table table-responsive">
						<thead>
						<tr>
							<th>Problem</th>
							<th>Status<br>
								Email Client</th>
							<th>Profile User</th>
							<th>Jaringan</th>
							<th>Modify</th>
						</tr>

						</thead>

						<tbody>
						<tr>
							<td>
								<input required type="text" class="form-control" name="fact1" id="fact1">
							</td>
							<td>
								<input required type="text" class="form-control" name="fact2" id="fact2">
							</td>
							<td>
								<input required type="text" class="form-control" name="fact3" id="fact3">
							</td>
							<td>
								<input required type="text" class="form-control" name="fact4" id="fact4">
							</td>
							<td>
								<button type="submit" class="btn btn-success">Process</button>
							</td>
						</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
	@if($kasusBaru != null)
		<div class="">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Parameter</h4>
					<ul>
						<li>fatka1 = {{$kasusBaru['fact1']}}</li>
						<li>fatka2 = {{$kasusBaru['fact2']}}</li>
						<li>fatka3 = {{$kasusBaru['fact3']}}</li>
						<li>fatka4 = {{$kasusBaru['fact4']}}</li>
					</ul>
				</div>
				<input type="hidden" value="{{$i=1}}">

				<div class="box-body">
					<h3 class="box-title">Hasil</h3>
					<table class="table table-responsive">
						<thead>
						<tr>
							<th>No</th>
							<th>Problem</th>
							<th>Status<br>
								Email Client</th>
							<th>Profile User</th>
							<th>Jaringan</th>
							<th>Diagnosis & <br>
								Solving</th>
							<th>Result</th>
						</tr>

						</thead>

						<tbody>
						<p>
							{{--{{$arrCbrRes}}--}}
						</p>

						@foreach($arrCbrRes as $kas)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$kas->fact1}} (w={{$kas->fact1w}})</td>
								<td>{{$kas->fact2}} (w={{$kas->fact2w}})</td>
								<td>{{$kas->fact3}} (w={{$kas->fact3w}})</td>
								<td>{{$kas->fact4}} (w={{$kas->fact4w}})</td>
								<td>{!! $kas->solving !!}</td>
								<td>
									{{$kas->result}}
								</td>
							</tr>

						@endforeach
						</tbody>


					</table>
				</div>
			</div>
		</div>
	@endif
@endsection