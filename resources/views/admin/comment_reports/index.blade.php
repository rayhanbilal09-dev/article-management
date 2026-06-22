@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Moderasi Komentar & Laporan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Tinjau komentar yang dilaporkan oleh pembaca dan lakukan tindakan moderasi.</p>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-900 text-sm">Semua Laporan Masuk</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 w-16">#</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Detail Komentar & Laporan</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Penulis & Pelapor</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reports as $index => $report)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-xs font-medium text-slate-400">
                                #{{ $report->id }}
                            </td>
                            
                            <!-- Comment & Report details -->
                            <td class="px-5 py-4 space-y-2 max-w-md">
                                <div>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 border border-amber-200 text-amber-800">
                                        Alasan: {{ $report->reason }}
                                    </span>
                                </div>
                                
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-xs text-slate-700 font-medium whitespace-pre-line leading-relaxed shadow-inner">
                                    @if($report->comment)
                                        "{{ $report->comment->body }}"
                                    @else
                                        <span class="text-slate-400 italic">(Komentar telah dihapus)</span>
                                    @endif
                                </div>
                                
                                @if($report->comment && $report->comment->article)
                                    <div class="text-[11px] font-semibold">
                                        Artikel: 
                                        <a href="{{ route('public.articles.show', $report->comment->article->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 underline">
                                            {{ $report->comment->article->title }}
                                        </a>
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Author & Reporter Info -->
                            <td class="px-5 py-4 text-xs space-y-1.5">
                                <div>
                                    <span class="text-slate-400 font-bold block">Penulis Komentar:</span>
                                    @if($report->comment && $report->comment->user)
                                        <span class="font-bold text-slate-900">{{ $report->comment->user->name }}</span>
                                        @if($report->comment->user->is_blocked)
                                            <span class="ml-1 text-[10px] font-extrabold text-rose-600 uppercase border border-rose-200 px-1 py-0.5 rounded bg-rose-50">Blocked</span>
                                        @endif
                                        <span class="text-slate-500 block">{{ $report->comment->user->email }}</span>
                                    @else
                                        <span class="text-slate-400 italic">N/A</span>
                                    @endif
                                </div>
                                <hr class="border-slate-100 my-1">
                                <div>
                                    <span class="text-slate-400 font-bold block">Pelapor:</span>
                                    <span class="font-bold text-slate-900">{{ $report->user->name ?? 'Anonymous' }}</span>
                                    <span class="text-slate-500 block">{{ $report->user->email ?? '' }}</span>
                                </div>
                            </td>
                            
                            <!-- Status -->
                            <td class="px-5 py-4 text-xs">
                                @if($report->status === 'pending')
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-extrabold uppercase bg-amber-100 text-amber-800 rounded-full">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-extrabold uppercase bg-emerald-100 text-emerald-800 rounded-full">
                                        Selesai
                                    </span>
                                @endif
                                <span class="block text-[10px] text-slate-400 mt-1 font-semibold">{{ $report->created_at->diffForHumans() }}</span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-5 py-4 text-right">
                                @if($report->status === 'pending')
                                    <div class="flex flex-col sm:flex-row justify-end items-stretch gap-1.5">
                                        <!-- Mark Resolved -->
                                        <form method="POST" action="{{ route('reports.resolve', $report) }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left sm:text-center text-xs font-bold bg-indigo-50 border border-indigo-150 text-indigo-700 hover:bg-indigo-100 px-3 py-2 rounded-xl transition-all duration-150">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                        
                                        <!-- Delete Comment -->
                                        @if($report->comment)
                                            <form method="POST" action="{{ route('reports.comments.destroy', $report->comment) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left sm:text-center text-xs font-bold bg-rose-50 border border-rose-150 text-rose-700 hover:bg-rose-100 px-3 py-2 rounded-xl transition-all duration-150">
                                                    Hapus Komentar
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Block User -->
                                        @if($report->comment && $report->comment->user && !$report->comment->user->is_blocked && !$report->comment->user->isSuperAdmin())
                                            <form method="POST" action="{{ route('reports.users.block', $report->comment->user) }}" onsubmit="return confirm('Blokir user {{ $report->comment->user->name }} dari sistem?')">
                                                @csrf
                                                <button type="submit" class="w-full text-left sm:text-center text-xs font-bold bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 px-3 py-2 rounded-xl transition-all duration-150">
                                                    Blokir User
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 font-semibold italic">Telah Ditangani</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-bold text-sm">Tidak Ada Laporan</p>
                                <p class="text-xs text-slate-400 mt-1">Semua komentar aman dan tidak ada laporan tertunda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
