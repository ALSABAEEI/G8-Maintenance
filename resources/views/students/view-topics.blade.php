@extends('layouts.app')

@section('title', 'View Topics')

@section('content')
    <div class="container mt-4">
        <h2>View Topics</h2>
        <form action="{{ route('students.search-topics') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="supervisor_id">Select Supervisor:</label>
                <select name="supervisor_id" id="supervisor_id" class="form-control" required>
                    @foreach($supervisors as $supervisorOption)
                        <option value="{{ $supervisorOption->id }}"
                            {{ isset($supervisor) && $supervisor->id == $supervisorOption->id ? 'selected' : '' }}>
                            {{ $supervisorOption->UserName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Search for Topics</button>
        </form>


        @if(isset($topics))
            <h3 class="mt-4">Available Topics for Supervisor: {{ $supervisor->UserName }}</h3>
            <ul class="list-group">
                @forelse($topics as $topic)
                    <li class="list-group-item">
                        <strong>{{ $topic->Topic_Title }}</strong>
                        <p>{{ $topic->Topic_Description }}</p>

                        @if($topic->Status === 'Open')
                        <form action="{{ route('students.apply-topic', $topic->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                          <button type="submit" class="btn btn-success btn-sm">Apply</button>
                        </form>
                        @else
                            <span class="badge bg-secondary">Closed</span>
                        @endif

                    </li>

                @empty
                    <li class="list-group-item">No topics available for this supervisor.</li>
                @endforelse
            </ul>
            @endif
</div>
@endsection
