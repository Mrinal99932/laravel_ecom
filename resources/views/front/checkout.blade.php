@extends('front/layout')
@section('page_title', 'Cart Page')
@section('container')

<section id="aa-catg-head-banner">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      
     </div>
   </div>
</section>

<section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <div class="table-responsive">
               <h1>Your orders placed successfully</a></h1>
               <a href="{{url('/')}}"><button type="button" class="btn btn-info">Continue Shoping</button></a>
             </div>
             
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>  
@endsection
