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
               <table class="table">
                 <thead>
                   <tr>
                     <th>Id</th>
                     <th>Product_id</th>
                     <th>Price</th>
                     <th>Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($item as $data)
                   <tr>
                     <td>{{$data->id}}</td><td>{{$data->product_id}}</td><td>{{$data->price}}</td><td><a href="/cartdelete/{{$data->id}}"><button type="button" class="btn btn-danger">Remove from cart</button></a></td>
                    
                   </tr>
                   @endforeach
                 </tbody>
               </table><br>
               <a href="{{url('checkout')}}"><button type="button" class="btn btn-primary">Buy Now</button></a>
             </div>
             
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>  
@endsection
