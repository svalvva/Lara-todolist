
@extends('layouts.task')

@section('content')
    <div class="row">
        <div class="col-12">
        
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-purple">Dashboard</h2>
            </div>
            <p>Selamat datang, {{ Auth::user()->username }}!</p>
        </div>
        <div class="row mt-2">
            
            <div class="col-md-4">
                <div class="card bg-purple-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-purple">Total Tugas</h5>
                        <p class="card-text">
                            Anda memiliki {{ $tasksCount ?? 0 }} tugas.
                        </p>
                        <a href="{{ route('tasks.index') }}" class="btn btn-purple">
                            Lihat Tugas
                        </a>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
@endsection


