@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
    $lastmodal=\App\Http\Controllers\HomeController::lastmodal();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('css')
    <style>
        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            width: 70%;
            min-width: 300px;
        }

        /* Style the input fields */
        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
    </style>
    @endsection
@section('content')

    <div class="container-fluid" id="grad1">
        <div class="row justify-content-center mt-0">
            <form id="regForm" action="{{route("plannertocart")}}" method="post">
                @csrf

                <input type="hidden" name="citid" id="citid">
                <input type="hidden" name="citvid" id="citvid">
                <input type="hidden" name="citsayisi" id="citsayisi">
                <input type="hidden" name="baba" id="baba">
                <input type="hidden" name="babaadet" id="babaadet">
                <input type="hidden" name="kapiid" value="0" id="kapiid">
                <input type="hidden" name="kapi" value="0" id="kapi">
                <input type="hidden" name="kapigenislik" value="0" id="kapigenislik">
                <input type="hidden" name="kapisayisi" value="0" id="kapisayisi">
                <input type="hidden" name="kapiadetx" value="0" id="kapiadetx">
                <h2 style="text-align: center">Zau Planner</h2>
                <div class="tab"><h3>Çit Uzunluğu <b>(mm)</b></h3>
                    <p>                            <input style="width:50%" type="number" name="uzunluk" id="uzunluk">
                    </p>
                </div>
                <div class="tab"><h3>Çit Tipi Seçiniz:</h3>
                    
                    <div class="row">

                        @foreach($data as $key=>$rs)
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="{{asset($rs->image)}}" alt="Card image cap">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$rs->name}}</h5>

                                        <b>Seçiniz</b>

                                            <input type="radio" class="pid"  onclick="variantsfetch({{$rs->id}})" id="pid" name="pid" value="{{$rs->id}}">



                                    </div>
                                </div>
                            </div>
                        @endforeach





                    </div>

                </div>
                <div class="tab">Çit Seçenekleri:
                    <div class="row" id="variants">

                    </div>
                </div>
                <div class="tab">Baba Seçiniz:
                    <div class="row">

                        @foreach($baba as $rs)
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="{{asset($rs->image)}}" alt="Card image cap">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$rs->name}}</h5>
                                        <input type="radio" class="bpid" onclick="babasec({{$rs->id}})"  name="pid" value="{{$rs->id}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach





                    </div>
                </div>
                <div class="tab">Kapı Tipi:
                    <div class="row" id="kapilist">

                        @foreach($kapi as $rs)
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="{{asset($rs->image)}}" alt="Card image cap">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$rs->name}}</h5>
                                        <input   type="number" onchange="setkapiadet({{$rs->id}})" value="1" style="width: 20% !important;" class="kapiadet" name="kapiadet" id="kapiadet-{{$rs->id}}">
                                        <input class="kpid" id="kpid-{{$rs->id}}" type="checkbox" data-kapiid="{{$rs->productID}}" data-kapisayisi="1"  data-width="{{$rs->width}}" name="kapix" value="{{$rs->id}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach





                    </div>
                </div>
                <div class="tab">
                    <div class="row">
                        <div class="col-md-4" id="sonuc">

                        </div>

                    </div>
                </div>
                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" class="btn btn-solid btn-xs"  onclick="nextPrev(-1)">Geri</button>
                        <button type="button" id="nextBtn" class="btn btn-solid btn-xs" onclick="nextPrev(1)">İleri</button>
                    </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
            </form>


        </div>
    </div>
@endsection


