<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WelcomeController extends Controller
{
    // Helper function to format date with ordinal suffix
    private function formatDateRange($startDate, $endDate)
    {
        // Format tanggal mulai dan selesai
        $formattedStartDate = $this->formatWithOrdinal($startDate);
        $formattedEndDate = $this->formatWithOrdinal($endDate);

        if ($startDate->format('F Y') === $endDate->format('F Y')) {
            $formattedMonth = $startDate->translatedFormat('F');
            $formattedYear = $startDate->translatedFormat('Y');
            return "{$formattedMonth} {$formattedStartDate} - {$formattedEndDate}, {$formattedYear}";
        }

        return "{$startDate->format('F j')} - {$endDate->format('F j, Y')}";
    }

    private function formatWithOrdinal($date)
    {
        $day = $date->day;

        // Determine suffix
        if ($day % 10 == 1 && $day != 11) {
            $suffix = 'st';
        } elseif ($day % 10 == 2 && $day != 12) {
            $suffix = 'nd';
        } elseif ($day % 10 == 3 && $day != 13) {
            $suffix = 'rd';
        } else {
            $suffix = 'th';
        }

        return $date->format('j') . $suffix;
    }

    public function index()
    {
        // Fetching training data once and dividing based on limit
        $trainingData = Training::orderBy('created_at', 'desc')->limit(6)->get();
        $limitTraining = $trainingData->slice(0, 4);
        $limitTrainingfooter = $trainingData->slice(4, 6);

        foreach ($limitTraining as $data) {
            $data->formatted_tanggal_training = $this->formatDateRange(
                Carbon::parse($data->tanggal_mulai),
                Carbon::parse($data->tanggal_selesai)
            );
        }

        foreach ($limitTrainingfooter as $data) {
            $data->formatted_tanggal_training = $this->formatDateRange(
                Carbon::parse($data->tanggal_mulai),
                Carbon::parse($data->tanggal_selesai)
            );
        }

        return view('welcome', compact('limitTraining', 'limitTrainingfooter'));
    }

    public function checkCertificate(Request $request)
    {
        $nomorSertifikatInput = $request->input('nomor_sertifikat') ?? $request->query('nomor_sertifikat');

        $parts = explode('/', str_replace('NO. ', '', $nomorSertifikatInput));

        if (count($parts) !== 4) {
            return view('welcome', [
                'status' => 'danger',
                'message' => 'Format nomor sertifikat tidak valid. Silakan cek kembali.',
            ]);
        }

        $idNamaPenerima = intval($parts[0]);
        $kodeTraining = $parts[1];

        $sertifikat = Sertifikat::with('training')->where('id', $idNamaPenerima)->first();
        $training = Training::where('kode', $kodeTraining)->first();

        $trainingData = Training::orderBy('created_at', 'desc')->limit(6)->get();
        $limitTraining = $trainingData->slice(0, 4);
        $limitTrainingfooter = $trainingData->slice(4, 6);

        foreach ($limitTraining as $data) {
            $data->formatted_tanggal_training = $this->formatDateRange(
                Carbon::parse($data->tanggal_mulai),
                Carbon::parse($data->tanggal_selesai)
            );
        }

        foreach ($limitTrainingfooter as $data) {
            $data->formatted_tanggal_training = $this->formatDateRange(
                Carbon::parse($data->tanggal_mulai),
                Carbon::parse($data->tanggal_selesai)
            );
        }

        if ($sertifikat && $training) {
            $formattedTanggal = $this->formatDateRange(
                Carbon::parse($training->tanggal_mulai),
                Carbon::parse($training->tanggal_selesai)
            );

            $message = "
            <table class='table text-start' style='width:700px; font-weight: bold; color: #105233;'>
                <tr>
                    <th>Nomor Sertifikat</th><th> : </th><th>{$nomorSertifikatInput}</th>
                </tr>
                <tr>
                    <th>Nama Penerima</th><th> : </th><th>{$sertifikat->nama_penerima}</th>
                </tr>
                <tr>
                    <th>Nama Training</th><th> : </th><th>{$training->nama_training}</th>
                </tr>
                <tr>
                    <th>Tanggal Pelatihan</th><th> : </th><th>{$formattedTanggal}</th>
                </tr>
            </table>";

            return redirect(url('/') . '#result')->with([
                'status' => 'success',
                'message' => $message,
            ]);
        }

        return redirect(url('/') . '#sertifikat')->with([
            'status' => 'danger',
            'message' => 'Sertifikat tidak ditemukan. Silakan cek kembali.',
        ]);
    }
}
