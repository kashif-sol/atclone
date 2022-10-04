@extends('shopify-app::layouts.default')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style>
    .form-apps{
        max-width: 100% !Important;
    }
    .response_mail {
border: 1px solid;
padding: 5px;
margin-top: 10px;
margin-bottom: 0px;
text-align: center;
color: #008060;
display: none;
}
        img {
            max-width: 100%;
        }
        .learn-more {
            padding: 10px 0;
            background-color: #fff0;
            width: 300px;
            border-radius: 30px;
            margin: 0 auto;
            line-height: 51px;
            border: 1px solid #8a8a8a30;
            font-size: 13px;
        }
        .learn-more img {
            margin-bottom: 3px;
            height: 14px;
        }
        .learn-more a {
            color: #007bff;
        }
        .loader {
            margin: 0 auto;
            background: transparent;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }
        .modal-lg {
            top: calc( 50% - 120px );
        }
        .modal-content-loading{background: transparent;}
        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .p_2t1TD {
            color: #fff;
        }
        .p_3iVHs {
            position: relative;
            display: flex;
            align-items: center;
            margin: .4rem;
        }
        .p_2-hnq {
            display: inline-block;
            height: 20px;
            width: 20px;
            max-height: 100%;
            max-width: 100%;
            margin: auto;
            margin-right: 5px;
            top: 5px;
        }
        .p_3yL9P:after {
            background-color: #fff;
        }

        .p_3iVHs:after {
            content: "";
            position: absolute;
            z-index: 1;
            top: -.4rem;
            bottom: -.4rem;
            left: -.4rem;
            right: -.4rem;
            border-radius: 50%;
        }
        .p_3yL9P svg {
            fill: #007bff;
        }
        .p_219ua, .p_v3ASA {
            position: relative;
            z-index: 2;
            display: block;
            width: 100%;
            max-width: 100%;
            max-height: 100%;
        }

h5.alert-heading {
    color: #000;
    font-size: 20px;
}

.alert.alert-warning {
   display: flex;
    gap: 14px;
    padding: 30px;
}

.modal-dialog {
    max-width: 700px;
}
ul.nav.nav-tabs li a {
    text-align: center;
    background: #4071e9;
    color: #fff;
    border: 0;
    border-radius: 4px;
    text-decoration: none;
    width: 120px;
    /* height: 40px; */
    cursor: pointer;
    margin-right: 17px;
    padding: 9PX;
}
div#Analytics {
    margin-top: 20px;
}
ul.nav.nav-tabs li a {
    color: #fff;
}

.loader {
   margin: 0 auto;
    background: transparent !Important;
    border: 16px solid #f3f3f3 !Important;
    border-radius: 50% !Important;
    border-top: 16px solid #3498db !Important;
    width: 120px !Important;
    height: 120px !Important;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

.loader:after {
    content: unset !Important;

}

    </style>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/flags.css') }}" />
    <script type="text/javascript" src="{{ URL::asset('js/flags.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    
    <script>
        var ps_config = {
            productId : "159a468c-e785-402d-9aea-b3eedb47b490"
        };
    </script>

@endsection

@section('content')
<section role="main" class="content-body content-body-modern">


	<!-- start: page -->
	
	<div class="row">
		<div class="col">

			<div class="card card-modern card-modern-table-over-header">
			
				<div class="card-body">
                <style>
 

.table-pricing h1 {
    color: rgb(94, 19, 217)
}

.col-md-3 {
    margin-top: 25px
}
li.not-availabe {
    color: #b0abab;
    text-decoration: line-through;
}

li {
    list-style: none;
    text-align: center;
}
ul {
    padding: 0px;
    margin: 0px;
}

@media only screen and (max-width: 600px) {
    .col-md-4.col-xs-12.col-sm-12 {
        width: 50%;
    }
}
    </style>

    <!-- here plans start -->
    <div style="margin-bottom: 50px;" class="text-center container mt-5">
    <h1 class="" style="font-weight: 700;"><i class="fa-solid fa-box-open"></i> Pricing Plans</h1><span class=""><br><br></span>
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="text-center  p-5 table-pricing shadow-lg">
                    <h2 class="text-uppercase" style="font-weight: 700;">{{$plan->name}}</h2>
                    <h1 style="color: #191C21; font-weight: 600;">${{$plan->price}}/month</h1></span><br>
                    <ul>
                         
                        <li>Unlimited Clicks</li>
                        <li>Total Customization</li>
                        <li>Performance Tracking</li>
                        <li>Mobile and Desktop Responsive</li>
                        <li class="@if($plan->id == 1) not-availabe @endif">Pixels & Tracking ID</li>
                    </ul>
                    @php
                        $plan_id = Auth::user()->plan_id;
                    @endphp

                    @if($plan_id != $plan->id)
                        <a  href="{{ route('billing', ['plan' => $plan->id, 'shop' => Auth::user()->name]) }}" class="btn btn-default btn-block mt-4" type="button"> @if($plan->id == 1) Downgrade @else Upgrade @endif</a>
                    @else
                        <a  href="#" class="btn btn-default btn-block mt-4" type="button" style="background-color: #47A447; color: white;">Active</a>
                    @endif
                    <p class="mt-3">3-day free trial</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
                <!-- here plans start -->

				
		</div>
	</div>
	<!-- end: page -->
</section>


<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>

	
</script>
@endsection