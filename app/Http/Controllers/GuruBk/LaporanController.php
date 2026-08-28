<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\HomeVisit;
use App\Models\Kelas;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    private function getSetting(): array
    {
        $raw = \App\Models\Setting::pluck('value', 'key')->toArray();
        return [
            'nama_sekolah'   => $raw['nama_sekolah']   ?? 'SMK Antartika 2 Sidoarjo',
            'alamat_sekolah' => $raw['alamat_sekolah']  ?? '',
            'telp_sekolah'   => $raw['telp_sekolah']    ?? '',
            'logo_sekolah'   => $raw['logo_sekolah']    ?? '',
            'kop_surat'      => $raw['kop_surat']       ?? '',
            'nama_kota'      => 'Sidoarjo',
        ];
    }

    private function kelasIds()
    {
        return Kelas::where('guru_id', Auth::id())->pluck('id')->toArray();
    }

    public function index()
    {
        $kelasList = Kelas::where('guru_id', Auth::id())->orderBy('nama')->get();
        return view('guru-bk.laporan.index', compact('kelasList'));
    }

    public function konseling(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);

        $gurubkId    = Auth::id();
        $dari        = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai      = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting     = $this->getSetting();

        $query = Konseling::with(['siswa.kelas'])
            ->where('guru_bk_id', $gurubkId)
            ->whereBetween('created_at', [$dari, $sampai])
            ->orderBy('created_at');

        if ($kelasFilter) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        }

        $konselings  = $query->get();
        $kelas       = $kelasFilter ? Kelas::find($kelasFilter) : null;
        $gurubk      = Auth::user();
        $namaSekolah = $setting['nama_sekolah'];

        $pdf = Pdf::loadView('guru-bk.laporan.pdf.konseling', compact(
            'konselings', 'dari', 'sampai', 'kelas', 'gurubk', 'namaSekolah', 'setting'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Konseling_' . $dari->format('dmY') . '_' . $sampai->format('dmY') . '.pdf');
    }

    public function pelanggaran(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);

        $gurubkId    = Auth::id();
        $dari        = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai      = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting     = $this->getSetting();

        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('dicatat_oleh', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');

        if ($kelasFilter) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        }

        $pelanggarans = $query->get();
        $kelas        = $kelasFilter ? Kelas::find($kelasFilter) : null;
        $gurubk       = Auth::user();
        $namaSekolah  = $setting['nama_sekolah'];

        $pdf = Pdf::loadView('guru-bk.laporan.pdf.pelanggaran', compact(
            'pelanggarans', 'dari', 'sampai', 'kelas', 'gurubk', 'namaSekolah', 'setting'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Pelanggaran_' . $dari->format('dmY') . '_' . $sampai->format('dmY') . '.pdf');
    }

    public function prestasi(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);

        $gurubkId    = Auth::id();
        $dari        = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai      = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting     = $this->getSetting();

        $query = Prestasi::with(['siswa.kelas'])
            ->where('dicatat_oleh', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');

        if ($kelasFilter) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        }

        $prestasis   = $query->get();
        $kelas       = $kelasFilter ? Kelas::find($kelasFilter) : null;
        $gurubk      = Auth::user();
        $namaSekolah = $setting['nama_sekolah'];

        $pdf = Pdf::loadView('guru-bk.laporan.pdf.prestasi', compact(
            'prestasis', 'dari', 'sampai', 'kelas', 'gurubk', 'namaSekolah', 'setting'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Prestasi_' . $dari->format('dmY') . '_' . $sampai->format('dmY') . '.pdf');
    }

    public function homeVisit(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);

        $gurubkId    = Auth::id();
        $dari        = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai      = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting     = $this->getSetting();

        $query = HomeVisit::with(['siswa.kelas'])
            ->where('guru_bk_id', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');

        if ($kelasFilter) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        }

        $homeVisits  = $query->get();
        $kelas       = $kelasFilter ? Kelas::find($kelasFilter) : null;
        $gurubk      = Auth::user();
        $namaSekolah = $setting['nama_sekolah'];

        $pdf = Pdf::loadView('guru-bk.laporan.pdf.home-visit', compact(
            'homeVisits', 'dari', 'sampai', 'kelas', 'gurubk', 'namaSekolah', 'setting'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_HomeVisit_' . $dari->format('dmY') . '_' . $sampai->format('dmY') . '.pdf');
    }

    public function rekapUmum(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);

        $gurubkId    = Auth::id();
        $dari        = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai      = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting     = $this->getSetting();

        $qKonseling = Konseling::with(['siswa.kelas'])
            ->where('guru_bk_id', $gurubkId)
            ->whereBetween('created_at', [$dari, $sampai]);
        if ($kelasFilter) $qKonseling->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $konselings = $qKonseling->get();

        $qPelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('dicatat_oleh', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai]);
        if ($kelasFilter) $qPelanggaran->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $pelanggarans = $qPelanggaran->get();

        $qPrestasi = Prestasi::with(['siswa.kelas'])
            ->where('dicatat_oleh', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai]);
        if ($kelasFilter) $qPrestasi->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $prestasis = $qPrestasi->get();

        $qHomeVisit = HomeVisit::with(['siswa.kelas'])
            ->where('guru_bk_id', $gurubkId)
            ->whereBetween('tanggal', [$dari, $sampai]);
        if ($kelasFilter) $qHomeVisit->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $homeVisits = $qHomeVisit->get();

        $kelas       = $kelasFilter ? Kelas::find($kelasFilter) : null;
        $gurubk      = Auth::user();
        $namaSekolah = $setting['nama_sekolah'];

        $pdf = Pdf::loadView('guru-bk.laporan.pdf.rekap-umum', compact(
            'konselings', 'pelanggarans', 'prestasis', 'homeVisits',
            'dari', 'sampai', 'kelas', 'gurubk', 'namaSekolah', 'setting'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Rekap_' . $dari->format('dmY') . '_' . $sampai->format('dmY') . '.pdf');
    }

    // ==================== EXCEL ====================

    private function excelHeader(Spreadsheet $spreadsheet, string $judul, array $setting, $dari, $sampai, $kelas, $gurubk): int
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', strtoupper($setting['nama_sekolah']));
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', strtoupper($judul));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Periode: ' . $dari->format('d/m/Y') . ' s/d ' . $sampai->format('d/m/Y'));
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 10],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->mergeCells('A4:H4');
        $kelasLabel = $kelas ? $kelas->nama_kelas : 'Semua Kelas';
        $sheet->setCellValue('A4', 'Kelas: ' . $kelasLabel . '   |   Guru BK: ' . $gurubk->name);
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['size' => 10, 'italic' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->mergeCells('A5:H5');
        return 6;
    }

    private function styleHeaderRow(Spreadsheet $spreadsheet, string $range): void
    {
        $spreadsheet->getActiveSheet()->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);
        $spreadsheet->getActiveSheet()->getRowDimension(6)->setRowHeight(22);
    }

    private function styleDataRows(Spreadsheet $spreadsheet, string $range): void
    {
        $spreadsheet->getActiveSheet()->getStyle($range)->applyFromArray([
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D1D5DB']]],
        ]);
    }

    private function downloadExcel(Spreadsheet $spreadsheet, string $filename): StreamedResponse
    {
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function excelKonseling(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);
        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting = $this->getSetting();
        $gurubk = Auth::user();
        $kelas = $kelasFilter ? Kelas::find($kelasFilter) : null;

        $query = Konseling::with(['siswa.kelas'])
            ->where('guru_bk_id', Auth::id())
            ->whereBetween('created_at', [$dari, $sampai])
            ->orderBy('created_at');
        if ($kelasFilter) $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = $this->excelHeader($spreadsheet, 'Laporan Sesi Konseling', $setting, $dari, $sampai, $kelas, $gurubk);

        $headers = ['No', 'Tanggal', 'Nama Siswa', 'Kelas', 'Kategori', 'Deskripsi Masalah', 'Status'];
        foreach ($headers as $i => $h) $sheet->setCellValueByColumnAndRow($i + 1, $row, $h);
        $this->styleHeaderRow($spreadsheet, 'A' . $row . ':G' . $row);

        $no = 1;
        foreach ($data as $item) {
            $row++;
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, Carbon::parse($item->created_at)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(3, $row, $item->siswa->name ?? '-');
            $sheet->setCellValueByColumnAndRow(4, $row, $item->siswa->kelas->nama_kelas ?? '-');
            $sheet->setCellValueByColumnAndRow(5, $row, $item->kategori ?? '-');
            $sheet->setCellValueByColumnAndRow(6, $row, $item->deskripsi_masalah ?? '-');
            $sheet->setCellValueByColumnAndRow(7, $row, $item->status ?? '-');
        }
        if ($row >= 7) $this->styleDataRows($spreadsheet, 'A7:G' . $row);

        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>18,'F'=>45,'G'=>12] as $col => $width)
            $sheet->getColumnDimension($col)->setWidth($width);

        return $this->downloadExcel($spreadsheet, 'Laporan_Konseling_' . $dari->format('dmY') . '.xlsx');
    }

    public function excelPelanggaran(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);
        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting = $this->getSetting();
        $gurubk = Auth::user();
        $kelas = $kelasFilter ? Kelas::find($kelasFilter) : null;

        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('dicatat_oleh', Auth::id())
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');
        if ($kelasFilter) $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = $this->excelHeader($spreadsheet, 'Laporan Pelanggaran Siswa', $setting, $dari, $sampai, $kelas, $gurubk);

        $headers = ['No', 'Tanggal', 'Nama Siswa', 'Kelas', 'Jenis Pelanggaran', 'Poin', 'Keterangan'];
        foreach ($headers as $i => $h) $sheet->setCellValueByColumnAndRow($i + 1, $row, $h);
        $this->styleHeaderRow($spreadsheet, 'A' . $row . ':G' . $row);

        $no = 1;
        foreach ($data as $item) {
            $row++;
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(3, $row, $item->siswa->name ?? '-');
            $sheet->setCellValueByColumnAndRow(4, $row, $item->siswa->kelas->nama_kelas ?? '-');
            $sheet->setCellValueByColumnAndRow(5, $row, $item->jenisPelanggaran->nama ?? '-');
            $sheet->setCellValueByColumnAndRow(6, $row, $item->poin ?? 0);
            $sheet->setCellValueByColumnAndRow(7, $row, $item->keterangan ?? '-');
        }
        if ($row >= 7) $this->styleDataRows($spreadsheet, 'A7:G' . $row);

        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>32,'F'=>8,'G'=>35] as $col => $width)
            $sheet->getColumnDimension($col)->setWidth($width);

        return $this->downloadExcel($spreadsheet, 'Laporan_Pelanggaran_' . $dari->format('dmY') . '.xlsx');
    }

    public function excelPrestasi(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);
        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting = $this->getSetting();
        $gurubk = Auth::user();
        $kelas = $kelasFilter ? Kelas::find($kelasFilter) : null;

        $query = Prestasi::with(['siswa.kelas'])
            ->where('dicatat_oleh', Auth::id())
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');
        if ($kelasFilter) $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = $this->excelHeader($spreadsheet, 'Laporan Prestasi Siswa', $setting, $dari, $sampai, $kelas, $gurubk);

        $headers = ['No', 'Tanggal', 'Nama Siswa', 'Kelas', 'Nama Prestasi', 'Jenis', 'Tingkat', 'Peringkat', 'Penyelenggara'];
        foreach ($headers as $i => $h) $sheet->setCellValueByColumnAndRow($i + 1, $row, $h);
        $this->styleHeaderRow($spreadsheet, 'A' . $row . ':I' . $row);

        $no = 1;
        foreach ($data as $item) {
            $row++;
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(3, $row, $item->siswa->name ?? '-');
            $sheet->setCellValueByColumnAndRow(4, $row, $item->siswa->kelas->nama_kelas ?? '-');
            $sheet->setCellValueByColumnAndRow(5, $row, $item->nama_prestasi ?? '-');
            $sheet->setCellValueByColumnAndRow(6, $row, $item->jenis ?? '-');
            $sheet->setCellValueByColumnAndRow(7, $row, $item->tingkat ?? '-');
            $sheet->setCellValueByColumnAndRow(8, $row, $item->peringkat ?? '-');
            $sheet->setCellValueByColumnAndRow(9, $row, $item->penyelenggara ?? '-');
        }
        if ($row >= 7) $this->styleDataRows($spreadsheet, 'A7:I' . $row);

        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>35,'F'=>15,'G'=>15,'H'=>15,'I'=>25] as $col => $width)
            $sheet->getColumnDimension($col)->setWidth($width);

        return $this->downloadExcel($spreadsheet, 'Laporan_Prestasi_' . $dari->format('dmY') . '.xlsx');
    }

    public function excelHomeVisit(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);
        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting = $this->getSetting();
        $gurubk = Auth::user();
        $kelas = $kelasFilter ? Kelas::find($kelasFilter) : null;

        $query = HomeVisit::with(['siswa.kelas'])
            ->where('guru_bk_id', Auth::id())
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal');
        if ($kelasFilter) $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $data = $query->get();

        // Cek field HomeVisit
        $first = $data->first();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = $this->excelHeader($spreadsheet, 'Laporan Home Visit', $setting, $dari, $sampai, $kelas, $gurubk);

        $headers = ['No', 'Tanggal', 'Nama Siswa', 'Kelas', 'Alamat', 'Tujuan Kunjungan', 'Hasil Kunjungan'];
        foreach ($headers as $i => $h) $sheet->setCellValueByColumnAndRow($i + 1, $row, $h);
        $this->styleHeaderRow($spreadsheet, 'A' . $row . ':G' . $row);

        $no = 1;
        foreach ($data as $item) {
            $row++;
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(3, $row, $item->siswa->name ?? '-');
            $sheet->setCellValueByColumnAndRow(4, $row, $item->siswa->kelas->nama_kelas ?? '-');
            $sheet->setCellValueByColumnAndRow(5, $row, $item->alamat ?? '-');
            $sheet->setCellValueByColumnAndRow(6, $row, $item->tujuan ?? '-');
            $sheet->setCellValueByColumnAndRow(7, $row, $item->hasil ?? '-');
        }
        if ($row >= 7) $this->styleDataRows($spreadsheet, 'A7:G' . $row);

        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>35,'F'=>35,'G'=>35] as $col => $width)
            $sheet->getColumnDimension($col)->setWidth($width);

        return $this->downloadExcel($spreadsheet, 'Laporan_HomeVisit_' . $dari->format('dmY') . '.xlsx');
    }

    public function excelRekapUmum(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'kelas_id'       => 'nullable|exists:kelas,id',
        ]);
        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
        $kelasFilter = $request->kelas_id;
        $setting = $this->getSetting();
        $gurubk = Auth::user();
        $kelas = $kelasFilter ? Kelas::find($kelasFilter) : null;

        $spreadsheet = new Spreadsheet();

        // ===== SHEET 1: Konseling =====
        $spreadsheet->setActiveSheetIndex(0)->setTitle('Konseling');
        $qK = Konseling::with(['siswa.kelas'])->where('guru_bk_id', Auth::id())->whereBetween('created_at', [$dari, $sampai]);
        if ($kelasFilter) $qK->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelasFilter));
        $konselings = $qK->orderBy('created_at')->get();
        $row = $this->excelHeader($spreadsheet, 'Rekap Umum — Konseling', $setting, $dari, $sampai, $kelas, $gurubk);
        $h = ['No','Tanggal','Nama Siswa','Kelas','Kategori','Deskripsi Masalah','Status'];
        foreach ($h as $i => $v) $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($i+1,$row,$v);
        $this->styleHeaderRow($spreadsheet,'A'.$row.':G'.$row);
        $no=1; foreach ($konselings as $item) { $row++;
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$no++);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2,$row,Carbon::parse($item->created_at)->format('d/m/Y'));
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$item->siswa->name??'-');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$item->siswa->kelas->nama_kelas??'-');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$item->kategori??'-');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$item->deskripsi_masalah??'-');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7,$row,$item->status??'-');
        }
        if ($row>=7) $this->styleDataRows($spreadsheet,'A7:G'.$row);
        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>18,'F'=>45,'G'=>12] as $c=>$w) $spreadsheet->getActiveSheet()->getColumnDimension($c)->setWidth($w);

        // ===== SHEET 2: Pelanggaran =====
        $sheet2 = $spreadsheet->createSheet(); $sheet2->setTitle('Pelanggaran');
        $spreadsheet->setActiveSheetIndex(1);
        $qP = Pelanggaran::with(['siswa.kelas','jenisPelanggaran'])->where('dicatat_oleh',Auth::id())->whereBetween('tanggal',[$dari,$sampai]);
        if ($kelasFilter) $qP->whereHas('siswa',fn($q)=>$q->where('kelas_id',$kelasFilter));
        $pelanggarans = $qP->orderBy('tanggal')->get();
        $row = $this->excelHeader($spreadsheet,'Rekap Umum — Pelanggaran',$setting,$dari,$sampai,$kelas,$gurubk);
        $h = ['No','Tanggal','Nama Siswa','Kelas','Jenis Pelanggaran','Poin','Keterangan'];
        foreach ($h as $i=>$v) $sheet2->setCellValueByColumnAndRow($i+1,$row,$v);
        $this->styleHeaderRow($spreadsheet,'A'.$row.':G'.$row);
        $no=1; foreach ($pelanggarans as $item) { $row++;
            $sheet2->setCellValueByColumnAndRow(1,$row,$no++);
            $sheet2->setCellValueByColumnAndRow(2,$row,Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet2->setCellValueByColumnAndRow(3,$row,$item->siswa->name??'-');
            $sheet2->setCellValueByColumnAndRow(4,$row,$item->siswa->kelas->nama_kelas??'-');
            $sheet2->setCellValueByColumnAndRow(5,$row,$item->jenisPelanggaran->nama??'-');
            $sheet2->setCellValueByColumnAndRow(6,$row,$item->poin??0);
            $sheet2->setCellValueByColumnAndRow(7,$row,$item->keterangan??'-');
        }
        if ($row>=7) $this->styleDataRows($spreadsheet,'A7:G'.$row);
        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>32,'F'=>8,'G'=>35] as $c=>$w) $sheet2->getColumnDimension($c)->setWidth($w);

        // ===== SHEET 3: Prestasi =====
        $sheet3 = $spreadsheet->createSheet(); $sheet3->setTitle('Prestasi');
        $spreadsheet->setActiveSheetIndex(2);
        $qPr = Prestasi::with(['siswa.kelas'])->where('dicatat_oleh',Auth::id())->whereBetween('tanggal',[$dari,$sampai]);
        if ($kelasFilter) $qPr->whereHas('siswa',fn($q)=>$q->where('kelas_id',$kelasFilter));
        $prestasis = $qPr->orderBy('tanggal')->get();
        $row = $this->excelHeader($spreadsheet,'Rekap Umum — Prestasi',$setting,$dari,$sampai,$kelas,$gurubk);
        $h = ['No','Tanggal','Nama Siswa','Kelas','Nama Prestasi','Jenis','Tingkat','Peringkat','Penyelenggara'];
        foreach ($h as $i=>$v) $sheet3->setCellValueByColumnAndRow($i+1,$row,$v);
        $this->styleHeaderRow($spreadsheet,'A'.$row.':I'.$row);
        $no=1; foreach ($prestasis as $item) { $row++;
            $sheet3->setCellValueByColumnAndRow(1,$row,$no++);
            $sheet3->setCellValueByColumnAndRow(2,$row,Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet3->setCellValueByColumnAndRow(3,$row,$item->siswa->name??'-');
            $sheet3->setCellValueByColumnAndRow(4,$row,$item->siswa->kelas->nama_kelas??'-');
            $sheet3->setCellValueByColumnAndRow(5,$row,$item->nama_prestasi??'-');
            $sheet3->setCellValueByColumnAndRow(6,$row,$item->jenis??'-');
            $sheet3->setCellValueByColumnAndRow(7,$row,$item->tingkat??'-');
            $sheet3->setCellValueByColumnAndRow(8,$row,$item->peringkat??'-');
            $sheet3->setCellValueByColumnAndRow(9,$row,$item->penyelenggara??'-');
        }
        if ($row>=7) $this->styleDataRows($spreadsheet,'A7:I'.$row);
        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>35,'F'=>15,'G'=>15,'H'=>15,'I'=>25] as $c=>$w) $sheet3->getColumnDimension($c)->setWidth($w);

        // ===== SHEET 4: Home Visit =====
        $sheet4 = $spreadsheet->createSheet(); $sheet4->setTitle('Home Visit');
        $spreadsheet->setActiveSheetIndex(3);
        $qHV = HomeVisit::with(['siswa.kelas'])->where('guru_bk_id',Auth::id())->whereBetween('tanggal',[$dari,$sampai]);
        if ($kelasFilter) $qHV->whereHas('siswa',fn($q)=>$q->where('kelas_id',$kelasFilter));
        $homeVisits = $qHV->orderBy('tanggal')->get();
        $row = $this->excelHeader($spreadsheet,'Rekap Umum — Home Visit',$setting,$dari,$sampai,$kelas,$gurubk);
        $h = ['No','Tanggal','Nama Siswa','Kelas','Alamat','Tujuan Kunjungan','Hasil Kunjungan'];
        foreach ($h as $i=>$v) $sheet4->setCellValueByColumnAndRow($i+1,$row,$v);
        $this->styleHeaderRow($spreadsheet,'A'.$row.':G'.$row);
        $no=1; foreach ($homeVisits as $item) { $row++;
            $sheet4->setCellValueByColumnAndRow(1,$row,$no++);
            $sheet4->setCellValueByColumnAndRow(2,$row,Carbon::parse($item->tanggal)->format('d/m/Y'));
            $sheet4->setCellValueByColumnAndRow(3,$row,$item->siswa->name??'-');
            $sheet4->setCellValueByColumnAndRow(4,$row,$item->siswa->kelas->nama_kelas??'-');
            $sheet4->setCellValueByColumnAndRow(5,$row,$item->alamat??'-');
            $sheet4->setCellValueByColumnAndRow(6,$row,$item->tujuan??'-');
            $sheet4->setCellValueByColumnAndRow(7,$row,$item->hasil??'-');
        }
        if ($row>=7) $this->styleDataRows($spreadsheet,'A7:G'.$row);
        foreach (['A'=>5,'B'=>13,'C'=>28,'D'=>13,'E'=>35,'F'=>35,'G'=>35] as $c=>$w) $sheet4->getColumnDimension($c)->setWidth($w);

        $spreadsheet->setActiveSheetIndex(0);
        return $this->downloadExcel($spreadsheet, 'Laporan_Rekap_Umum_' . $dari->format('dmY') . '.xlsx');
    }
}