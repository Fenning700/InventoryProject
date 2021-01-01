@extends('base')

@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Add a product</h1>
  <div>
      <form method="post" action="{{ route('inventory.store') }}">
          @csrf
          <div class="form-group">    
              <label for="name">New Product Name:</label>
              <input type="text" class="form-control" name="name"/>
          </div>

          <div class="form-group">
              <label for="quantity">Product Quantity:</label>
              <input type="number" class="form-control" name="quantity"/>
          </div>
                    
          <button type="submit" class="btn btn-primary-outline">Add product</button>
      </form>
  </div>
</div>
</div>
@endsection