@extends('layout.master')
@section('title','All Blogs')

@section('content')
<div class="row">
 @foreach($blogs as $blog)
   <div class="col-md-4 mb-4">
     <div class="card h-100">
       @if($blog->image)
         <img src="{{ Storage::url($blog->image) }}" class="card-img-top" style="height:180px;object-fit:cover">
       @endif
       <div class="card-body">
         <h5 class="card-title">{{ $blog->title }}</h5>
         <p class="card-text">{{ Str::limit($blog->description, 120) }}</p>
       </div>
     </div>
   </div>
 @endforeach
</div>

{{-- {{ $blogs->links() }}  --}}
@endsection
