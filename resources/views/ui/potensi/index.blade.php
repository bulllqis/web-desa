@extends('layouts.ui')
@section('php')
<?php
    $potensi = \App\Potensi::orderBy('id','DESC')->get();
    $structur = \App\Structurdesa::paginate('8');
    $slider = \App\Slider::all();
    $quetes = \App\Quetes::all();



?>
@endsection

@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg bradcam_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>Potensi</h3>
                        <p><a href="">Home /</a> Potensi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->


    <!-- offers_area_start -->
    <div class="our_department_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-55">
                        <h3>Potensi</h3>
                        <p>Potensi Desa Patampanua<br>
                          Sangatlah banyak seperti berikut ini </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($potensi as $br)
                <div class="col-xl-4 col-md-6 col-lg-4" style="margin-top: 20px;">
                    <div class="single_department" style="height: 100%;">
                        <div class="department_thumb">
                            <img src="{{ asset('foto/'.$br->foto) }}" width="362" height="240" alt="">
                        </div>
                        <div class="department_content">
                            <h3><a href="assetz/#">{{ $br->nama_potensi }}</a></h3>
                            <p><?php
                                $num_char = 40;
                                echo substr($br->keterangan, 0, $num_char) . '.......';
                            ?></p>
                            <a href="/potensi/detail/{{ $br->id }}" class="learn_more">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- offers_area_end -->

    

<br><br><br>

@endsection