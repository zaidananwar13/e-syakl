@extends('home/master2')
@section('judul', 'Dashboard')
@section('dashboard', 'active')
@section('sidebar')
  @parent
@endsection

@section('content')
  @parent
               

								<div class="col-xl-12 ps-xl-12">
									<!--begin::Engage widget 1-->
									<div class="card bgi-position-y-bottom bgi-position-x-end bgi-no-repeat bgi-size-cover min-h-250px bg-primary mb-5 mb-xl-8" style="background-position: 100% 50px;background-size: 500px auto;background-image:url('assets/media/misc/city.png')">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column justify-content-center">
											<!--begin::Title-->
											<h3 class="text-white fs-2x fw-bolder line-height-lg mb-5">Quote Hari ini
											<br />E - Syakl</h3>
											<!--end::Title-->
											<!--begin::Action-->
											<div class="m-0">
												<a href='#' class="btn btn-success fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#">I'm Feeling Lucky Today</a>
											</div>
											<!--begin::Action-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 1-->
								</div>

								
              
@endsection

@section('footer')
  @parent
@endsection