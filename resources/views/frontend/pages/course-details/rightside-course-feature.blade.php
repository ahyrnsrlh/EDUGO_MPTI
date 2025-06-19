<div class="card card-item">
    <div class="card-body">
        <h3 class="card-title fs-18 pb-2">Fitur Kursus</h3>
        <div class="divider"><span></span></div>

        <ul class="generic-list-item generic-list-item-flash">
            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-clock mr-2 text-color"></i>Durasi</span> {{$total_lecture_duration}} jam</li>
            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-play-circle-o mr-2 text-color"></i>Materi</span> {{$total_lecture}}
            </li>
            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-file-text-o mr-2 text-color"></i>Sumber Daya</span> {{$course->resources}}</li>


            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-language mr-2 text-color"></i>Bahasa</span> Bahasa Indonesia
            </li>
            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-lightbulb mr-2 text-color"></i>Tingkat Kesulitan</span>
                        <span style="text-transform: capitalize">
                            @if($course->label == 'Begginer') Pemula
                            @elseif($course->label == 'Middle') Menengah  
                            @elseif($course->label == 'Advance') Lanjutan
                            @else {{$course->label}}
                            @endif
                        </span></li>


            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-users mr-2 text-color"></i>Siswa</span> 15</li>
            <li class="d-flex align-items-center justify-content-between"><span><i
                        class="la la-certificate mr-2 text-color"></i>Sertifikat</span> {{$course->certificate == 'yes' ? 'Ya' : 'Tidak'}}
            </li>
        </ul>

    </div>
</div><!-- end card -->
