@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>SubCategory</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update SubCategory</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Parent Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" @selected($subcategory->category_id == $id)>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}">
                </div>

                <div class="form-group">
                    <label>Show at Home</label>
                    <select name="show_at_home" class="form-control">
                        <option value="1" @selected($subcategory->show_at_home == 1)>Yes</option>
                        <option value="0" @selected($subcategory->show_at_home == 0)>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" @selected($subcategory->status == 1)>Active</option>
                        <option value="0" @selected($subcategory->status == 0)>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection
