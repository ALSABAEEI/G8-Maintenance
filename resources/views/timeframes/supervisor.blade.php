@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Ongoing Timeframes</h2>

        @if(count($timeframes) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeframes as $timeframe)
                        <tr>
                            <td>{{ $timeframe->Event_Type }}</td>
                            <td>{{ $timeframe->Start_Date }}</td>
                            <td>{{ $timeframe->End_Date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No ongoing timeframes at the moment.</p>
        @endif
    </div>
@endsection
