@extends('layouts.app')

@section('title', 'Notifikasi - Masjid Nurul Huda')

@push('styles')
<style>
    .notif-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; border-left: 5px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.3s; text-decoration: none; color: inherit; display: block; }
    .notif-card:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); color: inherit; }
    .notif-card.unread { background-color: #f0f7ff; border-left-color: #2563eb; }
    .notif-card.read { background-color: #ffffff; opacity: 0.85; }
    .status-Menunggu { border-left-color: #ffc107; }
    .status-Disetujui { border-left-color: #198754; }
    .status-Ditolak { border-left-color: #dc3545; }
    .notif-title { font-weight: 700; font-size: 1.05rem; color: #333; margin-bottom: 5px; }
    .notif-time { font-size: 0.8rem; color: #888; margin-bottom: 8px; display: block; }
    .notif-msg { font-size: 0.9rem; color: #555; line-height: 1.6; }
    .notif-badge { font-size: 0.65rem; padding: 0.375rem 0.75rem; }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Notifikasi</h2>
            <p class="text-muted mb-0">Pemberitahuan terbaru untuk Anda</p>
        </div>
        @if(!empty($notifikasi))
            <button type="button" class="btn btn-sm btn-outline-primary" id="markAllReadBtn">
                <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
            </button>
        @endif
    </div>

    @if(!empty($notifikasi))
        <div id="notif-container">
        @foreach($notifikasi as $n)
        @php
            $statusBadge = $n['status_badge'] ?? 'Menunggu';
            $link = $n['link'] ?? '#';
            $isUnread = !empty($n['is_new']);
            
            // Validasi link lebih ketat
            if (!$link || $link === '#') {
                $link = '#';
            } elseif (!str_starts_with($link, 'http') && !str_starts_with($link, '/')) {
                // Jika bukan URL absolut atau path relatif, tambahkan /
                $link = '/' . $link;
            }
        @endphp
        <div class="notif-card status-{{ $statusBadge }} {{ $isUnread ? 'unread' : 'read' }}" 
             data-notif-id="{{ $n['id'] ?? '' }}" 
             data-is-unread="{{ $isUnread ? '1' : '0' }}">
            <a href="{{ $link }}" class="notif-link d-block" style="text-decoration: none; color: inherit;">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <h5 class="notif-title mb-0">{{ $n['judul'] ?? 'Notifikasi' }}</h5>
                    @if($isUnread)
                    <span class="badge bg-danger rounded-pill notif-badge">BARU</span>
                    @endif
                </div>
                <span class="notif-time">
                    <i class="bi bi-clock me-1"></i>
                    @if(!empty($n['waktu']))
                        {{ $n['waktu'] }}
                    @else
                        {{ $n['created_at'] ?? 'Baru saja' }}
                    @endif
                </span>
                <div class="notif-msg">{!! $n['pesan'] ?? '' !!}</div>
            </a>
        </div>
        @endforeach
        </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-bell-slash display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada notifikasi baru.</p>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark All As Read
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            if (!confirm('Tandai semua notifikasi telah dibaca?')) return;

            fetch('{{ route("notifikasi.mark-all-as-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update semua card notifikasi
                    document.querySelectorAll('.notif-card.unread').forEach(card => {
                        card.classList.remove('unread');
                        card.classList.add('read');
                        card.querySelector('.notif-badge')?.remove();
                        card.setAttribute('data-is-unread', '0');
                    });

                    // Update navbar badge
                    updateNavbarBadge(0);
                    
                    // Show success message
                    showAlert('Semua notifikasi telah ditandai dibaca', 'success');
                    
                    // Hide button
                    markAllReadBtn.style.display = 'none';
                } else {
                    showAlert(data.message || 'Gagal menandai notifikasi', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan', 'error');
            });
        });
    }

    // Mark Single As Read
    document.querySelectorAll('.notif-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.notif-link')) {
                const notifId = this.getAttribute('data-notif-id');
                const isUnread = this.getAttribute('data-is-unread') === '1';

                if (notifId && isUnread) {
                    e.preventDefault();
                    const link = this.querySelector('.notif-link').href;

                    fetch(`{{ route('notifikasi.mark-as-read', ':id') }}`.replace(':id', notifId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Update card styling
                            card.classList.remove('unread');
                            card.classList.add('read');
                            card.querySelector('.notif-badge')?.remove();
                            card.setAttribute('data-is-unread', '0');

                            // Update navbar badge
                            updateNavbarBadge(data.unreadCount);

                            // Redirect ke link asli
                            if (link && link !== '#') {
                                setTimeout(() => {
                                    window.location.href = link;
                                }, 100);
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
    });
});

function updateNavbarBadge(count) {
    const badge = document.getElementById('notif-count');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show alert-flash`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}
</script>
@endsection
