@extends('layouts.ui')
@section('php')
<?php
    $brita = \App\Brita::orderBy('id','DESC')->paginate('6');
    $structur = \App\Structurdesa::paginate('8');
    $galery = \App\Galery::all();


?>
@endsection

@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg bradcam_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>Budaya</h3>
                        <p><a href="">Home /</a> Budaya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <div class="our_department_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center">
                        <h3>Gallery Budaya</h3>
                    </div>
                </div>
            </div>
            <div class="our_department_area">
            <div class="row">
                @foreach($galery as $ga)
                <div class="col-xl-4 col-md-6 col-lg-4" style="margin-top: 10px;">
                    <div class="single_department"  style="height: 100%;">
                        <div class="department_thumb" style=" background-image: url('{{ asset('foto/'.$ga->foto) }}'); background-size: cover; background-position: center;">
                        <a href="{{ asset('foto/'.$ga->foto) }}" class="img-pop-up">
							<div class="single-gallery-image"  style=" background-image: url('{{ asset('foto/'.$ga->foto) }}'); background-size: cover; background-position: center;"></div>
						</a>
                            <a href="{{ asset('foto/'.$ga->foto) }}" class="img-pop-up"></a> 
                        </div>
                        
                        <div class="department_content">
                        <h4>{{ $ga->judul}}</h4> 
                        <a href="/budaya/detail/{{ $ga->id }}" class="learn_more">Selengkapnya</a>
                    </div>

                        
                    </div>
                </div>
                @endforeach
            </div>
            </div>
          
        </div>
    </div>
			
			</div>
				</div>
			
@endsection