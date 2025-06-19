@extends('backend.user.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-item">
            <div class="card-header">
                <h3 class="card-title fs-22">Pesan Saya</h3>
                <div class="card-header-menu">
                    <span class="badge badge-primary">{{ $messages->total() }} Pesan</span>
                </div>
            </div><!-- end card-header -->
            <div class="card-body">
                @if($messages->count() > 0)
                    <div class="message-list">
                        @foreach($messages as $message)
                            <div class="message-item {{ !$message->is_read ? 'unread' : '' }} mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="message-header">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="message-type-badge">
                                                @switch($message->type)                                                    @case('system')
                                                        <span class="badge badge-info">Sistem</span>
                                                        @break
                                                    @case('course')
                                                        <span class="badge badge-success">Kursus</span>
                                                        @break
                                                    @case('payment')
                                                        <span class="badge badge-warning">Pembayaran</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">Umum</span>
                                                @endswitch
                                            </div>                                            @if(!$message->is_read)
                                                <span class="badge badge-danger ml-2">Baru</span>
                                            @endif
                                        </div>
                                        <h5 class="message-subject mb-1">{{ $message->subject }}</h5>
                                        <div class="message-meta text-muted">
                                            <small>
                                                From: {{ $message->fromUser ? $message->fromUser->name : 'System' }}
                                                | {{ $message->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="message-actions">
                                        @if(!$message->is_read)
                                            <i class="la la-circle text-primary" title="Unread"></i>
                                        @else
                                            <i class="la la-check-circle text-success" title="Read"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="message-content mt-3">
                                    <p class="mb-0">{{ $message->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($messages->hasPages())
                        <div class="text-center py-3">
                            <nav aria-label="Page navigation example" class="pagination-box">
                                {{ $messages->links() }}
                            </nav>
                        </div>
                    @endif

                @else
                    <div class="text-center py-5">
                        <div class="not-found-content">
                            <div class="icon-element mx-auto shadow-sm" data-toggle="tooltip" data-placement="top" title="No Messages">
                                <i class="la la-envelope-o"></i>
                            </div>
                            <h4 class="mt-4 fw-500 text-gray">No Messages Found</h4>
                            <p class="mt-2 text-gray">Anda belum memiliki pesan apapun. Pesan dari instruktur dan notifikasi sistem akan muncul di sini.</p>
                        </div>
                    </div>
                @endif
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col-lg-12 -->
</div><!-- end row -->

@endsection

@push('scripts')
    <style>
        .message-item.unread {
            background-color: #f8f9ff;
            border-left: 4px solid #007bff;
        }
        .message-item {
            transition: all 0.3s ease;
        }
        .message-item:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
@endpush
