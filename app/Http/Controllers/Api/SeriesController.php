<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{

  public function __construct(private SeriesRepository $seriesRepository)
  {
    # code...
  }

  public function index()
  {
    return Series::all();
  }

  public function store(SeriesFormRequest $request)
  {

    return response()
      ->json($this->seriesRepository->add($request), 201);
  }

  public function show(int $series)
  {
    // $series = Series::whereId($series)
    //   ->with('seasons.episodes')
    //   ->first();
    $seriesModel = Series::with('seasons.episodes')->find($series);
    if ($seriesModel === null) {
      return response()->json(['message' => 'Series not found'], 404);
    }
    return $seriesModel;
  }

  public function update(Series $series, SeriesFormRequest $request)
  {
    $series->fill($request->all());
    $series->save();

    return $series;
  }

  public function destroy(int $series)
  {
    Series::destroy($series);
    return response()->noContent();
  }
}
