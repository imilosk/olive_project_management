@extends('../body')

@section('content')

    @if($msg) 
        <p id="message"> {{ $msg }}<p>
    @endif


<section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Login Now</h2>
		    <form action="/login" method="post">
                <div class="form-group">
                    <label for="email" class="text-uppercase">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="">
                </div>
            
                <div class="form-group">
                <button type="submit" name="submitButton"class="btn btn-login float-right">Submit</button>
                </div>
            </form>
		</div>

		<div class="col-md-8 banner-sec">
            <div class="carousel-item active">
                <img class="d-block img-fluid" src="https://cdn.shopify.com/s/files/1/1519/8146/products/167a_BenR_170130.jpg" alt="First slide">
      
                <div class="banner-text">
                    <h2>This is Heaven</h2>
                </div>	
            </div>
        </div>
    </div>
    </div>
</section>



 

@endsection


<style>

@import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
.login-block{
    background: olive; 
    float:left;
    width:100%;
    padding : 50px 0;
}
.banner-sec{background:url(https://cdn.shopify.com/s/files/1/1519/8146/products/167a_BenR_170130.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 50px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
.login-sec .copy-text i{color:#FEB58A;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: olive;}
.btn-login{background: olive; color:#fff; font-weight:600;}

.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
.banner-text h2{color:#fff; font-weight:600; text-align:center;}
.banner-text p{color:#fff;}
</style>