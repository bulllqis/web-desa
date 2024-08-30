@extends('layouts.ui')
@section('judul','visi-misi')
@section('php')
<?php
  $sezarah = \App\Webs::get();
    foreach ($sezarah as $sez);


?>
@endsection

@section('content')
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg bradcam_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>Visi Misi</h3>
                        <p><a href="">Home /</a> Visi Misi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

		<div class="container">
            <div class="section-top-border">
				<h3 class="mb-30">Visi-misi Desa</h3>
				<div class="row">
					<div class="col-lg-12">
						<blockquote class="generic-blockquote">
                            <h4>“PATAMPANUA INOVATIF DAN RELIGIUS PADA TAHUN 2024”</h4>
                            <P>Penjabaran dari Visi tersebut akan dilakukan melalui 4 (empat) Misi sebagai berikut:</P>
                            <P>- Akselerasi Pembangunan berbasis kepemudaan;</P>
                            <P>- Terwujudnya produk unggulan desa;</P>
                            <P>- Pemberdayaan perempuan dan kesetaraan gender; dan</P>
                            <P>- Pengembangan kewirausahaan dan kepariwisataan.</P>
                            <h5>Tujuan dan Sasaran</h5>
                            <P>Untuk menopang upaya perwujudan Visi dan Misi, maka ditetapkan 4 (empat) Kebijakan Pokok Strategis, yakni:</P>
                            <P>- Pembentukan Organisasi Kepemudaan;</P>
                            <P>- Penetapan jenis produk unggulan desa;</P>
                            <P>- Peran perempuan dalam pembangunan desa; dan</P>
                            <P>- Pembangunan taman wisata religi.</P>
                            
                            </blockquote>
					</div>
				</div>
			</div>
        </div>
@endsection