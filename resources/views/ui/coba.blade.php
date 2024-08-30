@extends('layouts.ui')
@section('judul','Peta Wilayah')
@section('php')
<?php
    $potensi = \App\Potensi::orderBy('id','DESC')->paginate('6');
    $structur = \App\Structurdesa::all();
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
                        <h3>Peta Wilayah</h3>
                        <p><a href="#">Home /</a> Peta Wilayah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->
    <br><br><br>
    <h3 class="text-center">Peta Wilayah</h3>
    <div class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127328.9158119116!2d119.76565974095453!3d-4.214671206853037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d95edb216f64587%3A0x730d2646571e9f75!2sPatampanua%2C%20Kec.%20Marioriawa%2C%20Kabupaten%20Soppeng%2C%20Sulawesi%20Selatan!5e0!3m2!1sid!2sid!4v1721486899659!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15808.500483915574!2d111.47174076622538!3d-7.881975408697413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79a021fccdb069%3A0xc2525332d66f654b!2sPurbosuman%2C%20Kec.%20Ponorogo%2C%20Kabupaten%20Ponorogo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1581652095097!5m2!1sid!2sid"  width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe> -->
    </div>
    <br><br>


@endsection 