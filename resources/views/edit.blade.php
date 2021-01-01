@extends('base') 
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update Inventory</h1>

        <form method="post" action="{{ route('inventory.update', $product->id) }}">
            @method('PATCH') 
            @csrf
            <div class="form-group">

                <label for="Name">Product Name:</label>
                <input type="text" class="form-control" name="name" value={{ $product->name }} />
            </div>

            <div class="form-group">
                <label for="quantity">Additional info:</label>
                <input type="number" class="form-control" name="quantity" value={{ $product->quantity }} />
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection