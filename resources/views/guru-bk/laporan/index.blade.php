@extends('layouts.guru')

@section('title', 'Laporan PDF')
@section('page-title', 'Laporan PDF')

@section('content')
<style>
    .laporan-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        cursor: pointer;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(2,16,36,0.07);
        transition: all 0.2s ease;
        position: relative;
    }
    .laporan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(2,16,36,0.13);
        border-color: #cbd5e1;
    }
    .laporan-card.featured {
        border: 2px solid #052659;
        box-shadow: 0 4px 20px rgba(5,38,89,0.15);
    }
    .laporan-card .badge-top {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #052659;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 16px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .laporan-card .icon-box {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .laporan-card h3 {
        font-size: 1rem; font-weight: 700;
        color: #021024; margin: 0 0 6px;
    }
    .laporan-card p {
        font-size: 0.8rem; color: #64748b;
        margin: 0 0 14px; line-height: 1.5;
    }
    .tag-wrap { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 18px; }
    .tag {
        font-size: 0.69rem; font-weight: 600;
        padding: 3px 11px; border-radius: 20px;
    }
    .btn-generate {
        width: 100%; padding: 10px;
        background: #052659; color: #fff;
        border: none; border-radius: 9px;
        font-size: 0.82rem; font-weight: 600;
        cursor: pointer; letter-spacing: 0.02em;
        transition: background 0.2s;
    }
    .btn-generate:hover { background: #021024; }
    input[type="date"] { color-scheme: dark; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%23cbd5e1' stroke-width='1.8' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: 16px;
        width: 16px; height: 16px;
        cursor: pointer; opacity: 1;
    }
</style>

<div style="padding: 28px;">

    {{-- HEADER --}}
    <div style="margin-bottom: 28px;">
        <h1 style="font-size:1.45rem;font-weight:800;color:#021024;margin:0 0 4px;">Laporan PDF</h1>
        <p style="color:#64748b;font-size:0.85rem;margin:0;">Generate laporan BK dalam format PDF siap cetak</p>
    </div>

    {{-- GRID --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;">

        {{-- KONSELING --}}
        <div class="laporan-card" onclick="bukaModal('konseling')">
            <div class="icon-box" style="background:#eff6ff;">
                <svg style="width:22px;height:22px;color:#3b82f6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3>Laporan Konseling</h3>
            <p>Rekap sesi konseling per periode & kategori</p>
            <div class="tag-wrap">
                <span class="tag" style="background:#eff6ff;color:#3b82f6;">Filter periode</span>
                <span class="tag" style="background:#eff6ff;color:#3b82f6;">Filter kelas</span>
            </div>
            <button class="btn-generate" onclick="event.stopPropagation();bukaModal('konseling')">Generate PDF / Excel ↗</button>
        </div>

        {{-- PELANGGARAN --}}
        <div class="laporan-card" onclick="bukaModal('pelanggaran')">
            <div class="icon-box" style="background:#fff7ed;">
                <svg style="width:22px;height:22px;color:#f97316;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                </svg>
            </div>
            <h3>Laporan Pelanggaran</h3>
            <p>Rekap pelanggaran & akumulasi poin siswa</p>
            <div class="tag-wrap">
                <span class="tag" style="background:#fff7ed;color:#f97316;">Filter periode</span>
                <span class="tag" style="background:#fff7ed;color:#f97316;">Filter kelas</span>
            </div>
            <button class="btn-generate" onclick="event.stopPropagation();bukaModal('pelanggaran')">Generate PDF ↗</button>
        </div>

        {{-- PRESTASI --}}
        <div class="laporan-card" onclick="bukaModal('prestasi')">
            <div class="icon-box" style="background:#f0fdf4;">
                <svg style="width:22px;height:22px;color:#22c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"/>
                </svg>
            </div>
            <h3>Laporan Prestasi</h3>
            <p>Rekap prestasi siswa per periode & tingkat</p>
            <div class="tag-wrap">
                <span class="tag" style="background:#f0fdf4;color:#22c55e;">Filter periode</span>
                <span class="tag" style="background:#f0fdf4;color:#22c55e;">Filter kelas</span>
            </div>
            <button class="btn-generate" onclick="event.stopPropagation();bukaModal('prestasi')">Generate PDF ↗</button>
        </div>

        {{-- HOME VISIT --}}
        <div class="laporan-card" onclick="bukaModal('home-visit')">
            <div class="icon-box" style="background:#fefce8;">
                <svg style="width:22px;height:22px;color:#eab308;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <h3>Laporan Home Visit</h3>
            <p>Rekap kunjungan rumah siswa per periode</p>
            <div class="tag-wrap">
                <span class="tag" style="background:#fefce8;color:#eab308;">Filter periode</span>
                <span class="tag" style="background:#fefce8;color:#eab308;">Filter kelas</span>
            </div>
            <button class="btn-generate" onclick="event.stopPropagation();bukaModal('home-visit')">Generate PDF ↗</button>
        </div>

        {{-- REKAP UMUM --}}
        <div class="laporan-card featured" onclick="bukaModal('rekap-umum')">
            <span class="badge-top">⭐ Rekap Lengkap</span>
            <div class="icon-box" style="background:#f0fdfa;margin-top:8px;">
                <svg style="width:22px;height:22px;color:#14b8a6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
            </div>
            <h3>Laporan Rekap Umum</h3>
            <p>Gabungan semua data: konseling, pelanggaran, prestasi & home visit</p>
            <div class="tag-wrap">
                <span class="tag" style="background:#f0fdfa;color:#14b8a6;">Filter periode</span>
                <span class="tag" style="background:#f0fdfa;color:#14b8a6;">Filter kelas</span>
            </div>
            <button class="btn-generate" onclick="event.stopPropagation();bukaModal('rekap-umum')">Generate PDF ↗</button>
        </div>

    </div>{{-- END GRID --}}
</div>

{{-- MODAL OVERLAY --}}
<div id="modal-overlay" onclick="tutupModal()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:1000;backdrop-filter:blur(2px);"></div>

{{-- MODAL FILTER --}}
<div id="modal-filter"
     style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
            background:#1e293b;border-radius:18px;padding:28px;width:460px;max-width:95vw;
            z-index:1001;box-shadow:0 24px 64px rgba(0,0,0,0.45);">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div id="modal-icon" style="width:38px;height:38px;border-radius:9px;background:#334155;
                                        display:flex;align-items:center;justify-content:center;"></div>
            <h3 id="modal-title" style="font-size:1rem;font-weight:700;color:#f1f5f9;margin:0;"></h3>
        </div>
        <button onclick="tutupModal()"
            style="background:rgba(255,255,255,0.08);border:none;cursor:pointer;color:#94a3b8;
                   width:30px;height:30px;border-radius:7px;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
    </div>

    <form id="form-laporan" method="POST" target="_blank">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label style="display:block;font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" id="dari_tanggal" required
                    style="width:100%;padding:9px 12px;background:#0f172a;border:1.5px solid #334155;
                           border-radius:8px;color:#f1f5f9;font-size:0.82rem;box-sizing:border-box;outline:none;"
                    onfocus="this.style.borderColor='#64748b'" onblur="this.style.borderColor='#334155'">
            </div>
            <div>
                <label style="display:block;font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" id="sampai_tanggal" required
                    style="width:100%;padding:9px 12px;background:#0f172a;border:1.5px solid #334155;
                           border-radius:8px;color:#f1f5f9;font-size:0.82rem;box-sizing:border-box;outline:none;"
                    onfocus="this.style.borderColor='#64748b'" onblur="this.style.borderColor='#334155'">
            </div>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-size:0.7rem;font-weight:700;color:#94a3b8;
                           text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">Kelas Binaan</label>
            <select name="kelas_id"
                style="width:100%;padding:9px 12px;background:#0f172a;border:1.5px solid #334155;
                       border-radius:8px;color:#f1f5f9;font-size:0.82rem;outline:none;cursor:pointer;"
                onfocus="this.style.borderColor='#64748b'" onblur="this.style.borderColor='#334155'">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:0.7rem;font-weight:700;color:#94a3b8;
                           text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Shortcut Periode:</label>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="button" onclick="setBulanIni()"
                    style="padding:5px 14px;border:1.5px solid #475569;border-radius:20px;
                           background:rgba(255,255,255,0.05);color:#cbd5e1;font-size:0.75rem;cursor:pointer;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.05)'">Bulan ini</button>
                <button type="button" onclick="setBulanLalu()"
                    style="padding:5px 14px;border:1.5px solid #475569;border-radius:20px;
                           background:rgba(255,255,255,0.05);color:#cbd5e1;font-size:0.75rem;cursor:pointer;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.05)'">Bulan lalu</button>
                <button type="button" onclick="setSemesterIni()"
                    style="padding:5px 14px;border:1.5px solid #475569;border-radius:20px;
                           background:rgba(255,255,255,0.05);color:#cbd5e1;font-size:0.75rem;cursor:pointer;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.05)'">Semester ini</button>
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="button" onclick="tutupModal()"
                style="flex:1;padding:10px;background:#334155;color:#94a3b8;border:none;
                       border-radius:9px;font-size:0.82rem;font-weight:600;cursor:pointer;">Batal</button>
            <button type="button" onclick="downloadPDF()"
                style="flex:2;padding:10px;background:linear-gradient(135deg,#052659,#5483B3);color:#fff;border:none;
                       border-radius:9px;font-size:0.82rem;font-weight:700;cursor:pointer;letter-spacing:0.02em;">
                ⬇ PDF
            </button>
            <button type="button" onclick="downloadExcel()"
                style="flex:2;padding:10px;background:linear-gradient(135deg,#166534,#16a34a);color:#fff;border:none;
                       border-radius:9px;font-size:0.82rem;font-weight:700;cursor:pointer;letter-spacing:0.02em;">
                ⬇ Excel
            </button>
        </div>
    </form>
</div>

<script>
const config = {
    'konseling'   : { title:'Laporan Konseling',   action:'{{ route("guru-bk.laporan.konseling") }}',   actionExcel:'{{ route("guru-bk.laporan.excel.konseling") }}',   icon:`<svg style="width:18px;height:18px;color:#3b82f6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>` },
    'pelanggaran' : { title:'Laporan Pelanggaran', action:'{{ route("guru-bk.laporan.pelanggaran") }}', actionExcel:'{{ route("guru-bk.laporan.excel.pelanggaran") }}', icon:`<svg style="width:18px;height:18px;color:#f97316;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>` },
    'prestasi'    : { title:'Laporan Prestasi',    action:'{{ route("guru-bk.laporan.prestasi") }}',    actionExcel:'{{ route("guru-bk.laporan.excel.prestasi") }}',    icon:`<svg style="width:18px;height:18px;color:#22c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872"/></svg>` },
    'home-visit'  : { title:'Laporan Home Visit',  action:'{{ route("guru-bk.laporan.home-visit") }}',  actionExcel:'{{ route("guru-bk.laporan.excel.home-visit") }}',  icon:`<svg style="width:18px;height:18px;color:#eab308;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>` },
    'rekap-umum'  : { title:'Laporan Rekap Umum',  action:'{{ route("guru-bk.laporan.rekap-umum") }}',  actionExcel:'{{ route("guru-bk.laporan.excel.rekap-umum") }}',  icon:`<svg style="width:18px;height:18px;color:#14b8a6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>` },
};

let currentConfig = null;

function bukaModal(jenis) {
    currentConfig = config[jenis];
    document.getElementById('modal-title').textContent = currentConfig.title;
    document.getElementById('modal-icon').innerHTML = currentConfig.icon;
    document.getElementById('form-laporan').action = currentConfig.action;
    document.getElementById('modal-overlay').style.display = 'block';
    document.getElementById('modal-filter').style.display = 'block';
    setBulanIni();
}

function downloadPDF() {
    document.getElementById('form-laporan').action = currentConfig.action;
    document.getElementById('form-laporan').submit();
}

function downloadExcel() {
    document.getElementById('form-laporan').action = currentConfig.actionExcel;
    document.getElementById('form-laporan').submit();
}
function tutupModal() {
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('modal-filter').style.display = 'none';
}
function setBulanIni() {
    const now = new Date();
    const y = now.getFullYear(), m = String(now.getMonth()+1).padStart(2,'0');
    document.getElementById('dari_tanggal').value = `${y}-${m}-01`;
    document.getElementById('sampai_tanggal').value = `${y}-${m}-${new Date(y,now.getMonth()+1,0).getDate()}`;
}
function setBulanLalu() {
    const d = new Date(); d.setMonth(d.getMonth()-1);
    const y = d.getFullYear(), m = String(d.getMonth()+1).padStart(2,'0');
    document.getElementById('dari_tanggal').value = `${y}-${m}-01`;
    document.getElementById('sampai_tanggal').value = `${y}-${m}-${new Date(y,d.getMonth()+1,0).getDate()}`;
}
function setSemesterIni() {
    const now = new Date(), y = now.getFullYear(), mo = now.getMonth()+1;
    document.getElementById('dari_tanggal').value = mo >= 7 ? `${y}-07-01` : `${y}-01-01`;
    document.getElementById('sampai_tanggal').value = mo >= 7 ? `${y}-12-31` : `${y}-06-30`;
}
</script>
@endsection