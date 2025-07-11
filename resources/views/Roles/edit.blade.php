{{-- filepath: d:\LVTN\phone_store\resources\views\Roles\edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <h4>Sửa quyền tài khoản</h4>
            <form action="{{ route('roles.update', ['id' => $user->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role_id">Quyền</label>
                    <select name="role_id" id="role_id" class="form-control">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection