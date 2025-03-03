@extends('layouts.task')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header with Add Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-purple">Daftar Tugas</h2>
                <button type="button" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="fas fa-plus me-2"></i> Tambah Tugas
                </button>
            </div>

            <!-- Task List -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th >Deskripsi</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td class="fw-medium">{{ $task->judul }}</td>
                                    <td>{{ $task->deskripsi }}</td>
                                    <td>{{ date('d M Y', strtotime($task->deadline)) }}</td>
                                    <td>
                                        <span class="status-badge {{ $task->status == 'selesai' ? 'status-selesai' : 'status-tertunda' }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button 
                                            class="btn btn-sm text-purple edit-task-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editTaskModal" 
                                            data-task-id="{{ $task->id }}"
                                            data-task-judul="{{ $task->judul }}"
                                            data-task-deskripsi="{{ $task->deskripsi }}"
                                            data-task-deadline="{{ $task->deadline }}"
                                            data-task-status="{{ $task->status }}"
                                        >
                                            <i class="fas fa-edit fa-lg"></i>
                                        </button>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                        <p class="mb-0">Tidak ada task ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-purple-light">
                    <h5 class="modal-title text-purple fs-4" id="addTaskModalLabel">Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="col-md-4">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="tertunda">Tertunda</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-plus me-1"></i> Tambah Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-purple-light">
                    <h5 class="modal-title text-purple fs-4" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mb-3">
                            
                            <div class="col-md-8">
                                <label for="edit_judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="edit_judul" name="judul" required>
                            </div>
                            <div class="col-md-4">
                                <label for="edit_deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="edit_deadline" name="deadline" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="tertunda">Tertunda</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-save me-1"></i> Update Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit task modal
        const editTaskModal = document.getElementById('editTaskModal');
        if (editTaskModal) {
            editTaskModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const taskId = button.getAttribute('data-task-id');
                const taskJudul = button.getAttribute('data-task-judul');
                const taskDeskripsi = button.getAttribute('data-task-deskripsi');
                const taskDeadline = button.getAttribute('data-task-deadline');
                const taskStatus = button.getAttribute('data-task-status');
                
                const form = document.getElementById('editTaskForm');
                form.action = `/tasks/${taskId}`;
                
                document.getElementById('edit_judul').value = taskJudul;
                document.getElementById('edit_deskripsi').value = taskDeskripsi;
                document.getElementById('edit_deadline').value = taskDeadline;
                document.getElementById('edit_status').value = taskStatus;
            });
        }
    });
</script>
@endpush