@section('js')
    <script>
        window.localStorage.clear();

        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...

            if(n==5)
            {

                var cituzunluk=parseInt($("#uzunluk").val());
                var kapigenislik=parseInt($("#kapigenislik").val());
                var kapisayisi=parseInt($("#kapisayisi").val());
                var citadet=Math.ceil(((cituzunluk-kapigenislik)/2500));
                $("#citsayisi").val(citadet);
                $("#babaadet").val(citadet);
                var babaadet=(citadet+1)-kapisayisi;
                $("#babaadet").val(babaadet);

                var msj='<div class="alert alert-primary" role="alert"><ul class="list-group">';
                msj+=' <li class="list-group-item text-center">Hesaplama Sonucu:</li>';
                msj+=' <li class="list-group-item">Çit Uzunluğu : '+(cituzunluk/1000)+' m</li>';
                msj+=' <li class="list-group-item">Toplam Kapı Sayısı : '+kapisayisi+'</li>';
                msj+=' <li class="list-group-item">Toplma Kapı Genişliği : '+kapigenislik+'</li>';
                msj+=' <li class="list-group-item">Girilen Değerlere Göre :</li>';
                msj+=' <li class="list-group-item">Gerekli Çit Sayısı : '+citadet+'</li>';
                msj+=' <li class="list-group-item">Gerekli Baba Sayısı : '+babaadet+'</li>';
                msj+='</ul></div>';

                $("#sonuc").html(msj);
            }
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Sepete At";
            } else {
                document.getElementById("nextBtn").innerHTML = "İleri";
            }
            //... and run a function that will display the correct step indicator:


            fixStepIndicator(n)
        }

        function nextPrev(n) {


            if(currentTab==0)
            {
                if($('#uzunluk').length > 0 && $('#uzunluk').val() != '')
                {
                    // This function will figure out which tab to display
                    var x = document.getElementsByClassName("tab");
                    // Exit the function if any field in the current tab is invalid:
                    // Hide the current tab:
                    x[currentTab].style.display = "none";
                    // Increase or decrease the current tab by 1:
                    currentTab = currentTab + n;
                    // if you have reached the end of the form...
                    if (currentTab >= x.length) {
                        // ... the form gets submitted:
                        document.getElementById("regForm").submit();
                        return false;
                    }
                    showTab(currentTab);
                }
                else
                {
                    alert("Lütfen Çit Uzunluğunu Giriniz");
                }

            }
            else if (currentTab==1)
            {

                var pid= $(".pid:checked").val();
               if(pid)
               {
                   // This function will figure out which tab to display
                   var x = document.getElementsByClassName("tab");
                   // Exit the function if any field in the current tab is invalid:
                   // Hide the current tab:
                   x[currentTab].style.display = "none";
                   // Increase or decrease the current tab by 1:
                   currentTab = currentTab + n;
                   // if you have reached the end of the form...
                   if (currentTab >= x.length) {
                       // ... the form gets submitted:
                       document.getElementById("regForm").submit();
                       return false;
                   }
                   showTab(currentTab);

               }
                else
                {
                    alert("Lütfen Çit Tipi Seçiniz");
                }

            }
            else if(currentTab==2)
            {
                var cpid= $(".cpid:checked").val();
                if(cpid)
                {
                    // This function will figure out which tab to display
                    var x = document.getElementsByClassName("tab");
                    // Exit the function if any field in the current tab is invalid:
                    // Hide the current tab:
                    x[currentTab].style.display = "none";
                    // Increase or decrease the current tab by 1:
                    currentTab = currentTab + n;
                    // if you have reached the end of the form...
                    if (currentTab >= x.length) {
                        // ... the form gets submitted:
                        document.getElementById("regForm").submit();
                        return false;
                    }
                    showTab(currentTab);

                }
                else
                {
                    alert("Lütfen Çit Seçiniz");
                }
            }
            else if(currentTab==3)
            {
                var bpid= $(".bpid:checked").val();
                if(bpid)
                {
                    // This function will figure out which tab to display
                    var x = document.getElementsByClassName("tab");
                    // Exit the function if any field in the current tab is invalid:
                    // Hide the current tab:
                    x[currentTab].style.display = "none";
                    // Increase or decrease the current tab by 1:
                    currentTab = currentTab + n;
                    // if you have reached the end of the form...
                    if (currentTab >= x.length) {
                        // ... the form gets submitted:
                        document.getElementById("regForm").submit();
                        return false;
                    }
                    showTab(currentTab);

                }
                else
                {
                    alert("Lütfen Baba Seçiniz");
                }
            }

            else if(currentTab==4)
            {
                var kpid= $(".kpid:checked").val();
                if(kpid)
                {
                    // This function will figure out which tab to display
                    var x = document.getElementsByClassName("tab");
                    // Exit the function if any field in the current tab is invalid:
                    // Hide the current tab:
                    x[currentTab].style.display = "none";
                    // Increase or decrease the current tab by 1:
                    currentTab = currentTab + n;
                    // if you have reached the end of the form...
                    if (currentTab >= x.length) {
                        // ... the form gets submitted:
                        document.getElementById("regForm").submit();
                        return false;
                    }
                    showTab(currentTab);

                }
                else
                {
                    alert("Lütfen Kapı Seçiniz");
                }
            }
            else
            {
                var x = document.getElementsByClassName("tab");
                // Exit the function if any field in the current tab is invalid:
                // Hide the current tab:
                x[currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                currentTab = currentTab + n;
                // if you have reached the end of the form...
                if (currentTab >= x.length) {
                    // ... the form gets submitted:
                    document.getElementById("regForm").submit();
                    return false;
                }
                showTab(currentTab);
            }




        }


        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });



        function variantsfetch(id)
        {
            $("#citid").val(id);
            $.ajax({
                type: 'POST',
                url: '{{route("Product.variantsfetch")}}',
                data:{id:id},

                success: function(results) {

                    console.log(results.success);
                    if (results.success === true) {

                        console.log(results.data);
                        let variants="";
                        for(let i=0;i<results.data.length;i++)
                        {
                            variants+='<div class="col-md-4 mb-2">';
                            variants+='<div class="card" style="width: 18rem;">';
                            variants+='<img class="card-img-top" src="'+results.data[i]['image']+'" alt="Card image cap">';
                            variants+='<div class="card-body text-center">';
                            variants+='<h5 class="card-title">'+results.data[i]['name']+'</h5>';
                            variants+='<b>Seçiniz</b><input type="radio" class="cpid" onclick="citsec('+results.data[i]['id']+')" name="pid" value="'+results.data[i]['id']+'">';
                            variants+='</div></div></div>';



                        }
                        document.getElementById("variants").innerHTML =variants;

                    } else {
                        console.log("bb");
                    }
                }
            });
        }


       function setkapiadet(x)
        {

        $('#kpid-'+x).attr("data-kapisayisi", $('#kapiadet-'+x).val()); //setter


        }


        $('#kapilist').change(function() {
            {

                var genislik=0;
                var array=[];
                var arraykapiadet=[];
                var kapisayisi=0;
                var kapiid=0;
                $('#kapilist :checked').each(function() {


                    genislik=genislik+(parseInt(($(this).data('width')))*parseInt(($('#kapiadet-'+$(this).val()).val())));
                    kapiid=$(this).data('kapiid');
                    //kapisayisi=kapisayisi+1;
                    kapisayisi=kapisayisi+1;
                    array.push($(this).val());
                    arraykapiadet.push($('#kapiadet-'+$(this).val()).val());


                });
                console.log(array);
                console.log("----------------------------------------");
                console.log("Kapı Sayısı :"+kapisayisi);
                console.log("Genişlik :"+genislik);
                console.log("Kapılar :"+array);
                console.log("Adetler :"+arraykapiadet);
                $('#kapi').val(array);
                $('#kapiadetx').val(arraykapiadet);
                $('#kapiid').val(kapiid);
                $('#kapigenislik').val(genislik);
                $('#kapisayisi').val(kapisayisi);



            }
        });

        function citsec(cvid)
        {
            $("#citvid").val(cvid);
        }

        function babasec(bid)
        {
            $("#baba").val(bid);

        }

    </script>
@endsection


