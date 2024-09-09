<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TrainingController extends Controller
{
    public function index()
    {
        // Retrieve all trainings ordered by the created date
        $training = Training::orderBy('created_at', 'desc')->get();

        // Add formatted date range to each training
        foreach ($training as $data) {
            $startDate = Carbon::parse($data->tanggal_mulai);
            $endDate = Carbon::parse($data->tanggal_selesai);

            // Check if the start and end dates are in the same month
            if ($startDate->format('F Y') === $endDate->format('F Y')) {
                $formattedStartDate = $startDate->format('j');
                $formattedEndDate = $endDate->format('j');
                $formattedMonth = $startDate->translatedFormat('F');
                $formattedYear = $startDate->translatedFormat('Y');

                $data->formatted_tanggal = "{$formattedMonth} {$formattedStartDate} - {$formattedEndDate} , {$formattedYear}";
            } else {
                // Different months
                $formattedStartDate = $startDate->format('F j');
                $formattedEndDate = $endDate->format('F j ,Y');

                $data->formatted_tanggal = "{$formattedStartDate} - {$formattedEndDate}";
            }
        }

        return view('training.index', compact('training'));
    }
    public function create()
    {
        return view('training.create');

    }

    public function store(Request $request)
    {
        $training = new Training;
        $training->nama_training = $request->nama_training;
        $training->tanggal_mulai = $request->tanggal_mulai;
        $training->tanggal_selesai = $request->tanggal_selesai;
        $training->kode = $request->kode;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/training', $name);
            $training->cover = $name;
        }

        $training->konten = $request->konten;

        $training->save();

        toast('Data has been Created!', 'success')->position('bottom-end');
        return redirect()->route('training.index');
    }

    public function show($id)
    {
        $training = Training::FindOrFail($id);
        return view('training.show', compact('training'));

    }

    public function edit($id)
    {
        $training = Training::FindOrFail($id);
        return view('training.edit', compact('training'));

    }
    public function update(Request $request, $id)
    {
        $training = Training::FindOrFail($id);

        $training->nama_training = $request->nama_training;
        $training->tanggal_mulai = $request->tanggal_mulai;
        $training->tanggal_selesai = $request->tanggal_selesai;
        $training->kode = $request->kode;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/training', $name);
            $training->cover = $name;
        }

        $training->konten = $request->konten;

        $training->save();

        toast('Data has been Updated!', 'success')->position('bottom-end');
        return redirect()->route('training.index');

    }

    public function destroy($id)
    {
        $training = Training::FindOrFail($id);
        $training->delete();

        toast('Data has been Deleted!', 'success')->position('bottom-end');
        return redirect()->route('training.index');

    }
}
