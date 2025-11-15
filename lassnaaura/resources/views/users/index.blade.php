@extends('layouts.app')

@section('title', 'User Management - Business Management System')
@section('page-title', 'Users')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-users-cog"></i>
                    User Management
                </h2>
                <p class="page-header-subtitle">Manage system users and permissions</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    <i class="fas fa-plus"></i>
                    Add New User
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-shield-alt"></i>
                    Manage Roles
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalUsers ?? 0 }}</h3>
                <p class="stat-card-label">Total Users</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $activeUsers ?? 0 }}</h3>
                <p class="stat-card-label">Active Users</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $adminUsers ?? 0 }}</h3>
                <p class="stat-card-label">Administrators</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $onlineUsers ?? 0 }}</h3>
                <p class="stat-card-label">Online Now</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="userSearch" placeholder="Search users by name or email...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="roleFilter">
                <option value="">All Roles</option>
                @foreach($roles ?? [] as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                System Users
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $user)
                        <tr>
                            <td><input type="checkbox" class="user-checkbox" value="{{ $user->id }}"></td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->is_online)
                                        <span class="badge badge-success badge-sm">
                                            <i class="fas fa-circle"></i> Online
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><i class="fas fa-envelope text-muted"></i> {{ $user->email }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $user->role->name ?? 'User' }}
                                </span>
                            </td>
                            <td>{{ $user->department ?? '-' }}</td>
                            <td>
                                @if($user->last_login_at)
                                <span class="text-muted">{{ $user->last_login_at->diffForHumans() }}</span>
                                @else
                                <span class="text-muted">Never</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" onclick="viewUser({{ $user->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary" onclick="managePermissions({{ $user->id }})">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h4>No Users Found</h4>
                                    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addUserModal">
                                        <i class="fas fa-plus"></i>
                                        Add First User
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Roles & Permissions -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shield-alt"></i>
                Roles & Permissions
            </h3>
        </div>
        <div class="card-body">
            <div class="roles-grid">
                @forelse($roles ?? [] as $role)
                <div class="role-card">
                    <div class="role-header">
                        <h4>{{ $role->name }}</h4>
                        <span class="badge badge-primary">{{ $role->users_count ?? 0 }} users</span>
                    </div>
                    <p class="role-description">{{ $role->description }}</p>
                    <div class="role-permissions">
                        <small class="text-muted">Permissions:</small>
                        <div class="permissions-list">
                            @foreach($role->permissions ?? [] as $permission)
                            <span class="permission-badge">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="role-actions">
                        <button class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteRole({{ $role->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @empty
                <p class="text-muted">No roles defined</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        overflow: hidden;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .badge-sm {
        font-size: 0.688rem;
        padding: 0.125rem 0.375rem;
    }
    
    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .role-card {
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
    }
    
    .role-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .role-header h4 {
        margin: 0;
        font-size: 1.125rem;
    }
    
    .role-description {
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .role-permissions {
        margin-bottom: 1rem;
    }
    
    .permissions-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .permission-badge {
        padding: 0.25rem 0.5rem;
        background: white;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        color: #667eea;
        border: 1px solid #667eea;
    }
    
    .role-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function viewUser(id) {
        window.location.href = `/users/${id}`;
    }
    
    function editUser(id) {
        window.location.href = `/users/${id}/edit`;
    }
    
    function managePermissions(id) {
        window.location.href = `/users/${id}/permissions`;
    }
    
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function deleteRole(id) {
        if (confirm('Are you sure you want to delete this role? Users with this role will be reassigned.')) {
            // Handle role deletion
        }
    }
    
    function resetFilters() {
        document.getElementById('userSearch').value = '';
        document.getElementById('roleFilter').value = '';
        document.getElementById('statusFilter').value = '';
    }
</script>
@endpush
@endsection
