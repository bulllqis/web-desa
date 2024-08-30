@extends('layouts.ui')
@section('judul',$budaya->judul)
@section('php')

<?php

  $post = \App\Brita::orderBy('id','DESC')->paginate('4');
  
?>
@endsection
@section('content')


  <!-- bradcam_area_start  -->
  <div class="bradcam_area breadcam_bg bradcam_overlay">
      <div class="container">
          <div class="row">
              <div class="col-xl-12">
                  <div class="bradcam_text">
                      <h3>Detail Budaya</h3>
                      <p><a href="index.html">Home /</a> Detail Budaya</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- bradcam_area_end  -->

   <!--================Blog Area =================-->
   <section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 posts-list">
               <div class="single-post">
                  <div class="feature-img">
                     <img class="img-fluid" src="{{ asset('foto/'.$budaya->foto) }}" alt="{{ $budaya->judul }}" width="100%" height="375">
                  </div>
                  
                  <div class="blog_details">
                     <h2> {{ $budaya->judul }} </h2>
                     
                     <p class="excert">
                     {!! nl2br(e($budaya->keterangan)) !!}
                     </p>
             
                  </div>
               </div>
               <div class="navigation-top">
                  <div class="d-sm-flex justify-content-between text-center">
                
                     <div class="col-sm-4 text-center my-2 my-sm-0">
                     </div>
                     
                  </div>
           
               </div>
            </div>
            
                  
              
            </div> 
         </div>
      </div>
   </section>
   <!--================ Blog Area end =================-->


@endsection